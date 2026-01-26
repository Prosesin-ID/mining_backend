<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckPoint;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    /**
     * Get home data (driver info, truck, saldo, status)
     */
    public function index(Request $request)
    {
        $driver = $request->user();
        
        // Load relationships
        $driver->load(['unitTruck', 'driverMoney']);
        
        $homeData = [
            'driver' => [
                'id' => $driver->id,
                'name' => $driver->name,
                'email' => $driver->email,
                'phone' => $driver->phone,
                'own_type' => $driver->own_type,
                'nama_pemilik' => $driver->nama_pemilik,
                'status' => $driver->status,
            ],
            'truck' => $driver->unitTruck ? [
                'id' => $driver->unitTruck->id,
                'no_unit' => $driver->unitTruck->no_unit,
                'plate_number' => $driver->unitTruck->plate_number,
                'status' => $driver->unitTruck->status,
            ] : null,
            'saldo' => $driver->driverMoney ? [
                'id' => $driver->driverMoney->id,
                'driver_id' => $driver->driverMoney->driver_id,
                'amount' => $driver->driverMoney->amount,
            ] : null,
        ];

        return response()->json([
            'success' => true,
            'data' => $homeData,
        ], 200);
    }

    /**
     * Get today's activity history
     */
    public function todayHistory(Request $request)
    {
        $driver = $request->user();
        
        $today = now()->format('Y-m-d');
        
        $activities = $driver->logActivities()
            ->with('checkPoint')
            ->where('check_In', 'LIKE', $today . '%')
            ->orderBy('check_In', 'desc')
            ->get();

        $history = $activities->map(function ($activity) {
            return [
                'id' => $activity->id,
                'checkpoint_name' => $activity->checkPoint->name,
                'status' => $activity->status,
                'last_activity' => $activity->last_activity,
                'check_in' => $activity->check_In,
                'check_out' => $activity->check_Out,
                'duration' => $this->calculateDuration($activity->check_In, $activity->check_Out),
                'time' => \Carbon\Carbon::parse($activity->check_In)->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $history,
        ], 200);
    }

    /**
     * Get nearby checkpoints
     */
    public function nearbyCheckpoints(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'radius' => 'nullable|numeric',
            ]);

            $lat = $request->latitude;
            $lng = $request->longitude;
            $radius = $request->radius ?? 10;

            \Log::info("Searching checkpoints near: Lat=$lat, Lng=$lng, Radius=$radius km");

            $checkpoints = CheckPoint::selectRaw("
                *,
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$lat, $lng, $lat])
                ->whereRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) < ?", [$lat, $lng, $lat, $radius])
                ->where('status', 'active')
                ->orderByRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))", [$lat, $lng, $lat])
                ->limit(10)
                ->get();

            \Log::info("Found {$checkpoints->count()} checkpoints");

            $nearby = $checkpoints->map(function ($checkpoint) {
                return [
                    'id' => $checkpoint->id,
                    'name' => $checkpoint->name,
                    'kategori' => $checkpoint->kategori,
                    'latitude' => $checkpoint->latitude,
                    'longitude' => $checkpoint->longitude,
                    'distance' => round($checkpoint->distance, 2),
                    'distance_text' => $checkpoint->distance < 1 
                        ? round($checkpoint->distance * 1000) . 'm' 
                        : round($checkpoint->distance, 1) . 'km',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $nearby,
            ], 200);
        } catch (\Exception $e) {
            \Log::error("Error in nearbyCheckpoints: " . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil checkpoint terdekat: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Turn off driver status (also sets truck to maintenance)
     */
    public function turnOffStatus(Request $request)
    {
        $driver = $request->user();
        
        $validReasons = [
            'Rusak Mesin',
            'Pecah Ban',
            'Perawatan Rutin',
            'Kendala Lalu Lintas',
            'Lainnya'
        ];
        
        $request->validate([
            'reason_type' => 'required|string|in:' . implode(',', $validReasons),
            'reason_detail' => 'required_if:reason_type,Lainnya|nullable|string|max:255',
        ]);

        $unitTruck = $driver->unitTruck;

        if (!$unitTruck) {
            return response()->json([
                'success' => false,
                'message' => 'Driver tidak memiliki unit truck terdaftar.',
            ], 400);
        }
        
        // Build the reason text
        $reasonMaintenance = $request->reason_type;
        if ($request->reason_type === 'Lainnya' && $request->reason_detail) {
            $reasonMaintenance = 'Lainnya: ' . $request->reason_detail;
        }
        
        // Set truck to maintenance
        $unitTruck->update([
            'status' => 'maintenance',
            'reason_maintenance' => $reasonMaintenance,
            'maintenance_start_time' => now(),
        ]);

        // Set driver to inactive
        $driver->status = 'inactive';
        $driver->save();

        return response()->json([
            'success' => true,
            'message' => 'Status driver telah diubah menjadi inactive dan unit dalam maintenance.',
        ], 200);
    }

    /**
     * Turn on driver status (also clears maintenance if truck was in maintenance)
     */
    public function turnOnStatus(Request $request)
    {
        $driver = $request->user();
        $unitTruck = $driver->unitTruck;
        
        // If unit truck exists and is in maintenance, clear it
        if ($unitTruck && $unitTruck->status === 'maintenance') {
            $unitTruck->update([
                'status' => 'active',
                'reason_maintenance' => null,
                'maintenance_start_time' => null,
                'maintenance_end_time' => now(),
            ]);
        }
        
        // Set driver to active
        $driver->status = 'active';
        $driver->save();

        return response()->json([
            'success' => true,
            'message' => 'Status driver telah diubah menjadi active.',
        ], 200);
    }

    /**
     * Calculate duration between check-in and check-out
     */
    private function calculateDuration($checkIn, $checkOut)
    {
        if (!$checkOut) {
            return null;
        }

        $start = \Carbon\Carbon::parse($checkIn);
        $end = \Carbon\Carbon::parse($checkOut);
        
        $diff = $start->diff($end);
        
        if ($diff->h > 0) {
            return $diff->h . 'j ' . $diff->i . 'm';
        }
        
        return $diff->i . 'm';
    }
}