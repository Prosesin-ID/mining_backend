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
     * Get all active checkpoints
     */
    public function getAllCheckpoints(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $lat = $request->latitude;
            $lng = $request->longitude;

            // Ambil semua checkpoint yang aktif dengan perhitungan jarak
            $checkpoints = CheckPoint::selectRaw("
                    *,
                    (6371 * acos(cos(radians(?)) * cos(radians(CAST(latitude AS DOUBLE PRECISION))) *
                    cos(radians(CAST(longitude AS DOUBLE PRECISION)) - radians(?)) +
                    sin(radians(?)) * sin(radians(CAST(latitude AS DOUBLE PRECISION))))) AS distance
                ", [$lat, $lng, $lat])
                ->where('status', 'active')
                ->orderByRaw("distance")
                ->get()
                ->map(function ($checkpoint) {
                    return [
                        'id' => $checkpoint->id,
                        'name' => $checkpoint->name,
                        'kategori' => $checkpoint->kategori,
                        'latitude' => $checkpoint->latitude,
                        'longitude' => $checkpoint->longitude,
                        'radius' => $checkpoint->radius ?? 1,
                        'distance_km' => round($checkpoint->distance, 3),
                        'distance_text' => $checkpoint->distance < 1 
                            ? round($checkpoint->distance * 1000) . ' meter'
                            : round($checkpoint->distance, 2) . ' km',
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Checkpoint list retrieved successfully',
                'data' => [
                    'checkpoints' => $checkpoints,
                    'total' => $checkpoints->count(),
                ],
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in getAllCheckpoints: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data checkpoint: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check-in driver ke checkpoint yang dipilih (TANPA BATASAN JARAK)
     */
    public function checkIn(Request $request)
    {
        try {
            $request->validate([
                'checkpoint_id' => 'required|integer|exists:check_points,id',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $driver = $request->user();
            
            // Validasi status driver
            if ($driver->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda sedang tidak aktif. Silakan hubungi admin.',
                    'data' => [
                        'driver_status' => $driver->status,
                    ],
                ], 403);
            }
            
            $checkpointId = $request->checkpoint_id;
            $lat = $request->latitude;
            $lng = $request->longitude;
            
            \Log::info("Check-in request from driver {$driver->id} to checkpoint {$checkpointId} at location: $lat, $lng");

            // Ambil checkpoint yang dipilih
            $checkpoint = CheckPoint::find($checkpointId);

            if (!$checkpoint || $checkpoint->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkpoint tidak ditemukan atau tidak aktif.',
                ], 404);
            }

            // Hitung jarak ke checkpoint (hanya untuk informasi, tidak untuk validasi)
            $checkpointLat = floatval($checkpoint->latitude);
            $checkpointLng = floatval($checkpoint->longitude);
            
            $distance = $this->calculateDistance($lat, $lng, $checkpointLat, $checkpointLng);

            // VALIDASI RADIUS DIHAPUS - Driver bisa check-in dari jarak berapapun

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
                'check_point_id' => $checkpoint->id,
                'status' => 'on_location',
                'check_In' => Carbon::now()->format('Y-m-d H:i:s'),
                'check_Out' => null,
                'last_activity' => 'check_in',
            ]);

            \Log::info("Check-in successful for driver {$driver->id} at checkpoint {$checkpoint->id} from distance {$distance} km");

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil di ' . $checkpoint->name,
                'data' => [
                    'log_id' => $logActivity->id,
                    'checkpoint_name' => $checkpoint->name,
                    'check_in_time' => Carbon::parse($logActivity->check_In)->toIso8601String(),
                    'status' => $logActivity->status,
                    'distance_km' => round($distance, 3),
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
                        'name' => $activeCheckIn->checkPoint->name,
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

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Radius bumi dalam kilometer

        $latDiff = deg2rad($lat2 - $lat1);
        $lngDiff = deg2rad($lng2 - $lng1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lngDiff / 2) * sin($lngDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Jarak dalam kilometer
    }
}