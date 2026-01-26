<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Substation;
use Illuminate\Http\Request;

class SubstationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $substations = Substation::all();
        return view('hse.admin.substations.index', compact('substations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hse.admin.substations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        Substation::create($request->all());

        return redirect()->route('hse.admin_substations.index')
                         ->with('success', 'Substation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Substation $substation)
    {
        return view('hse.admin.substations.show', compact('substation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Substation $substation)
    {
        return view('hse.admin.substations.edit', compact('substation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Substation $substation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $substation->update($request->all());

        return redirect()->route('hse.admin_substations.index')
                         ->with('success', 'Substation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Substation $substation)
    {
        $substation->delete();

        return redirect()->route('hse.admin_substations.index')
                         ->with('success', 'Substation deleted successfully.');
    }
}
