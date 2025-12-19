@extends('layouts.app')

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #D4AF37;
    }

    .stat-label {
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 5px;
    }

    .stat-change {
        font-size: 13px;
        color: #4ade80;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stat-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: rgba(212, 175, 55, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg {
        width: 28px;
        height: 28px;
        fill: #D4AF37;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .activity-card,
    .status-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #2a2a2a;
    }

    .card-header svg {
        width: 24px;
        height: 24px;
        fill: #D4AF37;
    }

    .card-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tab {
        padding: 8px 16px;
        background: transparent;
        border: 1px solid #2a2a2a;
        color: #888;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
    }

    .tab.active {
        background: #D4AF37;
        color: #000;
        border-color: #D4AF37;
        font-weight: 600;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        background: rgba(30, 30, 30, 0.5);
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .activity-item:hover {
        background: rgba(40, 40, 40, 0.7);
        border-color: #D4AF37;
    }

    .activity-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .activity-status {
        width: 12px;
        height: 12px;
        background: #4ade80;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .activity-details h4 {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 5px 0;
    }

    .activity-details p {
        font-size: 12px;
        color: #888;
        margin: 0;
    }

    .activity-badge {
        padding: 6px 14px;
        background: rgba(74, 222, 128, 0.15);
        color: #4ade80;
        border: 1px solid #4ade80;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .activity-badge.checkout {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-color: #ef4444;
    }

    .activity-time {
        font-size: 13px;
        color: #888;
        margin-left: 10px;
    }

    .status-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .status-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 15px;
        background: rgba(30, 30, 30, 0.5);
        border: 1px solid #2a2a2a;
        border-radius: 8px;
    }

    .status-item span {
        font-size: 14px;
        color: #ccc;
    }

    .status-count {
        font-size: 18px;
        font-weight: 700;
        color: #4ade80;
    }

    .maintenance-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .maintenance-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
    }

    .maintenance-item {
        padding: 15px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .maintenance-item:last-child {
        margin-bottom: 0;
    }

    .maintenance-item h4 {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 8px 0;
    }

    .maintenance-meta {
        font-size: 12px;
        color: #888;
        margin-bottom: 8px;
    }

    .maintenance-reason {
        font-size: 13px;
        color: #ccc;
        font-style: italic;
    }

    .map-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
        height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .map-placeholder {
        text-align: center;
        color: #888;
    }

    .map-placeholder svg {
        width: 80px;
        height: 80px;
        fill: #444;
        margin-bottom: 15px;
    }

    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .maintenance-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(74, 222, 128, 0.15); border: 1px solid #4ade80; color: #4ade80;">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-label">Total Unit</div>
        <div class="stat-value">24</div>
        <div class="stat-change">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 14l5-5 5 5z"/>
            </svg>
            +2 hari ini
        </div>
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
            </svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Checkpoints</div>
        <div class="stat-value">12</div>
        <div class="stat-change">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 14l5-5 5 5z"/>
            </svg>
            +1 hari ini
        </div>
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">On Location</div>
        <div class="stat-value">18</div>
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Maintenance</div>
        <div class="stat-value">2</div>
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
            </svg>
        </div>
    </div>
</div>

<!-- Activity and Status -->
<div class="content-grid">
    <div class="activity-card">
        <div class="card-header">
            <svg viewBox="0 0 24 24">
                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
            <h3>AKTIVITAS TERKINI</h3>
        </div>

        <div class="tabs">
            <div class="tab active">Semua</div>
            <div class="tab">Check-Out Data</div>
        </div>

        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-status"></div>
                    <div class="activity-details">
                        <h4>B 1234 ABC</h4>
                        <p>Ahmad Surya • Gudang Utama</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="activity-badge">CHECK-IN</span>
                    <span class="activity-time">10:30</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-status" style="background: #ef4444;"></div>
                    <div class="activity-details">
                        <h4>B 5678 DEF</h4>
                        <p>Budi Santoso • Quarry Cikarang</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="activity-badge checkout">CHECK-OUT</span>
                    <span class="activity-time">10:25</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-status"></div>
                    <div class="activity-details">
                        <h4>B 9012 GHI</h4>
                        <p>Candra Wijaya • Terminal B</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="activity-badge">CHECK-IN</span>
                    <span class="activity-time">10:20</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-status" style="background: #ef4444;"></div>
                    <div class="activity-details">
                        <h4>B 3456 JKL</h4>
                        <p>Dedi Kurniawan • Gudang Utama</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="activity-badge checkout">CHECK-OUT</span>
                    <span class="activity-time">10:15</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-info">
                    <div class="activity-status"></div>
                    <div class="activity-details">
                        <h4>B 7890 MNO</h4>
                        <p>Eko Prasetyo • Quarry Bogor</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="activity-badge">CHECK-IN</span>
                    <span class="activity-time">10:10</span>
                </div>
            </div>
        </div>
    </div>

    <div class="status-card">
        <div class="card-header">
            <svg viewBox="0 0 24 24">
                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
            </svg>
            <h3>STATUS UNIT</h3>
        </div>

        <div class="status-list">
            <div class="status-item">
                <span>On Location</span>
                <span class="status-count" style="color: #4ade80;">18</span>
            </div>
            <div class="status-item">
                <span>Belum Check-Out</span>
                <span class="status-count" style="color: #f59e0b;">4</span>
            </div>
            <div class="status-item">
                <span>Maintenance</span>
                <span class="status-count" style="color: #ef4444;">2</span>
            </div>
            <div class="status-item">
                <span>Completed</span>
                <span class="status-count" style="color: #3b82f6;">1</span>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Units -->
<div class="maintenance-grid">
    <div class="maintenance-card">
        <div class="card-header">
            <svg viewBox="0 0 24 24">
                <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/>
            </svg>
            <h3>UNIT MAINTENANCE</h3>
        </div>

        <div class="maintenance-item">
            <h4>B 2468 PQR</h4>
            <div class="maintenance-meta">Sejak 09:00 • Fajar Hidayat</div>
            <div class="maintenance-meta">Lokasi: Gudang Utama</div>
            <div class="maintenance-reason">Alasan: Ganti oli dan servis rutin</div>
        </div>

        <div class="maintenance-item">
            <h4>B 1357 STU</h4>
            <div class="maintenance-meta">Sejak 08:30 • Gilang Ramadhan</div>
            <div class="maintenance-meta">Lokasi: Pool Cikarang</div>
            <div class="maintenance-reason">Alasan: Perbaikan rem</div>
        </div>
    </div>

    <div class="map-card">
        <div class="card-header" style="border: none; padding-bottom: 0;">
            <svg viewBox="0 0 24 24">
                <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/>
            </svg>
            <h3>PETA MONITORING</h3>
        </div>
        <div class="map-placeholder">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/>
            </svg>
            <p>Map View akan ditampilkan di sini</p>
            <small>Koneksikan dengan Lovable Cloud untuk fitur peta</small>
        </div>
    </div>
</div>

@endsection