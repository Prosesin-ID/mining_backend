@extends('layouts.app')

@section('content')
<style>
    .unit-card {
        background: #1a1a1a;
        border: 2px solid #D4AF37;
        border-radius: 12px;
        padding: 24px;
        position: relative;
        transition: all 0.3s;
        min-height: 380px;
        display: flex;
        flex-direction: column;
    }
    
    .unit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
    }
    
    .unit-icon {
        width: 60px;
        height: 60px;
        background: #D4AF37;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    
    .unit-icon svg {
        width: 35px;
        height: 35px;
        fill: #000;
    }
    
    .status-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge.active {
        background: rgba(0, 255, 0, 0.15);
        color: #00ff00;
        border: 1px solid #00ff00;
    }
    
    .status-badge.maintenance {
        background: rgba(255, 165, 0, 0.15);
        color: #ffa500;
        border: 1px solid #ffa500;
    }
    
    .status-badge.inactive {
        background: rgba(128, 128, 128, 0.15);
        color: #888;
        border: 1px solid #888;
    }
    
    .unit-title {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    
    .unit-plate {
        font-size: 18px;
        font-weight: 600;
        color: #D4AF37;
        margin-bottom: 20px;
        letter-spacing: 1px;
    }
    
    .unit-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 12px;
        flex: 1;
    }
    
    .info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #aaa;
        font-size: 14px;
    }
    
    .info-row svg {
        width: 18px;
        height: 18px;
        fill: #666;
    }
    
    .unit-actions {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }
    
    .btn-edit {
        flex: 1;
        padding: 12px;
        background: transparent;
        border: 2px solid #D4AF37;
        color: #D4AF37;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .btn-edit:hover {
        background: #D4AF37;
        color: #000;
    }
    
    .btn-delete {
        padding: 12px;
        background: transparent;
        border: 2px solid #ff4444;
        color: #ff4444;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background: #ff4444;
        color: #fff;
    }
    
    .maintenance-info {
        background: rgba(255, 165, 0, 0.1);
        border: 1px solid rgba(255, 165, 0, 0.3);
        border-radius: 8px;
        padding: 8px 10px;
        margin-bottom: 12px;
        max-height: 70px;
        overflow: hidden;
    }
    
    .maintenance-info-title {
        font-size: 10px;
        font-weight: 700;
        color: #ffa500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    
    .maintenance-info-text {
        font-size: 11px;
        color: #ddd;
        line-height: 1.4;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .btn-end-maintenance {
        flex: 1;
        padding: 12px;
        background: #00cc00;
        border: none;
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .btn-end-maintenance:hover {
        background: #00ff00;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 255, 0, 0.3);
    }
    
    .btn-add {
        background: #D4AF37;
        color: #000;
        padding: 14px 28px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .btn-add:hover {
        background: #f0c844;
        transform: translateY(-2px);
    }
    
    .search-box {
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 12px;
        padding: 16px 20px;
        color: #fff;
        font-size: 15px;
        width: 100%;
        transition: all 0.3s;
    }
    
    .search-box:focus {
        outline: none;
        border-color: #D4AF37;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    
    .table-section {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 30px;
        margin-top: 40px;
    }
    
    .table-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #2a2a2a;
    }
    
    .table-header svg {
        width: 24px;
        height: 24px;
        fill: #D4AF37;
    }
    
    .table-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table thead th {
        padding: 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #D4AF37;
    }
    
    .data-table tbody tr {
        border-bottom: 1px solid #2a2a2a;
        transition: all 0.3s;
    }
    
    .data-table tbody tr:hover {
        background: rgba(212, 175, 55, 0.05);
    }
    
    .data-table tbody td {
        padding: 20px 16px;
        color: #ddd;
        font-size: 14px;
    }
    
    .table-unit-id {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    }
    
    .table-unit-id svg {
        width: 20px;
        height: 20px;
        fill: #D4AF37;
    }
    
    .table-actions {
        display: flex;
        gap: 10px;
    }
    
    .icon-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s;
    }
    
    .icon-btn svg {
        width: 18px;
        height: 18px;
    }
    
    .icon-btn.edit {
        color: #D4AF37;
    }
    
    .icon-btn.edit:hover {
        background: rgba(212, 175, 55, 0.1);
    }
    
    .icon-btn.delete {
        color: #ff4444;
    }
    
    .icon-btn.delete:hover {
        background: rgba(255, 68, 68, 0.1);
    }
    
    /* Modal Styles */
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
    
    .btn-close:hover {
        opacity: 1;
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
    
    .form-control, .form-select {
        background: #0a0a0a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 12px 16px;
        color: #fff;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        background: #0a0a0a;
        border-color: #D4AF37;
        color: #fff;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    
    .form-select option {
        background: #1a1a1a;
        color: #fff;
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
        transition: all 0.3s;
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
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        background: #f0c844;
        color: #000;
    }
</style>

<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="color: #fff; font-size: 32px; font-weight: 700; margin: 0;">UNIT TRUCK</h2>
            <p style="color: #888; font-size: 14px; margin: 0;">Kelola data unit dan driver</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addUnitModal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            TAMBAH UNIT
        </button>
    </div>

    <!-- Search Box -->
    <div class="mb-4">
        <input type="text" class="search-box" placeholder="🔍 Cari unit, plat nomor, atau driver...">
    </div>

    <!-- Unit Cards Grid -->
    <div class="row g-4 mb-5">
        @foreach($trucks as $truck)
        <div class="col-md-6 col-lg-4">
            <div class="unit-card">
                <span class="status-badge {{ $truck->status }}">{{ strtoupper($truck->status) }}</span>
                
                <div class="unit-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                    </svg>
                </div>
                
                <div class="unit-title">{{ $truck->no_unit }}</div>
                <div class="unit-plate">{{ $truck->plate_number }}</div>
                
                <div class="unit-info">
                    <div class="info-row">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        {{ $truck->driver->name ?? 'N/A' }}
                    </div>
                    <div class="info-row">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                        </svg>
                        {{ $truck->bank->name ?? 'N/A' }} - {{ $truck->bank_account_number }}
                    </div>
                </div>
                
                @if($truck->status === 'maintenance' && $truck->reason_maintenance)
                <div class="maintenance-info">
                    <div class="maintenance-info-title">⚠️ Alasan Maintenance:</div>
                    <div class="maintenance-info-text">{{ $truck->reason_maintenance }}</div>
                    @if($truck->maintenance_start_time)
                    <div class="maintenance-info-text" style="font-size: 11px; color: #888; margin-top: 6px;">
                        Dimulai: {{ \Carbon\Carbon::parse($truck->maintenance_start_time)->format('d M Y H:i') }}
                    </div>
                    @endif
                </div>
                @endif
                
                <div class="unit-actions">
                    @if($truck->status === 'maintenance')
                        <form action="{{ route('unit_trucks.end_maintenance', $truck->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn-end-maintenance" onclick="return confirm('Yakin mengakhiri maintenance?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                </svg>
                                END MAINTENANCE
                            </button>
                        </form>
                    @else
                        <button class="btn-edit" onclick="editUnit({{ $truck->id }})">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                            EDIT
                        </button>
                        <form action="{{ route('unit_trucks.destroy', $truck->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus unit ini?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
            </svg>
            <h3>DAFTAR UNIT</h3>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID UNIT</th>
                    <th>PLAT NOMOR</th>
                    <th>DRIVER</th>
                    <th>REKENING</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trucks as $truck)
                <tr>
                    <td>
                        <div class="table-unit-id">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/>
                            </svg>
                            {{ $truck->no_unit }}
                        </div>
                    </td>
                    <td>{{ $truck->plate_number }}</td>
                    <td>{{ $truck->driver->name ?? 'N/A' }}</td>
                    <td>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#D4AF37" style="display: inline; margin-right: 6px;">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                        </svg>
                        {{ $truck->bank->name ?? 'N/A' }} - {{ $truck->bank_account_number }}
                    </td>
                    <td>
                        <span class="status-badge {{ $truck->status }}">{{ strtoupper($truck->status) }}</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <button class="icon-btn edit" onclick="editUnit({{ $truck->id }})">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                            </button>
                            <form action="{{ route('unit_trucks.destroy', $truck->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-btn delete" onclick="return confirm('Yakin hapus unit ini?')">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Unit Modal -->
<div class="modal fade" id="addUnitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Unit Truck</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('unit_trucks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" name="plate_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bank</label>
                        <select class="form-select" name="bank_id" required>
                            <option value="">Pilih Bank</option>
                            @foreach(\App\Models\Bank::all() as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Driver</label>
                        <select class="form-select" name="driver_id" required>
                            <option value="">Pilih Driver</option>
                            @foreach(\App\Models\Driver::all() as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" name="bank_account_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Unit Modal -->
<div class="modal fade" id="editUnitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Unit Truck</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUnitForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">No Unit</label>
                        <input type="text" class="form-control" id="edit_no_unit" readonly style="background: #2a2a2a;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Plat Nomor</label>
                        <input type="text" class="form-control" name="plate_number" id="edit_plate_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bank</label>
                        <select class="form-select" name="bank_id" id="edit_bank_id" required>
                            <option value="">Pilih Bank</option>
                            @foreach(\App\Models\Bank::all() as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Driver</label>
                        <select class="form-select" name="driver_id" id="edit_driver_id" required>
                            <option value="">Pilih Driver</option>
                            @foreach(\App\Models\Driver::all() as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening</label>
                        <input type="text" class="form-control" name="bank_account_number" id="edit_bank_account_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="active">Active</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editUnit(id) {
    fetch(`/unit_trucks/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_no_unit').value = data.no_unit;
            document.getElementById('edit_plate_number').value = data.plate_number;
            document.getElementById('edit_bank_id').value = data.bank_id;
            document.getElementById('edit_driver_id').value = data.driver_id;
            document.getElementById('edit_bank_account_number').value = data.bank_account_number;
            document.getElementById('edit_status').value = data.status;
            
            document.getElementById('editUnitForm').action = `/unit_trucks/${id}`;
            
            new bootstrap.Modal(document.getElementById('editUnitModal')).show();
        });
}

// Auto-hide alerts
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 3000);
</script>

@if(session('success'))
<div class="alert alert-success" style="position: fixed; top: 90px; right: 30px; z-index: 9999; background: #00ff00; color: #000; border: none; border-radius: 8px; padding: 16px 24px; font-weight: 600;">
    {{ session('success') }}
</div>
@endif
@endsection