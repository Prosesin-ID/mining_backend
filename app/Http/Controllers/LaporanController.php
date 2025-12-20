<?php

namespace App\Http\Controllers;

use App\Models\DriverLogActivity;
use App\Models\UnitTruck;
use App\Models\CheckPoint;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = DriverLogActivity::with(['driver.unitTruck', 'checkPoint'])
            ->orderBy('created_at', 'desc');

        // Filter Tanggal Mulai
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('check_In', '>=', $request->tanggal_mulai);
        }

        // Filter Tanggal Akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('check_In', '<=', $request->tanggal_akhir);
        }

        // Filter Unit
        if ($request->filled('unit')) {
            $query->whereHas('driver.unitTruck', function ($q) use ($request) {
                $q->where('no_unit', 'like', '%' . $request->unit . '%');
            });
        }

        // Filter Checkpoint
        if ($request->filled('checkpoint')) {
            $query->whereHas('checkPoint', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->checkpoint . '%');
            });
        }

        $logs = $query->paginate(10)->withQueryString();

        // Data untuk dropdown filter
        $units = UnitTruck::select('no_unit')->distinct()->get();
        $checkpoints = CheckPoint::select('name')->distinct()->get();

        return view('laporan.index', compact('logs', 'units', 'checkpoints'));
    }

    public function exportPdf(Request $request)
    {
        $query = DriverLogActivity::with(['driver.unitTruck', 'checkPoint'])
            ->orderBy('created_at', 'desc');

        // Terapkan filter yang sama
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('check_In', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('check_In', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('unit')) {
            $query->whereHas('driver.unitTruck', function ($q) use ($request) {
                $q->where('unit_number', 'like', '%' . $request->unit . '%');
            });
        }

        if ($request->filled('checkpoint')) {
            $query->whereHas('checkPoint', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->checkpoint . '%');
            });
        }

        $logs = $query->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('logs'));
        return $pdf->download('laporan-aktivitas-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request), 'laporan-aktivitas-' . date('Y-m-d') . '.xlsx');
    }
}