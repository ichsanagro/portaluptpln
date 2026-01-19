<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\KerusakanReport;
use App\Models\Material;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserLogistikController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $myPendingRequests = Peminjaman::where('user_id', $userId)->where('status', 'pending')->count();
        $myApprovedRequests = Peminjaman::where('user_id', $userId)->where('status', 'approved')->count();

        $borrowedQuery = PeminjamanDetail::whereHas('peminjaman', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'approved');
        });
        $totalBorrowed = (clone $borrowedQuery)->sum('jumlah');
        $totalReturned = (clone $borrowedQuery)->sum('returned_jumlah');
        $myBorrowedItems = $totalBorrowed - $totalReturned;

        $recentActivities = Peminjaman::where('user_id', $userId)
            ->with('details.material')
            ->latest()
            ->take(5)
            ->get();

        return view('logistik.userlogistik.dashboard', compact(
            'myPendingRequests',
            'myApprovedRequests',
            'myBorrowedItems',
            'recentActivities'
        ));
    }

    public function peminjaman()
    {
        $all_materials = Material::where('jenis_kebutuhan', 'peminjaman')->get();
        return view('logistik.userlogistik.peminjaman', compact('all_materials'));
    }

    public function permintaan()
    {
        $materials_permintaan = Material::where('jenis_kebutuhan', 'permintaan')->get();
        return view('logistik.userlogistik.permintaan', compact('materials_permintaan'));
    }

    public function storePermintaan(Request $request)
    {
        $request->validate([
            'materials' => 'required|array|min:1',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.jumlah' => 'required|integer|min:1',
            'materials.*.catatan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'jenis_peminjaman' => 'permintaan', // Set the type to 'permintaan'
        ]);

        $materialList = [];
        foreach ($request->materials as $materialData) {
            $material = Material::find($materialData['id']);
            if ($material->stok < $materialData['jumlah']) {
                $peminjaman->delete();
                return redirect()->back()->withErrors(['stok' => 'Stok material ' . $material->nama_material . ' tidak mencukupi.'])->withInput();
            }

            PeminjamanDetail::create([
                'peminjaman_id' => $peminjaman->id,
                'material_id' => $materialData['id'],
                'jumlah' => $materialData['jumlah'],
                'catatan' => $materialData['catatan'] ?? null,
            ]);

            $material->decrement('stok', $materialData['jumlah']);
            $materialList[] = "- {$material->nama_material}: {$materialData['jumlah']} {$material->satuan}";
        }

        // You might want to create a different notification method for permintaan
        $this->sendPeminjamanNotification($peminjaman, $materialList);

        return redirect()->route('logistik.userlogistik.permintaan')->with('success', 'Permintaan material berhasil diajukan.');
    }

    public function pengembalian()
    {
        $userId = auth()->id();

        $peminjamanToReturn = Peminjaman::where('user_id', $userId)
            ->where('status', 'approved')
            // Ensure this Peminjaman has un-returned materials that are of type 'peminjaman'
            ->whereHas('details', function ($query) {
                $query->whereColumn('jumlah', '>', 'returned_jumlah')
                    ->whereHas('material', function ($subQuery) {
                        $subQuery->where('jenis_kebutuhan', 'peminjaman');
                    });
            })
            ->with(['details' => function ($query) {
                // Load only the details that are still returnable
                $query->whereColumn('jumlah', '>', 'returned_jumlah')
                      ->with('material');
            }])
            ->latest()
            ->get();

        return view('logistik.userlogistik.pengembalian', compact('peminjamanToReturn'));
    }

    public function storePengembalian(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'returns' => 'sometimes|array', // 'sometimes' allows empty submissions
            'returns.*.peminjaman_detail_id' => 'required|exists:peminjaman_details,id',
            'returns.*.quantity' => 'required|integer|min:0', // min:0 to allow submitting no change
        ]);

        $peminjamanId = $request->input('peminjaman_id');
        $peminjaman = Peminjaman::findOrFail($peminjamanId);

        // Ensure the peminjaman belongs to the user and is approved
        if ($peminjaman->user_id !== auth()->id() || $peminjaman->status !== 'approved') {
            return redirect()->back()->withErrors('Transaksi peminjaman tidak valid.');
        }

        $totalReturned = 0;
        if ($request->has('returns')) {
            foreach ($request->returns as $detailId => $returnData) {
                // Ensure the quantity is a valid number and > 0
                if (!is_numeric($returnData['quantity']) || $returnData['quantity'] <= 0) {
                    continue;
                }
                
                $quantityToReturn = (int)$returnData['quantity'];
                $totalReturned += $quantityToReturn;

                $peminjamanDetail = PeminjamanDetail::where('id', $detailId)
                                                    ->where('peminjaman_id', $peminjamanId)
                                                    ->firstOrFail();

                $material = Material::findOrFail($peminjamanDetail->material_id);
                $remainingToReturn = $peminjamanDetail->jumlah - $peminjamanDetail->returned_jumlah;

                if ($quantityToReturn > $remainingToReturn) {
                    return redirect()->back()->withErrors(['returns.'.$detailId.'.quantity' => 'Jumlah pengembalian untuk ' . $material->nama_material . ' melebihi jumlah yang dipinjam.'])->withInput();
                }

                $peminjamanDetail->increment('returned_jumlah', $quantityToReturn);
                $material->increment('stok', $quantityToReturn);
            }
        }

        if ($totalReturned === 0) {
            return redirect()->back()->withErrors('Tidak ada jumlah material yang diisi untuk dikembalikan.');
        }

        // After updating all details, check if the parent Peminjaman is fully returned
        $peminjaman->load('details');
        $allDetailsReturned = $peminjaman->details->every(function ($detail) {
            return $detail->jumlah === $detail->returned_jumlah;
        });

        if ($allDetailsReturned) {
            $peminjaman->update(['status' => 'completed']);
        }

        return redirect()->route('logistik.userlogistik.pengembalian')->with('success', 'Material dari Peminjaman ID #' . $peminjamanId . ' berhasil dikembalikan.');
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'materials' => 'required|array|min:1',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.jumlah' => 'required|integer|min:1',
            'materials.*.catatan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(), // Use authenticated user's ID
            'status' => 'pending',
        ]);

        $materialList = [];
        foreach ($request->materials as $materialData) {
            $material = Material::find($materialData['id']);
            if ($material->stok < $materialData['jumlah']) {
                // Not enough stock, rollback and redirect back with error
                $peminjaman->delete(); // Delete the created peminjaman
                return redirect()->back()->withErrors(['stok' => 'Stok material ' . $material->nama_material . ' tidak mencukupi.'])->withInput();
            }

            PeminjamanDetail::create([
                'peminjaman_id' => $peminjaman->id,
                'material_id' => $materialData['id'],
                'jumlah' => $materialData['jumlah'],
                'catatan' => $materialData['catatan'] ?? null,
            ]);

            // Decrement stock
            $material->decrement('stok', $materialData['jumlah']);
            
            // Collect material info for notification
            $materialList[] = "- {$material->nama_material}: {$materialData['jumlah']} {$material->satuan}";
        }

        // Send WhatsApp notification to admin logistik
        $this->sendPeminjamanNotification($peminjaman, $materialList);

        return redirect()->route('logistik.userlogistik.peminjaman')->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    /**
     * Send WhatsApp notification to admin logistik about new peminjaman
     */
    private function sendPeminjamanNotification(Peminjaman $peminjaman, array $materialList)
    {
        try {
            // Get all admin logistik users
            $adminLogistikUsers = User::role('admin logistik')->get();

            if ($adminLogistikUsers->isEmpty()) {
                Log::warning('No admin logistik users found to send notification');
                return;
            }

            $whatsappService = new WhatsAppService();
            $user = auth()->user();
            
            // Format the message
            $materialsText = implode("\n", $materialList);
            $message = "*NOTIFIKASI PEMINJAMAN MATERIAL BARU*\n\n";
            $message .= "📋 *ID Peminjaman:* {$peminjaman->id}\n";
            $message .= "👤 *Peminjam:* {$user->name}\n";
            $message .= "📧 *Email:* {$user->email}\n";
            $message .= "📅 *Tanggal:* " . $peminjaman->created_at->format('d M Y H:i') . "\n";
            $message .= "📊 *Status:* Pending\n\n";
            $message .= "*Material yang Dipinjam:*\n{$materialsText}\n\n";
            $message .= "Silakan cek sistem untuk menyetujui atau menolak peminjaman ini.";

            // Send to all admin logistik
            foreach ($adminLogistikUsers as $admin) {
                if (!empty($admin->phone)) {
                    $formattedPhone = WhatsAppService::formatPhoneNumber($admin->phone);
                    $result = $whatsappService->sendMessage($formattedPhone, $message);
                    
                    if ($result['success']) {
                        Log::info("WhatsApp notification sent to admin: {$admin->name}", [
                            'peminjaman_id' => $peminjaman->id,
                            'admin_phone' => $formattedPhone
                        ]);
                    } else {
                        Log::error("Failed to send WhatsApp notification to admin: {$admin->name}", [
                            'peminjaman_id' => $peminjaman->id,
                            'admin_phone' => $formattedPhone,
                            'error' => $result['error']
                        ]);
                    }
                } else {
                    Log::warning("Admin logistik {$admin->name} does not have a phone number");
                }
            }
        } catch (\Exception $e) {
            Log::error('Error sending peminjaman notification', [
                'peminjaman_id' => $peminjaman->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function kerusakan()
    {
        $userId = auth()->id();

        $peminjamanToReport = Peminjaman::where('user_id', $userId)
            ->whereIn('status', ['approved', 'completed']) // Include completed to see all borrowed items
            // Ensure this Peminjaman has materials that were of type 'peminjaman'
            ->whereHas('details', function ($query) {
                $query->whereColumn('jumlah', '>', 'returned_jumlah')
                    ->whereHas('material', function ($subQuery) {
                        $subQuery->where('jenis_kebutuhan', 'peminjaman');
                    });
            })
            ->with(['details' => function ($query) {
                // Load only the details that are still reportable (not fully returned and are peminjaman type)
                $query->whereColumn('jumlah', '>', 'returned_jumlah')
                    ->whereHas('material', function ($subQuery) {
                        $subQuery->where('jenis_kebutuhan', 'peminjaman');
                    })
                    ->with('material');
            }])
            ->latest()
            ->get();
            
        return view('logistik.userlogistik.kerusakan', compact('peminjamanToReport'));
    }

    public function storeKerusakan(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'reports' => 'sometimes|array',
            'reports.*.file' => 'nullable|file|mimes:pdf|max:2048',
            'reports.*.catatan' => 'nullable|string',
            'reports.*.jumlah_rusak' => 'required_with:reports.*.file|integer|min:1',
        ]);

        $peminjamanId = $request->input('peminjaman_id');
        $peminjaman = Peminjaman::where('id', $peminjamanId)
                                ->where('user_id', auth()->id())
                                ->firstOrFail();

        $reportSubmitted = false;
        if ($request->has('reports')) {
            foreach ($request->reports as $detailId => $reportData) {
                // Only process if either file or jumlah_rusak is provided, or a catatan is given
                if ($request->hasFile("reports.{$detailId}.file") || (isset($reportData['jumlah_rusak']) && $reportData['jumlah_rusak'] > 0) || !empty($reportData['catatan'])) {
                    
                    $peminjamanDetail = PeminjamanDetail::where('id', $detailId)
                                                        ->where('peminjaman_id', $peminjaman->id)
                                                        ->first();

                    if (!$peminjamanDetail) {
                        continue; // Skip if the detail ID is not valid for this peminjaman
                    }

                    $jumlahRusak = (int)($reportData['jumlah_rusak'] ?? 0);

                    // Manual validation for max quantity
                    if ($jumlahRusak > ($peminjamanDetail->jumlah - $peminjamanDetail->returned_jumlah)) {
                        return redirect()->back()->withErrors([
                            "reports.{$detailId}.jumlah_rusak" => "Jumlah rusak untuk " . $peminjamanDetail->material->nama_material . " melebihi sisa material yang belum kembali."
                        ])->withInput();
                    }
                    
                    $filePath = null;
                    if ($request->hasFile("reports.{$detailId}.file")) {
                        $file = $request->file("reports.{$detailId}.file");
                        $filePath = $file->store('kerusakan_reports', 'public');
                    } else if (empty($reportData['catatan'])) {
                         // If no file and no catatan, and jumlah_rusak is there, we still need a file or catatan.
                        return redirect()->back()->withErrors([
                            "reports.{$detailId}.file" => "Laporan kerusakan (PDF) atau Catatan harus diisi jika Jumlah Rusak dilaporkan."
                        ])->withInput();
                    }


                    KerusakanReport::create([
                        'peminjaman_detail_id' => $detailId,
                        'file_path' => $filePath, // Can be null if no file uploaded
                        'catatan' => $reportData['catatan'] ?? null,
                        'jumlah_rusak' => $jumlahRusak,
                    ]);
                    $reportSubmitted = true;
                }
            }
        }

        if (!$reportSubmitted) {
            return redirect()->back()->withErrors(['reports' => 'Anda harus mengisi setidaknya satu laporan kerusakan.']);
        }

        return redirect()->route('logistik.userlogistik.kerusakan')->with('success', 'Laporan kerusakan berhasil dikirim.');
    }

    public function riwayatPeminjaman()
    {
        // Get the authenticated user's ID
        $userId = auth()->id(); // This assumes a user is logged in
        // dd($userId); // Diagnostic 1: Check if userId is correct

        // Fetch all Peminjaman records for the user, eager load details and material info
        $riwayatPeminjaman = Peminjaman::where('user_id', $userId)
            ->with(['details.material'])
            ->latest() // Order by latest borrowings
            ->get();

        // dd($riwayatPeminjaman); // Diagnostic 2: Check fetched data

        return view('logistik.userlogistik.riwayat', compact('riwayatPeminjaman'));
    }
}
