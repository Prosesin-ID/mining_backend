<?php

namespace App\Http\Controllers;

use App\Models\BiayaRute;
use Illuminate\Http\Request;

class BiayaRuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biayaRutes = BiayaRute::all();
        return view('biaya_rute.index', compact('biayaRutes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'biaya' => 'required|numeric',
        ]);

        BiayaRute::create($validated);
        return redirect()->route('biaya_rute.index')
            ->with('success', 'Biaya Rute created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BiayaRute $biayaRute)
    {
        return response()->json([
            'id' => $biayaRute->id,
            'from' => $biayaRute->from,
            'to' => $biayaRute->to,
            'biaya' => $biayaRute->biaya,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BiayaRute $biayaRute)
    {
        $validated = $request->validate([
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'biaya' => 'required|numeric',
        ]);

        $biayaRute->update($validated);
        return redirect()->route('biaya_rute.index')
            ->with('success', 'Biaya Rute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BiayaRute $biayaRute)
    {
        $biayaRute->delete();
        return redirect()->route('biaya_rute.index')
            ->with('success', 'Biaya Rute deleted successfully.');
    }
}
