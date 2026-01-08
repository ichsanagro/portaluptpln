<?php

namespace App\Http\Controllers\AdminLogistik;

use App\Http\Controllers\Controller;
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
            return response()->json($materials);
        }

        return view('logistik.adminlogistik.material', compact('materials', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logistik.adminlogistik.create_material');
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
        ]);

        Material::create($request->all());

        return redirect()->route('logistik.adminlogistik.material.index')->with('success', 'Material berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        ]);

        $material = Material::findOrFail($id);
        $material->update($request->all());

        return redirect()->route('logistik.adminlogistik.material.index')->with('success', 'Material berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('logistik.adminlogistik.material.index')->with('success', 'Material berhasil dihapus.');
    }
}
