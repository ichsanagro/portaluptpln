<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
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
        return view('logistik.userlogistik.dashboard');
    }

    public function peminjaman()
    {
        $all_materials = Material::all();
        return view('logistik.userlogistik.peminjaman', compact('all_materials'));
    }

    public function pengembalian()
    {
        $userId = auth()->id();

        $itemsToReturn = PeminjamanDetail::whereHas('peminjaman', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('status', 'approved'); // Only approved borrowings can be returned
            })
            ->whereColumn('jumlah', '>', 'returned_jumlah') // Only items not fully returned
            ->with(['peminjaman', 'material'])
            ->get();
            
        return view('logistik.userlogistik.pengembalian', compact('itemsToReturn'));
    }

    public function storePengembalian(Request $request)
    {
        $request->validate([
            'returns' => 'required|array|min:1',
            'returns.*.peminjaman_detail_id' => 'required|exists:peminjaman_details,id',
            'returns.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->returns as $returnData) {
            $peminjamanDetail = PeminjamanDetail::findOrFail($returnData['peminjaman_detail_id']);
            $material = Material::findOrFail($peminjamanDetail->material_id);

            $quantityToReturn = $returnData['quantity'];
            $remainingToReturn = $peminjamanDetail->jumlah - $peminjamanDetail->returned_jumlah;

            if ($quantityToReturn > $remainingToReturn) {
                return redirect()->back()->withErrors('Jumlah pengembalian untuk ' . $material->nama_material . ' melebihi jumlah yang belum dikembalikan.')->withInput();
            }

            // Update returned_jumlah in PeminjamanDetail
            $peminjamanDetail->increment('returned_jumlah', $quantityToReturn);
            // Increment material stock
            $material->increment('stok', $quantityToReturn);
            
            // Check if this PeminjamanDetail is fully returned
            if ($peminjamanDetail->jumlah === $peminjamanDetail->returned_jumlah) {
                // Optionally update a status for PeminjamanDetail if needed, e.g., 'completed'
                // For simplicity, we just rely on 'jumlah' vs 'returned_jumlah' for now.
            }
        }

        // After updating all details, check if the parent Peminjaman is fully returned
        $peminjaman = $peminjamanDetail->peminjaman; // Get the parent peminjaman from the last detail
        $allDetailsReturned = $peminjaman->details->every(function ($detail) {
            return $detail->jumlah === $detail->returned_jumlah;
        });

        if ($allDetailsReturned) {
            $peminjaman->update(['status' => 'completed']);
        }

        return redirect()->route('logistik.userlogistik.pengembalian')->with('success', 'Material berhasil dikembalikan.');
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'materials' => 'required|array|min:1',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.jumlah' => 'required|integer|min:1',
        ]);

        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(), // Use authenticated user's ID
            'tanggal_peminjaman' => now(),
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
            $message .= "📅 *Tanggal:* " . $peminjaman->tanggal_peminjaman->format('d M Y H:i') . "\n";
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
