<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverLogActivity;
use App\Models\CheckPoint;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckInApiController extends Controller
{
    /**
     * Check-in driver ke checkpoint terdekat
     */
    public function checkIn(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $driver = $request->user();
            $lat = $request->latitude;
            $lng = $request->longitude;
            
            \Log::info("Check-in request from driver {$driver->id} at location: $lat, $lng");

            // Cari checkpoint terdekat yang masih aktif
            $nearestCheckpoint = CheckPoint::selectRaw("
                    *,
                    (6371 * acos(cos(radians(?)) * cos(radians(CAST(latitude AS DOUBLE PRECISION))) *
                    cos(radians(CAST(longitude AS DOUBLE PRECISION)) - radians(?)) +
                    sin(radians(?)) * sin(radians(CAST(latitude AS DOUBLE PRECISION))))) AS distance
                ", [$lat, $lng, $lat])
                ->where('status', 'active')
                ->orderByRaw("distance")
                ->first();

            if (!$nearestCheckpoint) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada checkpoint aktif ditemukan.',
                ], 404);
            }

            // Validasi jarak berdasarkan radius checkpoint (dalam km)
            $checkpointRadius = $nearestCheckpoint->radius ?? 1; // Default 1 km jika radius tidak diset
            
            if ($nearestCheckpoint->distance > $checkpointRadius) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda berada di luar radius checkpoint. Jarak: ' . round($nearestCheckpoint->distance, 3) . ' km (Radius: ' . $checkpointRadius . ' km)',
                    'data' => [
                        'nearest_checkpoint' => $nearestCheckpoint->name,
                        'distance_km' => round($nearestCheckpoint->distance, 3),
                        'required_radius_km' => $checkpointRadius,
                        'outside_radius' => true,
                    ],
                ], 400);
            }

            // Cek apakah driver sudah check-in dan belum check-out
            $activeCheckIn = DriverLogActivity::where('driver_id', $driver->id)
                ->where('status', 'on_location')
                ->whereNull('check_Out')
                ->first();

            if ($activeCheckIn) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda masih dalam status check-in di ' . $activeCheckIn->checkPoint->name,
                    'data' => [
                        'active_checkpoint' => $activeCheckIn->checkPoint->name,
                        'check_in_time' => $activeCheckIn->check_In,
                    ],
                ], 400);
            }

            // Create log activity baru
            $logActivity = DriverLogActivity::create([
                'driver_id' => $driver->id,
                'check_point_id' => $nearestCheckpoint->id,
                'status' => 'on_location',
                'check_In' => Carbon::now()->format('Y-m-d H:i:s'),
                'check_Out' => null,
                'last_activity' => 'check_in',
            ]);

            \Log::info("Check-in successful for driver {$driver->id} at checkpoint {$nearestCheckpoint->id}");

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil di ' . $nearestCheckpoint->name,
                'data' => [
                    'log_id' => $logActivity->id,
                    'checkpoint_name' => $nearestCheckpoint->name,
                    'check_in_time' => Carbon::parse($logActivity->check_In)->toIso8601String(),
                    'status' => $logActivity->status,
                    'distance_km' => round($nearestCheckpoint->distance, 3),
                    'checkpoint_radius_km' => $checkpointRadius,
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in checkIn: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan check-in: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get current check-in status
     */
    public function getCurrentStatus(Request $request)
    {
        try {
            $driver = $request->user();

            $activeCheckIn = DriverLogActivity::where('driver_id', $driver->id)
                ->where('status', 'on_location')
                ->whereNull('check_Out')
                ->with('checkPoint')
                ->first();

            if (!$activeCheckIn) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tidak ada check-in aktif',
                    'data' => [
                        'is_checked_in' => false,
                        'checkpoint' => null,
                    ],
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Check-in aktif ditemukan',
                'data' => [
                    'is_checked_in' => true,
                    'log_id' => $activeCheckIn->id,
                    'checkpoint' => [
                        'id' => $activeCheckIn->checkPoint->id,
                        'name' => $activeCheckIn->checkPoint->nama,
                    ],
                    'check_in_time' => Carbon::parse($activeCheckIn->check_In)->toIso8601String(),
                    'status' => $activeCheckIn->status,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in getCurrentStatus: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
