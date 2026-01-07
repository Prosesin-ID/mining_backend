<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverLogActivity;
use Illuminate\Support\Facades\Log;

class LocationTrackingController extends Controller
{
    /**
     * Update current location for active driver
     */
    public function updateLocation(Request $request)
    {
        try {
            $driver = $request->user();
            
            $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            // Update driver's current location (works even if not checked in)
            $driver->update([
                'current_latitude' => $request->latitude,
                'current_longitude' => $request->longitude,
                'last_location_update' => now(),
            ]);

            // Also update in active log if exists
            $activeLog = DriverLogActivity::where('driver_id', $driver->id)
                ->where('status', 'on_location')
                ->latest('check_In')
                ->first();

            if ($activeLog) {
                $activeLog->update([
                    'current_latitude' => $request->latitude,
                    'current_longitude' => $request->longitude,
                    'last_location_update' => now(),
                ]);
            }

            Log::info("Location updated for driver {$driver->id}: {$request->latitude}, {$request->longitude}");

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasil diupdate',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Update location error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal update lokasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all active driver locations for map monitoring
     */
    public function getActiveLocations()
    {
        try {
            // Get all active drivers (status = active) with their current location
            $activeDrivers = \App\Models\Driver::with('unitTruck')
                ->where('status', 'active')
                ->whereNotNull('current_latitude')
                ->whereNotNull('current_longitude')
                ->get()
                ->map(function ($driver) {
                    // Check if driver has active check-in
                    $activeLog = DriverLogActivity::where('driver_id', $driver->id)
                        ->where('status', 'on_location')
                        ->with('checkPoint')
                        ->latest('check_In')
                        ->first();

                    return [
                        'driver_id' => $driver->id,
                        'driver_name' => $driver->name ?? '-',
                        'plate_number' => $driver->unitTruck->plate_number ?? '-',
                        'checkpoint_name' => $activeLog?->checkPoint?->name ?? 'Belum Check-in',
                        'latitude' => (float) $driver->current_latitude,
                        'longitude' => (float) $driver->current_longitude,
                        'last_update' => $driver->last_location_update,
                        'check_in_time' => $activeLog?->check_In ?? null,
                        'is_checked_in' => $activeLog ? true : false,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $activeDrivers,
                'count' => $activeDrivers->count(),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Get active locations error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lokasi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
