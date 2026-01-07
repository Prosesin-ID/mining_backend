<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverRequest;
use Illuminate\Http\Request;

class RequestSaldoController extends Controller
{
    /**
     * Request top up saldo
     * Driver hanya bisa request, approval dilakukan di web admin
     */
    public function topUp(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:10000', // Minimal Rp 10.000
            ]);

            $driver = $request->user();
            
            // Create driver request
            $driverRequest = DriverRequest::create([
                'driver_id' => $driver->id,
                'request_type' => 'top_up',
                'amount' => $request->amount,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Request top up berhasil dibuat. Menunggu approval admin.',
                'data' => [
                    'id' => $driverRequest->id,
                    'request_type' => $driverRequest->request_type,
                    'amount' => (float) $driverRequest->amount,
                    'status' => $driverRequest->status,
                    'created_at' => $driverRequest->created_at->format('Y-m-d H:i:s'),
                ],
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in topUp: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat request top up: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get pending requests for current driver
     */
    public function myRequests(Request $request)
    {
        try {
            $driver = $request->user();
            
            \Log::info('Fetching requests for driver_id: ' . $driver->id);
            
            $requests = DriverRequest::where('driver_id', $driver->id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            \Log::info('Found ' . $requests->count() . ' requests');
            
            $mappedRequests = $requests->map(function ($req) {
                return [
                    'id' => $req->id,
                    'request_type' => $req->request_type,
                    'amount' => (float) $req->amount,
                    'status' => $req->status ?? 'pending',
                    'notes' => $req->notes,
                    'created_at' => $req->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $req->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $mappedRequests,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in myRequests: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data request: ' . $e->getMessage(),
            ], 500);
        }
    }
}
