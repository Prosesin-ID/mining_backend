<?php

namespace App\Http\Controllers;

use App\Models\DriverRequest;
use App\Models\DriverMoney;
use Illuminate\Http\Request;

class DriverRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $driverRequests = DriverRequest::with('driver')->orderBy('created_at', 'desc')->get();
        return view('driver_requests.index', compact('driverRequests'));
    }

    /**
     * Approve driver request
     */
    public function approve($id)
    {
        $driverRequest = DriverRequest::findOrFail($id);
        
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
            if ($driverMoney->amount >= $driverRequest->amount) {
                $driverMoney->amount -= $driverRequest->amount;
                $driverMoney->save();
            } else {
                return redirect()->route('driver_requests.index')
                    ->with('error', 'Saldo tidak mencukupi untuk pemotongan.');
            }
        }

        // Hapus request setelah diproses
        $driverRequest->delete();

        return redirect()->route('driver_requests.index')
            ->with('success', 'Request berhasil di-approve.');
    }

    /**
     * Reject driver request
     */
    public function reject($id)
    {
        $driverRequest = DriverRequest::findOrFail($id);
        $driverRequest->delete();

        return redirect()->route('driver_requests.index')
            ->with('success', 'Request berhasil di-reject.');
    }
}