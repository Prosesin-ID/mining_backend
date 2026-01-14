<?php

namespace App\Http\Controllers;

use App\Models\DriverRequest;
use App\Models\DriverMoney;
use App\Models\CheckoutActivity;
use App\Models\DriverLogActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DriverRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'pending');

        $query = DriverRequest::with(['driver'])
            ->orderBy('created_at', 'desc');

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'approved') {
            $query->where('status', 'approved');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected');
        }

        $driverRequests = $query->get();

        // Process each request to get checkpoint info
        foreach ($driverRequests as $driverRequest) {
            if ($driverRequest->request_type === 'pemotongan' && $driverRequest->checkout_data) {
                $checkoutData = $driverRequest->checkout_data;

                // Get checkpoint names
                if (isset($checkoutData['checkout_checkpoint_id'])) {
                    $checkoutCheckpoint = \App\Models\CheckPoint::find($checkoutData['checkout_checkpoint_id']);
                    $driverRequest->to_checkpoint = $checkoutCheckpoint ? $checkoutCheckpoint->name : 'Unknown';
                }

                if (isset($checkoutData['checkout_log_id'])) {
                    $logActivity = \App\Models\DriverLogActivity::find($checkoutData['checkout_log_id']);
                    if ($logActivity && $logActivity->checkPoint) {
                        $driverRequest->from_checkpoint = $logActivity->checkPoint->name;
                    }
                }
            }
        }

        $pendingCount = DriverRequest::where('status', 'pending')->count();
        $approvedCount = DriverRequest::where('status', 'approved')->count();
        $rejectedCount = DriverRequest::where('status', 'rejected')->count();

        return view('driver_requests.index', compact('driverRequests', 'pendingCount', 'approvedCount', 'rejectedCount', 'filter'));
    }
    /**
     * Approve driver request
     */
    public function approve(Request $request, $id)
    {
        $driverRequest = DriverRequest::findOrFail($id);

        // Cek jika sudah diproses
        if ($driverRequest->status !== 'pending') {
            return redirect()->route('driver_requests.index')
                ->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        // Cari atau buat driver money record
        $driverMoney = DriverMoney::where('driver_id', $driverRequest->driver_id)->first();

        if (!$driverMoney) {
            $driverMoney = DriverMoney::create([
                'driver_id' => $driverRequest->driver_id,
                'amount' => 0
            ]);
        }

        // Process berdasarkan tipe request
        if ($driverRequest->request_type === 'top_up') {
            $driverMoney->amount += $driverRequest->amount;
            $driverMoney->save();
        } else if ($driverRequest->request_type === 'pemotongan') {
            \Log::info("Processing pemotongan request ID: {$driverRequest->id}");

            if ($driverMoney->amount >= $driverRequest->amount) {
                $driverMoney->amount -= $driverRequest->amount;
                $driverMoney->save();

                \Log::info("Saldo deducted. Parsing checkout data from notes: " . $driverRequest->notes);

                // Parse checkout data dari notes
                $checkoutData = json_decode($driverRequest->notes, true);

                \Log::info("Parsed checkout data: " . json_encode($checkoutData));

                if (isset($checkoutData['checkout_log_id']) && isset($checkoutData['checkout_checkpoint_id'])) {
                    \Log::info("Creating CheckoutActivity...");

                    // Buat CheckoutActivity record
                    $checkoutActivity = CheckoutActivity::create([
                        'driver_id' => $driverRequest->driver_id,
                        'checkout_time' => Carbon::now(),
                        'check_point_id' => $checkoutData['checkout_checkpoint_id'],
                        'nama_material' => $checkoutData['nama_material'] ?? '',
                        'jumlah_kubikasi' => (int) ($checkoutData['jumlah_kubikasi'] ?? 0),
                        'nama_kernet' => $checkoutData['nama_kernet'] ?? '',
                    ]);

                    \Log::info("CheckoutActivity created with ID: {$checkoutActivity->id}");

                    // Update DriverLogActivity dengan check_Out dan status selesai
                    $logActivity = DriverLogActivity::find($checkoutData['checkout_log_id']);
                    if ($logActivity) {
                        \Log::info("Updating DriverLogActivity ID: {$logActivity->id}");

                        $logActivity->update([
                            'check_Out' => Carbon::now()->toIso8601String(),
                            'status' => 'selesai',
                            'last_activity' => 'check_out',
                        ]);

                        \Log::info("DriverLogActivity updated successfully");
                    } else {
                        \Log::warning("DriverLogActivity not found with ID: {$checkoutData['checkout_log_id']}");
                    }
                } else {
                    \Log::warning("Missing checkout_log_id or checkout_checkpoint_id in notes");
                }
            } else {
                return redirect()->route('driver_requests.index')
                    ->with('error', 'Saldo tidak mencukupi untuk pemotongan.');
            }
        }

        // Update status request (jangan overwrite notes untuk pemotongan)
        $updateData = ['status' => 'approved'];
        if ($driverRequest->request_type !== 'pemotongan') {
            $updateData['notes'] = $request->input('notes', 'Disetujui oleh admin');
        }

        $driverRequest->update($updateData);

        return redirect()->route('driver_requests.index')
            ->with('success', 'Request berhasil di-approve.');
    }

    /**
     * Reject driver request
     */
    public function reject(Request $request, $id)
    {
        $driverRequest = DriverRequest::findOrFail($id);

        // Cek jika sudah diproses
        if ($driverRequest->status !== 'pending') {
            return redirect()->route('driver_requests.index')
                ->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        // Update status dan notes
        $driverRequest->update([
            'status' => 'rejected',
            'notes' => $request->input('notes', 'Ditolak oleh admin'),
        ]);

        return redirect()->route('driver_requests.index')
            ->with('success', 'Request berhasil di-reject.');
    }
}