<?php

namespace App\Http\Controllers;

use App\Models\UnitTruck;
use Illuminate\Http\Request;

class UnitTruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucks = UnitTruck::with(['bank', 'driver'])->get();
        return view('unit_trucks.index', compact('trucks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255',
            'bank_id' => 'required|exists:banks,id',
            'driver_id' => 'required|exists:drivers,id',
            'bank_account_number' => 'required|string|max:255',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        // Ambil no_unit terakhir
        $lastUnit = UnitTruck::orderBy('id', 'desc')->first();

        if ($lastUnit) {
            // Ambil angka dari TRK-XXX
            $lastNumber = intval(substr($lastUnit->no_unit, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format jadi TRK-001
        $newNoUnit = 'TRK-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $validated['no_unit'] = $newNoUnit;

        UnitTruck::create($validated);

        return redirect()->route('unit_trucks.index')
            ->with('success', 'Unit Truck created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(UnitTruck $unitTruck)
    {
        //
    }

    public function endMaintenance(Request $request, UnitTruck $unitTruck)
    {
        $unitTruck->update([
            'status' => 'active',
            'reason_maintenance' => null,
            'maintenance_start_time' => null,
            'maintenance_end_time' => now(),
        ]);

        // Also set driver status to active
        $driver = $unitTruck->driver;
        if ($driver) {
            $driver->status = 'active';
            $driver->save();
        }

        return redirect()->route('unit_trucks.index')
            ->with('success', 'Maintenance ended and statuses updated successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitTruck $unitTruck)
    {
        $unitTruck->load(['bank', 'driver']);

        return response()->json([
            'id' => $unitTruck->id,
            'no_unit' => $unitTruck->no_unit,
            'plate_number' => $unitTruck->plate_number,
            'bank_id' => $unitTruck->bank_id,
            'driver_id' => $unitTruck->driver_id,
            'bank_account_number' => $unitTruck->bank_account_number,
            'status' => $unitTruck->status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitTruck $unitTruck)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255',
            'bank_id' => 'required|exists:banks,id',
            'driver_id' => 'required|exists:drivers,id',
            'bank_account_number' => 'required|string|max:255',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        // Pastikan no_unit tetap yang lama
        $validated['no_unit'] = $unitTruck->no_unit;

        $unitTruck->update($validated);

        return redirect()->route('unit_trucks.index')
            ->with('success', 'Unit Truck updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitTruck $unitTruck)
    {
        $unitTruck->delete();

        return redirect()->route('unit_trucks.index')->with('success', 'Unit Truck deleted successfully.');
    }
}
