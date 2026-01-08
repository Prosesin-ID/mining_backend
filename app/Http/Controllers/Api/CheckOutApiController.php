<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverLogActivity;
use App\Models\CheckPoint;
use App\Models\BiayaRute;
use App\Models\DriverRequest;
use App\Models\DriverMoney;
use App\Models\CheckoutActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckOutApiController extends Controller
{
    /**
     * Get active check-in record
     */
    public function getActiveCheckIn(Request $request)
    {
        try {
            $driver = $request->user();
            
            $activeCheckIn = DriverLogActivity::where('driver_id', $driver->id)
                ->where('status', 'on_location')
                ->whereNull('check_Out')
                ->with('checkPoint')
                ->latest()
                ->first();
            
            if (!$activeCheckIn) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada check-in aktif.',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'log_id' => $activeCheckIn->id,
                    'checkpoint_id' => $activeCheckIn->check_point_id,
                    'checkpoint_name' => $activeCheckIn->checkPoint->name ?? 'Checkpoint (ID: ' . $activeCheckIn->check_point_id . ')',
                    'check_in_time' => Carbon::parse($activeCheckIn->check_In)->toIso8601String(),
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in getActiveCheckIn: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data check-in: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get available checkout checkpoints (in radius)
     */
    public function getCheckoutCheckpoints(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);
            
            $lat = $request->latitude;
            $lng = $request->longitude;
            
            // Get checkpoints dalam radius 10km dan aktif
            // Use whereRaw instead of having to avoid PostgreSQL alias issue
            $checkpoints = CheckPoint::selectRaw("
                    *,
                    (6371 * acos(cos(radians(?)) * cos(radians(CAST(latitude AS DOUBLE PRECISION))) *
                    cos(radians(CAST(longitude AS DOUBLE PRECISION)) - radians(?)) +
                    sin(radians(?)) * sin(radians(CAST(latitude AS DOUBLE PRECISION))))) AS distance
                ", [$lat, $lng, $lat])
                ->where('status', 'active')
                ->whereRaw("(6371 * acos(cos(radians(?)) * cos(radians(CAST(latitude AS DOUBLE PRECISION))) *
                    cos(radians(CAST(longitude AS DOUBLE PRECISION)) - radians(?)) +
                    sin(radians(?)) * sin(radians(CAST(latitude AS DOUBLE PRECISION))))) <= 10", [$lat, $lng, $lat])
                ->orderByRaw("(6371 * acos(cos(radians(?)) * cos(radians(CAST(latitude AS DOUBLE PRECISION))) *
                    cos(radians(CAST(longitude AS DOUBLE PRECISION)) - radians(?)) +
                    sin(radians(?)) * sin(radians(CAST(latitude AS DOUBLE PRECISION)))))", [$lat, $lng, $lat])
                ->get();
            
            $data = $checkpoints->map(function ($checkpoint) {
                return [
                    'id' => $checkpoint->id,
                    'name' => $checkpoint->name,
                    'kategori' => $checkpoint->kategori,
                    'distance' => round($checkpoint->distance, 2),
                    'distance_text' => round($checkpoint->distance, 2) . ' km',
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in getCheckoutCheckpoints: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil checkpoint: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Request checkout with route cost calculation
     */
    public function requestCheckout(Request $request)
    {
        try {
            $request->validate([
                'checkout_checkpoint_id' => 'required|exists:check_points,id',
                'nama_material' => 'required|string|max:255',
                'jumlah_kubikasi' => 'required|numeric|min:0',
                'nama_kernet' => 'nullable|string|max:255',
            ]);
            
            $driver = $request->user();
            
            // 1. Get active check-in
            $activeCheckIn = DriverLogActivity::where('driver_id', $driver->id)
                ->where('status', 'on_location')
                ->whereNull('check_Out')
                ->with('checkPoint')
                ->latest()
                ->first();
            
            if (!$activeCheckIn) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada check-in aktif.',
                ], 404);
            }
            
            // 2. Cek pending request
            $pendingRequest = DriverRequest::where('driver_id', $driver->id)
                ->where('request_type', 'pemotongan')
                ->where('status', 'pending')
                ->where('notes', 'like', '%"checkout_log_id":' . $activeCheckIn->id . '%')
                ->first();

            if ($pendingRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memiliki request checkout yang sedang menunggu persetujuan.',
                    'data' => [
                        'request_id' => $pendingRequest->id,
                        'status' => $pendingRequest->status,
                    ],
                ], 400);
            }
            
            // 3. Get checkout checkpoint
            $checkoutCheckpoint = CheckPoint::find($request->checkout_checkpoint_id);
            
            if (!$checkoutCheckpoint) {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkpoint tidak ditemukan.',
                ], 404);
            }
            
            // 4. Get route cost dari BiayaRute
            $checkInCheckpointId = $activeCheckIn->check_point_id;
            $checkOutCheckpointId = $request->checkout_checkpoint_id;
            
            // Get checkpoint names untuk fallback
            $checkInCheckpoint = CheckPoint::find($checkInCheckpointId);
            $checkOutCheckpoint = CheckPoint::find($checkOutCheckpointId);
            
            // Log untuk debugging
            \Log::info("Looking for BiayaRute - From: $checkInCheckpointId ({$checkInCheckpoint->name}), To: $checkOutCheckpointId ({$checkOutCheckpoint->name})");
            
            // Coba cari dengan ID string dulu
            $biayaRute = BiayaRute::where('from', (string)$checkInCheckpointId)
                ->where('to', (string)$checkOutCheckpointId)
                ->first();
            
            // Jika tidak ketemu, coba cari dengan nama checkpoint
            if (!$biayaRute) {
                \Log::info("BiayaRute not found with IDs, trying with names...");
                $biayaRute = BiayaRute::where('from', $checkInCheckpoint->name)
                    ->where('to', $checkOutCheckpoint->name)
                    ->first();
            }
            
            // Log hasil query
            \Log::info("BiayaRute result: " . ($biayaRute ? "Found - Biaya: {$biayaRute->biaya}" : "Not found"));
            
            if (!$biayaRute) {
                return response()->json([
                    'success' => false,
                    'message' => "Biaya rute dari {$checkInCheckpoint->name} ke {$checkOutCheckpoint->name} tidak ditemukan. Hubungi admin.",
                ], 400);
            }
            
            // 5. Buat request pemotongan
            $checkoutData = [
                'checkout_log_id' => $activeCheckIn->id,
                'checkout_checkpoint_id' => $checkOutCheckpointId,
                'nama_material' => $request->nama_material,
                'jumlah_kubikasi' => $request->jumlah_kubikasi,
                'nama_kernet' => $request->nama_kernet,
            ];

            $driverRequest = DriverRequest::create([
                'driver_id' => $driver->id,
                'request_type' => 'pemotongan',
                'amount' => $biayaRute->biaya,
                'status' => 'pending',
                'notes' => json_encode($checkoutData),
            ]);

            \Log::info("Checkout request created for driver {$driver->id}, log {$activeCheckIn->id}");

            return response()->json([
                'success' => true,
                'message' => 'Request checkout berhasil dikirim. Menunggu persetujuan admin.',
                'data' => [
                    'request_id' => $driverRequest->id,
                    'biaya_pemotongan' => $biayaRute->biaya,
                    'status' => 'pending',
                    'from_checkpoint' => $activeCheckIn->checkPoint->name,
                    'to_checkpoint' => $checkoutCheckpoint->name,
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in requestCheckout: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal request checkout: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get checkout request status
     */
    public function getCheckoutStatus(Request $request)
    {
        try {
            $driver = $request->user();
            
            // Cek active check-in
            $activeCheckIn = DriverLogActivity::where('driver_id', $driver->id)
                ->where('status', 'on_location')
                ->whereNull('check_Out')
                ->latest()
                ->first();
            
            if (!$activeCheckIn) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'has_active_checkin' => false,
                        'checkout_request_status' => null,
                    ],
                ]);
            }
            
            // Cek pending/rejected request untuk check-in ini
            $checkoutRequest = DriverRequest::where('driver_id', $driver->id)
                ->where('request_type', 'pemotongan')
                ->where('notes', 'like', '%"checkout_log_id":' . $activeCheckIn->id . '%')
                ->whereIn('status', ['pending', 'rejected'])
                ->latest()
                ->first();
            
            if (!$checkoutRequest) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'has_active_checkin' => true,
                        'checkout_request_status' => null,
                    ],
                ]);
            }
            
            $notes = json_decode($checkoutRequest->notes, true);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'has_active_checkin' => true,
                    'checkout_request_status' => $checkoutRequest->status,
                    'request_id' => $checkoutRequest->id,
                    'biaya_pemotongan' => $checkoutRequest->amount,
                    'checkout_data' => $notes,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getCheckoutStatus: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan status checkout: ' . $e->getMessage(),
            ], 500);
        }
    }
}
