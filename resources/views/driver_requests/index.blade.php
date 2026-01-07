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
    
    /* Request Card */
    .request-card {
        background: #0a0a0a;
        border: 2px solid #2a2a2a;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 16px;
        transition: all 0.3s;
    }
    
    .request-card:hover {
        border-color: #D4AF37;
    }
    
    .request-card.pemotongan {
        border-left: 4px solid #ff4444;
    }
    
    .request-card.top_up {
        border-left: 4px solid #00ff00;
    }
    
    .request-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    
    .request-info {
        flex: 1;
    }
    
    .request-driver {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }
    
    .request-driver svg {
        width: 20px;
        height: 20px;
        fill: #666;
    }
    
    .driver-name-large {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
    }
    
    .request-type-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .request-type-badge.pemotongan {
        background: rgba(255, 68, 68, 0.15);
        color: #ff4444;
    }
    
    .request-type-badge.top_up {
        background: rgba(0, 255, 0, 0.15);
        color: #00ff00;
    }
    
    .request-details {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        padding: 16px;
        background: #1a1a1a;
        border-radius: 8px;
        margin-bottom: 16px;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    
    .detail-label {
        font-size: 11px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    
    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #ddd;
    }
    
    .detail-value.amount {
        font-size: 20px;
        font-weight: 700;
    }
    
    .detail-value.amount.negative {
        color: #ff4444;
    }
    
    .detail-value.amount.positive {
        color: #00ff00;
    }
    
    .request-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }
    
    .btn-approve,
    .btn-reject {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    
    .btn-approve {
        background: transparent;
        border: 2px solid #00ff00;
        color: #00ff00;
    }
    
    .btn-approve:hover {
        background: #00ff00;
        color: #000;
    }
    
    .btn-reject {
        background: transparent;
        border: 2px solid #ff4444;
        color: #ff4444;
    }
    
    .btn-reject:hover {
        background: #ff4444;
        color: #fff;
    }
    
    .btn-approve svg,
    .btn-reject svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state svg {
        width: 64px;
        height: 64px;
        fill: #333;
        margin-bottom: 20px;
    }
    
    .empty-state h4 {
        color: #666;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: #444;
        font-size: 14px;
    }
    
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .request-details {
            grid-template-columns: 1fr;
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
            <div class="stat-value">Rp {{ number_format(\App\Models\DriverMoney::sum('amount'), 0, ',', '.') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <div class="stat-label">Pending Approval</div>
            <div class="stat-value">{{ $pendingCount }} Request</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                </svg>
            </div>
            <div class="stat-label">Approved</div>
            <div class="stat-value">{{ $approvedCount }} Request</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <div class="stat-label">Rejected</div>
            <div class="stat-value">{{ $rejectedCount }} Request</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="balance-tabs">
        <a href="{{ route('driver_money.index') }}" class="tab-link">
            Saldo Driver
        </a>
        <a href="{{ route('driver_requests.index') }}" class="tab-link active">
            Approval Request
            <span class="tab-badge">{{ $pendingCount }}</span>
        </a>
        <a href="{{ route('biaya_rute.index') }}" class="tab-link">
            Biaya Rute
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="balance-tabs" style="margin-top: -10px; margin-bottom: 20px; border-bottom: 1px solid #2a2a2a;">
        <a href="{{ route('driver_requests.index', ['filter' => 'pending']) }}" class="tab-link {{ $filter === 'pending' ? 'active' : '' }}">
            Pending
            @if($pendingCount > 0)
            <span class="tab-badge">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('driver_requests.index', ['filter' => 'approved']) }}" class="tab-link {{ $filter === 'approved' ? 'active' : '' }}">
            Approved
        </a>
        <a href="{{ route('driver_requests.index', ['filter' => 'rejected']) }}" class="tab-link {{ $filter === 'rejected' ? 'active' : '' }}">
            Rejected
        </a>
        <a href="{{ route('driver_requests.index', ['filter' => 'all']) }}" class="tab-link {{ $filter === 'all' ? 'active' : '' }}">
            Semua
        </a>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <div class="section-header">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <h3>Daftar Request</h3>
        </div>

        @if($driverRequests->count() > 0)
            @foreach($driverRequests as $request)
            <div class="request-card {{ $request->request_type }}">
                <div class="request-header">
                    <div class="request-info">
                        <div class="request-driver">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span class="driver-name-large">{{ $request->driver->name }}</span>
                            <span class="request-type-badge {{ $request->request_type }}">
                                {{ $request->request_type == 'pemotongan' ? 'PEMOTONGAN' : 'TOP-UP' }}
                            </span>
                            @if($request->status === 'approved')
                            <span class="request-type-badge" style="background: rgba(0, 255, 0, 0.15); color: #00ff00;">
                                ✓ APPROVED
                            </span>
                            @elseif($request->status === 'rejected')
                            <span class="request-type-badge" style="background: rgba(255, 68, 68, 0.15); color: #ff4444;">
                                ✗ REJECTED
                            </span>
                            @else
                            <span class="request-type-badge" style="background: rgba(212, 175, 55, 0.15); color: #D4AF37;">
                                ⏳ PENDING
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="request-details">
                    @if($request->request_type == 'pemotongan')
                    <div class="detail-item">
                        <span class="detail-label">Biaya rute</span>
                        <span class="detail-value">
                            @php
                                // $routeInfo = json_decode($request->notes ?? '{}');
                                echo $routeInfo->from ?? '-';
                            @endphp
                            →
                            @php
                                echo $routeInfo->to ?? '-';
                            @endphp
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Rute</span>
                        <span class="detail-value">
                            @php
                                echo $routeInfo->route ?? '-';
                            @endphp
                        </span>
                    </div>
                    @else
                    <div class="detail-item">
                        <span class="detail-label">Request top up saldo</span>
                        <span class="detail-value">Top-up saldo driver</span>
                    </div>
                    @endif
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Request</span>
                        <span class="detail-value">{{ $request->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jumlah</span>
                        <span class="detail-value amount {{ $request->request_type == 'pemotongan' ? 'negative' : 'positive' }}">
                            {{ $request->request_type == 'pemotongan' ? '-' : '+' }}Rp {{ number_format($request->amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                @if($request->notes)
                <div style="background: #1a1a1a; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; border-left: 3px solid {{ $request->status === 'approved' ? '#00ff00' : '#ff4444' }};">
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <svg style="width: 16px; height: 16px; fill: #666; margin-top: 2px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <div style="flex: 1;">
                            <div style="font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Catatan Admin</div>
                            <div style="color: #ddd; font-size: 13px;">{{ $request->notes }}</div>
                        </div>
                    </div>
                </div>
                @endif

                @if($request->status === 'pending')
                <div class="request-actions">
                    <form action="{{ route('driver_requests.approve', $request->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-approve" onclick="return confirm('Approve request ini?')">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                            </svg>
                            APPROVE
                        </button>
                    </form>
                    <button type="button" class="btn-reject" onclick="showRejectModal({{ $request->id }})">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                        REJECT
                    </button>
                </div>
                @else
                <div style="text-align: right; color: #666; font-size: 12px; padding: 8px 0;">
                    <svg style="width: 14px; height: 14px; fill: #666; vertical-align: middle;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Diproses pada {{ $request->updated_at->format('Y-m-d H:i') }}
                </div>
                @endif
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                </svg>
                <h4>Tidak Ada Request</h4>
                <p>Semua request telah diproses atau belum ada request baru dari driver.</p>
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; align-items: center; justify-content: center;">
    <div style="background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%;">
        <h3 style="color: #fff; margin-bottom: 20px; font-size: 20px;">Reject Request</h3>
        <form id="rejectForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #888; font-size: 13px; margin-bottom: 8px;">Alasan penolakan (opsional):</label>
                <textarea name="notes" rows="4" style="width: 100%; background: #0a0a0a; border: 1px solid #2a2a2a; border-radius: 8px; padding: 12px; color: #fff; font-size: 14px; font-family: inherit; resize: vertical;" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeRejectModal()" style="padding: 10px 20px; background: transparent; border: 2px solid #555; color: #888; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" style="padding: 10px 20px; background: #ff4444; border: none; color: #fff; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Reject Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(requestId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = '{{ route("driver_requests.reject", ":id") }}'.replace(':id', requestId);
    modal.style.display = 'flex';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>

@if(session('success'))
<div class="alert alert-success" style="position: fixed; top: 90px; right: 30px; z-index: 9999; background: #00ff00; color: #000; border: none; border-radius: 8px; padding: 16px 24px; font-weight: 600;">
    {{ session('success') }}
</div>
<script>
    setTimeout(function() {
        document.querySelector('.alert-success').style.display = 'none';
    }, 3000);
</script>
@endif

@if(session('error'))
<div class="alert alert-danger" style="position: fixed; top: 90px; right: 30px; z-index: 9999; background: #ff4444; color: #fff; border: none; border-radius: 8px; padding: 16px 24px; font-weight: 600;">
    {{ session('error') }}
</div>
<script>
    setTimeout(function() {
        document.querySelector('.alert-danger').style.display = 'none';
    }, 3000);
</script>
@endif
@endsection