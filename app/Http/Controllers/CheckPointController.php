<?php

namespace App\Http\Controllers;

use App\Models\CheckPoint;
use Illuminate\Http\Request;

class CheckPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkPoints = CheckPoint::all();
        return view('checkpoints.index', compact('checkPoints'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kategori' => 'required|in:bongkar,quarry',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        CheckPoint::create($validated);

        return redirect()->route('checkpoints.index')
                         ->with('success', 'CheckPoint created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CheckPoint $checkPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $checkPoint = CheckPoint::findOrFail($id);
        
        return response()->json([
            'id' => $checkPoint->id,
            'name' => $checkPoint->name,
            'kategori' => $checkPoint->kategori,
            'latitude' => $checkPoint->latitude,
            'longitude' => $checkPoint->longitude,
            'radius' => $checkPoint->radius,
            'status' => $checkPoint->status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $checkPoint = CheckPoint::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kategori' => 'required|in:bongkar,quarry',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $checkPoint->update($validated);

        return redirect()->route('checkpoints.index')
                         ->with('success', 'CheckPoint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $checkPoint = CheckPoint::findOrFail($id);
        $checkPoint->delete();

        return redirect()->route('checkpoints.index')
                         ->with('success', 'CheckPoint deleted successfully.');
    }
}