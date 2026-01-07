<?php

namespace App\Http\Controllers;

use App\Models\DriverLogActivity;
use Illuminate\Http\Request;

class DriverLogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = DriverLogActivity::with(['driver.unitTruck', 'checkPoint'])
            ->latest()
            ->get();
        return view('driver_log_activities.index', compact('logs'));
    }

    public function fliterByDate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $logs = DriverLogActivity::with(['driver.unitTruck', 'checkPoint'])
            ->whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->get();

        return view('driver_log_activities.index', compact('logs'));
    }
}
