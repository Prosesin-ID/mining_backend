@extends('layouts.app')

@section('content')
<style>
    .filter-section {
        background: #1a1a1a;
        border: 1px solid #D4AF37;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        color: #D4AF37;
        font-size: 18px;
        font-weight: 600;
    }

    .filter-title svg {
        width: 22px;
        height: 22px;
        fill: #D4AF37;
    }

    .form-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 8px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .form-control {
        background: #0a0a0a;
        border: 1px solid #333;
        color: #fff;
        padding: 10px 15px;
        border-radius: 6px;
    }

    .form-control:focus {
        background: #0a0a0a;
        border-color: #D4AF37;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15);
    }

    .form-control::placeholder {
        color: #555;
    }

    .btn-filter {
        background: #D4AF37;
        color: #000;
        font-weight: 600;
        padding: 10px 30px;
        border: none;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .btn-filter:hover {
        background: #c9a532;
        transform: translateY(-2px);
    }

    .btn-reset {
        background: #2a2a2a;
        color: #fff;
        font-weight: 600;
        padding: 10px 30px;
        border: 1px solid #444;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .btn-reset:hover {
        background: #333;
        border-color: #555;
    }

    .export-card {
        background: #1a1a1a;
        border-radius: 12px;
        padding: 25px;
        height: 100%;
        transition: all 0.3s;
    }

    .export-card.pdf-card {
        border: 1px solid #D4AF37;
    }

    .export-card.excel-card {
        border: 1px solid #10b981;
    }

    .export-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .export-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .export-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .export-icon.pdf {
        background: rgba(212, 175, 55, 0.1);
    }

    .export-icon.excel {
        background: rgba(16, 185, 129, 0.1);
    }

    .export-icon svg {
        width: 28px;
        height: 28px;
    }

    .export-icon.pdf svg {
        fill: #D4AF37;
    }

    .export-icon.excel svg {
        fill: #10b981;
    }

    .export-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .export-desc {
        font-size: 13px;
        color: #888;
        margin: 0;
    }

    .btn-export {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
    }

    .btn-export.pdf {
        background: #D4AF37;
        color: #000;
    }

    .btn-export.pdf:hover {
        background: #c9a532;
        transform: translateY(-2px);
    }

    .btn-export.excel {
        background: #10b981;
        color: #fff;
    }

    .btn-export.excel:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    .btn-export svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .preview-section {
        background: #1a1a1a;
        border-radius: 12px;
        overflow: hidden;
    }

    .preview-header {
        padding: 20px 25px;
        border-bottom: 1px solid #2a2a2a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .preview-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #fff;
    }

    .preview-header svg {
        width: 22px;
        height: 22px;
        fill: #D4AF37;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        font-size: 13px;
    }

    .data-table thead {
        background: #0a0a0a;
    }

    .data-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #D4AF37;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #2a2a2a;
    }

    .data-table td {
        padding: 15px;
        border-bottom: 1px solid #2a2a2a;
        color: #ccc;
    }

    .data-table tbody tr {
        transition: all 0.2s;
    }

    .data-table tbody tr:hover {
        background: rgba(212, 175, 55, 0.05);
    }

    .cell-with-icon {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cell-with-icon svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-valid {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }

    .badge-onlocation {
        background: rgba(212, 175, 55, 0.15);
        color: #D4AF37;
    }

    .duration-text {
        color: #D4AF37;
        font-weight: 600;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #666;
    }

    .pagination-wrapper {
        padding: 20px 25px;
        border-top: 1px solid #2a2a2a;
    }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="mb-4">
        <h1 style="color: #D4AF37; font-size: 28px; font-weight: 700; margin-bottom: 5px;">LAPORAN</h1>
        <p style="color: #888; font-size: 14px; margin: 0;">Generate dan export laporan aktivitas</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <svg viewBox="0 0 20 20">
                <path d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"/>
            </svg>
            FILTER LAPORAN
        </div>

        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">TANGGAL MULAI</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">TANGGAL AKHIR</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">UNIT</label>
                    <input type="text" name="unit" class="form-control" placeholder="Semua Unit" value="{{ request('unit') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">CHECKPOINT</label>
                    <input type="text" name="checkpoint" class="form-control" placeholder="Semua Checkpoint" value="{{ request('checkpoint') }}">
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-filter">Filter</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-reset">Reset</a>
            </div>
        </form>
    </div>

    <!-- Export Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="export-card pdf-card">
                <div class="export-header">
                    <div class="export-icon pdf">
                        <svg viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="export-title">EXPORT PDF</h3>
                        <p class="export-desc">Download laporan dalam format PDF untuk dokumentasi</p>
                    </div>
                </div>
                <form action="{{ route('laporan.export.pdf') }}" method="GET">
                    <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    <input type="hidden" name="unit" value="{{ request('unit') }}">
                    <input type="hidden" name="checkpoint" value="{{ request('checkpoint') }}">
                    <button type="submit" class="btn btn-export pdf">
                        <svg viewBox="0 0 20 20">
                            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                        </svg>
                        DOWNLOAD PDF
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="export-card excel-card">
                <div class="export-header">
                    <div class="export-icon excel">
                        <svg viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="export-title">EXPORT EXCEL</h3>
                        <p class="export-desc">Download laporan dalam format Excel untuk analisis data</p>
                    </div>
                </div>
                <form action="{{ route('laporan.export.excel') }}" method="GET">
                    <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    <input type="hidden" name="unit" value="{{ request('unit') }}">
                    <input type="hidden" name="checkpoint" value="{{ request('checkpoint') }}">
                    <button type="submit" class="btn btn-export excel">
                        <svg viewBox="0 0 20 20">
                            <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                        </svg>
                        DOWNLOAD EXCEL
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Table -->
    <div class="preview-section">
        <div class="preview-header">
            <svg viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
            </svg>
            <h3>PREVIEW LAPORAN</h3>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>UNIT</th>
                        <th>DRIVER</th>
                        <th>CHECKPOINT</th>
                        <th>CHECK-IN</th>
                        <th>CHECK-OUT</th>
                        <th>DURASI</th>
                        <th>VALIDASI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <div class="cell-with-icon">
                                <svg viewBox="0 0 20 20" style="fill: #D4AF37;">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                {{ $log->driver->unitTruck->unit_number ?? 'N/A' }}
                            </div>
                        </td>
                        <td>{{ $log->driver->name ?? '-' }}</td>
                        <td>
                            <div class="cell-with-icon">
                                <svg viewBox="0 0 20 20" style="fill: #888;">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $log->checkPoint->name ?? '-' }}
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($log->check_In)->format('H:i') }}</td>
                        <td>{{ $log->check_Out ? \Carbon\Carbon::parse($log->check_Out)->format('H:i') : '-' }}</td>
                        <td>
                            @if($log->check_Out)
                                @php
                                    $checkIn = \Carbon\Carbon::parse($log->check_In);
                                    $checkOut = \Carbon\Carbon::parse($log->check_Out);
                                    $diff = $checkIn->diff($checkOut);
                                @endphp
                                <span class="duration-text">{{ $diff->h }}j {{ $diff->i }}m</span>
                            @else
                                <span style="color: #555;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($log->status === 'selesai')
                                <span class="badge-status badge-valid">Valid</span>
                            @else
                                <span class="badge-status badge-onlocation">On Location</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="pagination-wrapper">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection