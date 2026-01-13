<?php

namespace App\Http\Controllers\AdminLogistik;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $materials = Material::when($search, function ($query, $search) {
            return $query->where('nama_material', 'like', '%' . $search . '%');
        })->get();

        if ($request->ajax()) {
            return response()->json(['materials' => $materials]);
        }

        return view('logistik.adminlogistik.material', compact('materials', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = Material::findOrFail($id);
        return response()->json($material);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_material' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'spesifikasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_kebutuhan' => 'required|in:peminjaman,permintaan',
            'lokasi' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ]);

        $data = $request->except('foto');

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('materials', $filename, 'public');
            $data['foto'] = $path;
        }

        Material::create($data);

        return redirect()->route('logistik.adminlogistik.material.index')->with('success', 'Material berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material = Material::findOrFail($id);
        return view('logistik.adminlogistik.edit_material', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_material' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'spesifikasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_kebutuhan' => 'required|in:peminjaman,permintaan',
            'lokasi' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ]);

        $material = Material::findOrFail($id);
        $data = $request->except('foto');

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($material->foto && \Storage::disk('public')->exists($material->foto)) {
                \Storage::disk('public')->delete($material->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('materials', $filename, 'public');
            $data['foto'] = $path;
        }

        $material->update($data);

        return redirect()->route('logistik.adminlogistik.material.index')->with('success', 'Material berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        
        // Delete foto if exists
        if ($material->foto && \Storage::disk('public')->exists($material->foto)) {
            \Storage::disk('public')->delete($material->foto);
        }
        
        $material->delete();

        return redirect()->route('logistik.adminlogistik.material.index')->with('success', 'Material berhasil dihapus.');
    }

    public function riwayatPesanan()
    {
        // Fetch all peminjaman with related user and details
        $peminjamans = Peminjaman::with('user', 'details.material')->latest()->get();

        return view('logistik.adminlogistik.riwayat-pesanan', compact('peminjamans'));
    }

    public function showPeminjaman(string $id)
    {
        $peminjaman = Peminjaman::with('user', 'details.material')->findOrFail($id);
        return response()->json($peminjaman);
    }

    public function approvePeminjaman(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Only allow approving pending requests
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->withErrors('Permintaan tidak dalam status "pending".');
        }

        $peminjaman->update(['status' => 'approved']);

        return redirect()->route('logistik.adminlogistik.riwayat-pesanan')->with('success', 'Permintaan peminjaman berhasil disetujui.');
    }

    public function rejectPeminjaman(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Only allow rejecting pending requests
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->withErrors('Permintaan tidak dalam status "pending".');
        }
        
        // Revert material stock for rejected requests
        foreach ($peminjaman->details as $detail) {
            $material = Material::find($detail->material_id);
            if ($material) {
                $material->increment('stok', $detail->jumlah);
            }
        }

        $peminjaman->update(['status' => 'rejected']);

        return redirect()->route('logistik.adminlogistik.riwayat-pesanan')->with('success', 'Permintaan peminjaman berhasil ditolak dan stok dikembalikan.');
    }
}
