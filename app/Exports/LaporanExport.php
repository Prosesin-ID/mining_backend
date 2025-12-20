<?php

namespace App\Exports;

use App\Models\DriverLogActivity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = DriverLogActivity::with(['driver.unitTruck', 'checkPoint'])
            ->orderBy('created_at', 'desc');

        // Terapkan filter
        if ($this->request->filled('tanggal_mulai')) {
            $query->whereDate('check_In', '>=', $this->request->tanggal_mulai);
        }

        if ($this->request->filled('tanggal_akhir')) {
            $query->whereDate('check_In', '<=', $this->request->tanggal_akhir);
        }

        if ($this->request->filled('unit')) {
            $query->whereHas('driver.unitTruck', function ($q) {
                $q->where('unit_number', 'like', '%' . $this->request->unit . '%');
            });
        }

        if ($this->request->filled('checkpoint')) {
            $query->whereHas('checkPoint', function ($q) {
                $q->where('name', 'like', '%' . $this->request->checkpoint . '%');
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Unit',
            'Driver',
            'No. Telp',
            'Checkpoint',
            'Kategori',
            'Check-In',
            'Check-Out',
            'Durasi (Menit)',
            'Status',
            'Validasi'
        ];
    }

    public function map($log): array
    {
        static $no = 0;
        $no++;

        $durasi = '-';
        if ($log->check_Out) {
            $checkIn = \Carbon\Carbon::parse($log->check_In);
            $checkOut = \Carbon\Carbon::parse($log->check_Out);
            $durasi = $checkIn->diffInMinutes($checkOut) . ' menit';
        }

        return [
            $no,
            $log->driver->unitTruck->unit_number ?? 'N/A',
            $log->driver->name,
            $log->driver->phone,
            $log->checkPoint->name,
            $log->checkPoint->kategori,
            \Carbon\Carbon::parse($log->check_In)->format('d/m/Y H:i:s'),
            $log->check_Out ? \Carbon\Carbon::parse($log->check_Out)->format('d/m/Y H:i:s') : '-',
            $durasi,
            $log->status === 'selesai' ? 'Selesai' : 'On Location',
            $log->status === 'selesai' ? 'Valid' : 'On Location'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFC000']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Aktivitas';
    }
}