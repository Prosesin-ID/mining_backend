@extends('layouts.app')

@section('content')
<style>
    .activity-header {
        margin-bottom: 30px;
    }
    
    .activity-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }
    
    .activity-title svg {
        width: 32px;
        height: 32px;
        fill: #D4AF37;
    }
    
    .activity-title h2 {
        font-size: 32px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    
    .activity-subtitle {
        color: #888;
        font-size: 14px;
        margin-left: 44px;
    }
    
    /* Filter Section */
    .filter-section {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }
    
    .filter-controls {
        display: flex;
        gap: 16px;
        align-items: flex-end;
    }
    
    .search-box {
        flex: 1;
        max-width: 500px;
    }
    
    .date-filter {
        display: flex;
        gap: 12px;
        align-items: flex-end;
    }
    
    .filter-input-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .filter-label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    
    .search-input,
    .date-input {
        background: #0a0a0a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 12px 16px;
        color: #fff;
        font-size: 14px;
        min-width: 200px;
    }
    
    .search-input:focus,
    .date-input:focus {
        outline: none;
        border-color: #D4AF37;
    }
    
    .search-input::placeholder {
        color: #666;
    }
    
    .btn-filter {
        background: #D4AF37;
        border: none;
        color: #000;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    
    .btn-filter:hover {
        background: #f0c844;
        transform: translateY(-1px);
    }
    
    .btn-filter svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    
    /* Content Section */
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
    
    /* Activity Table */
    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .activity-table thead th {
        padding: 14px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #2a2a2a;
        background: #0a0a0a;
    }
    
    .activity-table tbody tr {
        border-bottom: 1px solid #2a2a2a;
        transition: all 0.3s;
    }
    
    .activity-table tbody tr:hover {
        background: rgba(212, 175, 55, 0.05);
    }
    
    .activity-table tbody td {
        padding: 20px 16px;
        color: #ddd;
        font-size: 14px;
    }
    
    /* Unit Driver Cell */
    .unit-driver-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .truck-icon {
        width: 40px;
        height: 40px;
        background: rgba(212, 175, 55, 0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .truck-icon svg {
        width: 20px;
        height: 20px;
        fill: #D4AF37;
    }
    
    .unit-driver-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .unit-number {
        font-weight: 700;
        color: #fff;
        font-size: 15px;
    }
    
    .driver-name {
        font-size: 13px;
        color: #888;
    }
    
    /* Checkpoint Cell */
    .checkpoint-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .checkpoint-cell svg {
        width: 18px;
        height: 18px;
        fill: #666;
    }
    
    .checkpoint-name {
        color: #ddd;
        font-weight: 500;
    }
    
    /* Time Cell */
    .time-cell {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .time-cell svg {
        width: 16px;
        height: 16px;
    }
    
    .time-cell.check-in svg {
        fill: #00ff00;
    }
    
    .time-cell.check-out svg {
        fill: #ffa500;
    }
    
    .time-value {
        font-weight: 600;
        color: #fff;
    }
    
    /* Duration Badge */
    .duration-badge {
        display: inline-block;
        background: rgba(212, 175, 55, 0.15);
        color: #D4AF37;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 13px;
    }
    
    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge.on_location {
        background: rgba(0, 255, 0, 0.15);
        color: #00ff00;
    }
    
    .status-badge.selesai {
        background: rgba(136, 136, 136, 0.15);
        color: #888;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    
    .empty-state svg {
        width: 80px;
        height: 80px;
        fill: #333;
        margin-bottom: 24px;
    }
    
    .empty-state h4 {
        color: #666;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    .empty-state p {
        color: #444;
        font-size: 14px;
    }
    
    @media (max-width: 1400px) {
        .filter-controls {
            flex-wrap: wrap;
        }
        
        .search-box {
            width: 100%;
            max-width: none;
        }
        
        .date-filter {
            width: 100%;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="activity-header">
        <div class="activity-title">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
            </svg>
            <h2>RIWAYAT AKTIVITAS</h2>
        </div>
        <p class="activity-subtitle">Log check-in dan check-out unit</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('driver_log_activities.filter') }}" method="GET">
            <div class="filter-controls">
                <div class="search-box">
                    <div class="filter-input-group">
                        <label class="filter-label">Pencarian</label>
                        <input type="text" class="search-input" id="searchInput" placeholder="🔍 Cari unit, driver, atau checkpoint...">
                    </div>
                </div>
                
                <div class="date-filter">
                    <div class="filter-input-group">
                        <label class="filter-label">Tanggal Mulai</label>
                        <input type="date" class="date-input" name="start_date" id="startDate">
                    </div>
                    
                    <div class="filter-input-group">
                        <label class="filter-label">Tanggal Akhir</label>
                        <input type="date" class="date-input" name="end_date" id="endDate">
                    </div>
                    
                    <button type="submit" class="btn-filter">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        FILTER
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="section-header">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <h3>Log Aktivitas</h3>
        </div>

        @if($logs->count() > 0)
        <table class="activity-table" id="activityTable">
            <thead>
                <tr>
                    <th>UNIT / DRIVER</th>
                    <th>CHECKPOINT</th>
                    <th>CHECK-IN</th>
                    <th>CHECK-OUT</th>
                    <th>DURASI</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>
                        <div class="unit-driver-cell">
                            <div class="truck-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                                </svg>
                            </div>
                            <div class="unit-driver-info">
                                <span class="unit-number">{{ $log->driver->unitTruck->plate_number ?? 'N/A' }}</span>
                                <span class="driver-name">{{ $log->driver->name }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="checkpoint-cell">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <span class="checkpoint-name">{{ $log->checkpoint->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="time-cell check-in">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="currentColor"/>
                            </svg>
                            <span class="time-value">{{ $log->check_In }}</span>
                        </div>
                    </td>
                    <td>
                        @if($log->check_Out)
                        <div class="time-cell check-out">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="currentColor"/>
                            </svg>
                            <span class="time-value">{{ $log->check_Out }}</span>
                        </div>
                        @else
                        <span style="color: #666;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($log->check_Out)
                            @php
                                $checkIn = \Carbon\Carbon::parse($log->check_In);
                                $checkOut = \Carbon\Carbon::parse($log->check_Out);
                                $duration = $checkIn->diff($checkOut);
                                $hours = $duration->h;
                                $minutes = $duration->i;
                            @endphp
                            <span class="duration-badge">{{ $hours }}j {{ $minutes }}m</span>
                        @else
                            <span style="color: #666;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $log->status }}">
                            {{ $log->status == 'on_location' ? 'ON LOCATION' : 'SELESAI' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <h4>Tidak Ada Data Aktivitas</h4>
            <p>Belum ada log check-in dan check-out dari driver.</p>
        </div>
        @endif
    </div>
</div>

<!-- Search Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('activityTable');
    
    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            Array.from(rows).forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    }
});
</script>

@if(session('success'))
<div class="alert alert-success" style="position: fixed; top: 90px; right: 30px; z-index: 9999; background: #00ff00; color: #000; border: none; border-radius: 8px; padding: 16px 24px; font-weight: 600;">
    {{ session('success') }}
</div>
<script>
    setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if(alert) alert.style.display = 'none';
    }, 3000);
</script>
@endif
@endsection