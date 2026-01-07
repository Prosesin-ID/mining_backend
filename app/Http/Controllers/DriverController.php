<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::with('unitTruck')->get();
        return view('drivers.index', compact('drivers'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:drivers,email',
            'password' => 'required|string|min:8',
            'own_type' => 'required|in:PT/perusahaan,perseorangan',
            'nama_pemilik' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,ditangguhkan',
        ]);

        Driver::create($validated);

        return redirect()->route('drivers.index')
                         ->with('success', 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        
        return response()->json([
            'id' => $driver->id,
            'name' => $driver->name,
            'phone' => $driver->phone,
            'email' => $driver->email,
            'own_type' => $driver->own_type,
            'nama_pemilik' => $driver->nama_pemilik,
            'status' => $driver->status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:drivers,email,' . $driver->id,
            'password' => 'nullable|string|min:8',
            'own_type' => 'required|in:PT/perusahaan,perseorangan',
            'nama_pemilik' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,ditangguhkan',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $driver->update($validated);

        return redirect()->route('drivers.index')
                         ->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('drivers.index')
                         ->with('success', 'Driver deleted successfully.');
    }
}
