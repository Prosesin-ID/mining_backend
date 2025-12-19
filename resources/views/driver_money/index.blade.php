@extends('layouts.app')

@section('content')
<style>
    .balance-header {
        margin-bottom: 30px;
    }
    
    .balance-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }
    
    .balance-title svg {
        width: 32px;
        height: 32px;
        fill: #D4AF37;
    }
    
    .balance-title h2 {
        font-size: 32px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    
    .balance-subtitle {
        color: #888;
        font-size: 14px;
        margin-left: 44px;
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 24px;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        border-color: #D4AF37;
        transform: translateY(-2px);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    
    .stat-icon.yellow {
        background: rgba(212, 175, 55, 0.15);
    }
    
    .stat-icon.orange {
        background: rgba(255, 165, 0, 0.15);
    }
    
    .stat-icon.red {
        background: rgba(255, 68, 68, 0.15);
    }
    
    .stat-icon.green {
        background: rgba(0, 255, 0, 0.15);
    }
    
    .stat-icon svg {
        width: 24px;
        height: 24px;
    }
    
    .stat-icon.yellow svg { fill: #D4AF37; }
    .stat-icon.orange svg { fill: #ffa500; }
    .stat-icon.red svg { fill: #ff4444; }
    .stat-icon.green svg { fill: #00ff00; }
    
    .stat-label {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
    }
    
    /* Tabs */
    .balance-tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #2a2a2a;
        margin-bottom: 30px;
    }
    
    .tab-link {
        padding: 16px 24px;
        color: #888;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        position: relative;
        bottom: -2px;
    }
    
    .tab-link:hover {
        color: #D4AF37;
    }
    
    .tab-link.active {
        color: #D4AF37;
        border-bottom-color: #D4AF37;
    }
    
    .tab-badge {
        display: inline-block;
        background: #D4AF37;
        color: #000;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 10px;
        margin-left: 8px;
    }
    
    /* Table Styles */
    .content-section {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 30px;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #2a2a2a;
    }
    
    .section-header svg {
        width: 24px;
        height: 24px;
        fill: #D4AF37;
    }
    
    .section-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    
    .section-search {
        margin-left: auto;
        width: 300px;
    }
    
    .search-input {
        width: 100%;
        background: #0a0a0a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 10px 16px;
        color: #fff;
        font-size: 13px;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #D4AF37;
    }
    
    .balance-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .balance-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid #2a2a2a;
    }
    
    .balance-table tbody tr {
        border-bottom: 1px solid #2a2a2a;
        transition: all 0.3s;
    }
    
    .balance-table tbody tr:hover {
        background: rgba(212, 175, 55, 0.05);
    }
    
    .balance-table tbody td {
        padding: 20px 16px;
        color: #ddd;
        font-size: 14px;
    }
    
    .driver-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .driver-info svg {
        width: 18px;
        height: 18px;
        fill: #666;
    }
    
    .driver-name {
        font-weight: 600;
        color: #fff;
    }
    
    .driver-id {
        font-size: 12px;
        color: #666;
    }
    
    .unit-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(212, 175, 55, 0.1);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #D4AF37;
    }
    
    .unit-badge svg {
        width: 16px;
        height: 16px;
        fill: #D4AF37;
    }
    
    .amount-positive {
        color: #00ff00;
        font-weight: 700;
    }
    
    .amount-negative {
        color: #ff4444;
        font-weight: 700;
    }
    
    .amount-pending {
        color: #ffa500;
        font-weight: 700;
    }
    
    .btn-topup {
        background: transparent;
        border: 2px solid #D4AF37;
        color: #D4AF37;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-topup:hover {
        background: #D4AF37;
        color: #000;
    }
    
    .btn-topup svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    
    /* Modal */
    .modal-content {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
    }
    
    .modal-header {
        border-bottom: 2px solid #2a2a2a;
        padding: 24px 30px;
    }
    
    .modal-title {
        color: #fff;
        font-weight: 700;
        font-size: 20px;
    }
    
    .btn-close {
        filter: invert(1);
        opacity: 0.6;
    }
    
    .modal-body {
        padding: 30px;
    }
    
    .form-label {
        color: #aaa;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }
    
    .form-control {
        background: #0a0a0a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 12px 16px;
        color: #fff;
        font-size: 14px;
    }
    
    .form-control:focus {
        background: #0a0a0a;
        border-color: #D4AF37;
        color: #fff;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    
    .modal-footer {
        border-top: 2px solid #2a2a2a;
        padding: 20px 30px;
    }
    
    .btn-secondary {
        background: transparent;
        border: 2px solid #666;
        color: #aaa;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-secondary:hover {
        background: #666;
        color: #fff;
        border-color: #666;
    }
    
    .btn-primary {
        background: #D4AF37;
        border: none;
        color: #000;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 700;
    }
    
    .btn-primary:hover {
        background: #f0c844;
    }
    
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="balance-header">
        <div class="balance-title">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
            </svg>
            <h2>MANAJEMEN SALDO</h2>
        </div>
        <p class="balance-subtitle">Kelola saldo uang jalan driver dan biaya rute</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                </svg>
            </div>
            <div class="stat-label">Total Saldo Driver</div>
            <div class="stat-value">Rp {{ number_format($drivers->sum('driverMoney.amount'), 0, ',', '.') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <div class="stat-label">Pending Approval</div>
            <div class="stat-value">{{ $drivers->sum(function($d) { return $d->driverRequests->count(); }) }} Request</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <div class="stat-label">Pending Pemotongan</div>
            <div class="stat-value">Rp {{ number_format($drivers->sum(function($d) { return $d->driverRequests->where('request_type', 'pemotongan')->sum('amount'); }), 0, ',', '.') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                </svg>
            </div>
            <div class="stat-label">Rute Terdaftar</div>
            <div class="stat-value">{{ \App\Models\BiayaRute::count() }} Rute</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="balance-tabs">
        <a href="{{ route('driver_money.index') }}" class="tab-link active">
            Saldo Driver
        </a>
        <a href="{{ route('driver_requests.index') }}" class="tab-link">
            Approval Request
            <span class="tab-badge">{{ $drivers->sum(function($d) { return $d->driverRequests->count(); }) }}</span>
        </a>
        <a href="{{ route('biaya_rute.index') }}" class="tab-link">
            Biaya Rute
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="section-header">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <h3>Daftar Saldo Driver</h3>
            <div class="section-search">
                <input type="text" class="search-input" placeholder="🔍 Cari driver...">
            </div>
        </div>

        <table class="balance-table">
            <thead>
                <tr>
                    <th>DRIVER</th>
                    <th>UNIT</th>
                    <th>SALDO</th>
                    <th>PENDING POTONGAN</th>
                    <th>LAST TOP-UP</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                <tr>
                    <td>
                        <div class="driver-info">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <div>
                                <div class="driver-name">{{ $driver->name }}</div>
                                <div class="driver-id">D{{ str_pad($driver->id, 3, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($driver->unitTruck)
                        <span class="unit-badge">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                            </svg>
                            {{ $driver->unitTruck->plate_number }}
                        </span>
                        @else
                        <span style="color: #666;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="amount-positive">Rp {{ number_format($driver->driverMoney->amount ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="amount-negative">Rp {{ number_format($driver->driverRequests->where('request_type', 'pemotongan')->sum('amount'), 0, ',', '.') }}</span>
                    </td>
                    <td style="color: #888;">
                        {{ $driver->driverMoney ? $driver->driverMoney->updated_at->format('Y-m-d') : '-' }}
                    </td>
                    <td>
                        <button class="btn-topup" onclick="openTopUpModal({{ $driver->id }}, '{{ $driver->name }}', {{ $driver->driverMoney->id ?? 0 }})">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            TOP-UP
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Top-Up Modal -->
<div class="modal fade" id="topUpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Top-Up Saldo Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="topUpForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Driver</label>
                        <input type="text" class="form-control" id="topup_driver_name" readonly style="background: #2a2a2a;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Top-Up</label>
                        <input type="number" class="form-control" name="amount" id="topup_amount" required placeholder="Masukkan jumlah...">
                        <input type="hidden" name="driver_id" id="topup_driver_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary">Proses Top-Up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTopUpModal(driverId, driverName, driverMoneyId) {
    document.getElementById('topup_driver_name').value = driverName;
    document.getElementById('topup_driver_id').value = driverId;
    document.getElementById('topup_amount').value = '';
    document.getElementById('topUpForm').action = `/driver_money/topup/${driverMoneyId}`;
    new bootstrap.Modal(document.getElementById('topUpModal')).show();
}
</script>

@if(session('success'))
<div class="alert alert-success" style="position: fixed; top: 90px; right: 30px; z-index: 9999; background: #00ff00; color: #000; border: none; border-radius: 8px; padding: 16px 24px; font-weight: 600;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="position: fixed; top: 90px; right: 30px; z-index: 9999; background: #ff4444; color: #fff; border: none; border-radius: 8px; padding: 16px 24px; font-weight: 600;">
    {{ session('error') }}
</div>
@endif
@endsection