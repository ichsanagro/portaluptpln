<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;

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
        return view('logistik.userlogistik.pengembalian');
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
        }

        return redirect()->route('logistik.userlogistik.peminjaman')->with('success', 'Permintaan peminjaman berhasil diajukan.');
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
