<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverMoney;
use Illuminate\Http\Request;

class DriverMoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::with(['driverMoney', 'driverRequests', 'unitTruck'])->get();
        return view('driver_money.index', compact('drivers'));
    }

    /**
     * Top up driver balance
     */
    public function topUp(Request $request, $driverMoneyId)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Cari atau buat driver money record
        $driverMoney = DriverMoney::where('driver_id', $validated['driver_id'])->first();
        
        if (!$driverMoney) {
            // Buat baru jika belum ada
            $driverMoney = DriverMoney::create([
                'driver_id' => $validated['driver_id'],
                'amount' => $validated['amount']
            ]);
        } else {
            // Update jika sudah ada
            $driverMoney->amount += $validated['amount'];
            $driverMoney->save();
        }

        return redirect()->route('driver_money.index')
            ->with('success', 'Top-up berhasil dilakukan.');
    }
}