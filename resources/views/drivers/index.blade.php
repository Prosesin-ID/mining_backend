@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-title h2 {
        font-size: 28px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 5px 0;
    }

    .page-title p {
        font-size: 14px;
        color: #888;
        margin: 0;
    }

    .btn-add {
        padding: 12px 24px;
        background: #D4AF37;
        color: #000;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-add:hover {
        background: #C19B2C;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }

    .search-bar {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 25px;
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        background: rgba(30, 30, 30, 0.5);
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        transition: all 0.3s;
    }

    .search-box input:focus {
        outline: none;
        border-color: #D4AF37;
        background: rgba(40, 40, 40, 0.7);
    }

    .search-box svg {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        fill: #888;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.yellow {
        background: rgba(212, 175, 55, 0.15);
    }

    .stat-icon.green {
        background: rgba(74, 222, 128, 0.15);
    }

    .stat-icon.orange {
        background: rgba(245, 158, 11, 0.15);
    }

    .stat-icon svg {
        width: 28px;
        height: 28px;
    }

    .stat-icon.yellow svg {
        fill: #D4AF37;
    }

    .stat-icon.green svg {
        fill: #4ade80;
    }

    .stat-icon.orange svg {
        fill: #f59e0b;
    }

    .stat-info h3 {
        font-size: 32px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 5px 0;
    }

    .stat-info p {
        font-size: 13px;
        color: #888;
        margin: 0;
    }

    .table-card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-header {
        padding: 20px 25px;
        border-bottom: 1px solid #2a2a2a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-header svg {
        width: 24px;
        height: 24px;
        fill: #D4AF37;
    }

    .table-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: rgba(30, 30, 30, 0.5);
    }

    .data-table thead th {
        padding: 15px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #D4AF37;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        padding: 18px 20px;
        color: #ccc;
        font-size: 14px;
    }

    .driver-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .driver-avatar {
        width: 35px;
        height: 35px;
        background: #D4AF37;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .driver-avatar svg {
        width: 20px;
        height: 20px;
        fill: #000;
    }

    .driver-info span {
        color: #fff;
        font-weight: 500;
        display: block;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #888;
    }

    .contact-item svg {
        width: 14px;
        height: 14px;
        fill: #888;
    }

    .owner-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .owner-icon {
        width: 30px;
        height: 30px;
        background: rgba(212, 175, 55, 0.15);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .owner-icon svg {
        width: 16px;
        height: 16px;
        fill: #D4AF37;
    }

    .owner-details .company {
        font-weight: 500;
        color: #fff;
        display: block;
    }

    .owner-details .type {
        font-size: 12px;
        color: #888;
    }

    .unit-badge {
        display: inline-block;
        padding: 6px 14px;
        background: rgba(212, 175, 55, 0.15);
        color: #D4AF37;
        border: 1px solid #D4AF37;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: rgba(74, 222, 128, 0.15);
        color: #4ade80;
        border: 1px solid #4ade80;
    }

    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border: 1px solid #ef4444;
    }

    .status-badge.ditangguhkan {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border: 1px solid #f59e0b;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #2a2a2a;
        background: transparent;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-icon svg {
        width: 16px;
        height: 16px;
        fill: #888;
    }

    .btn-icon:hover {
        background: rgba(212, 175, 55, 0.1);
        border-color: #D4AF37;
    }

    .btn-icon:hover svg {
        fill: #D4AF37;
    }

    .btn-icon.delete:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
    }

    .btn-icon.delete:hover svg {
        fill: #ef4444;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: #1a1a1a;
        border: 1px solid #D4AF37;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
    }

    .modal-header {
        padding: 25px 30px;
        border-bottom: 1px solid #2a2a2a;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 20px;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid #2a2a2a;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .modal-close:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
    }

    .modal-close svg {
        width: 18px;
        height: 18px;
        fill: #888;
    }

    .modal-close:hover svg {
        fill: #ef4444;
    }

    .modal-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #D4AF37;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        background: rgba(30, 30, 30, 0.5);
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #D4AF37;
        background: rgba(40, 40, 40, 0.7);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #2a2a2a;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel {
        padding: 10px 20px;
        background: transparent;
        border: 1px solid #2a2a2a;
        color: #888;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #ef4444;
    }

    .btn-submit {
        padding: 10px 20px;
        background: #D4AF37;
        border: none;
        color: #000;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-submit:hover {
        background: #C19B2C;
        transform: translateY(-2px);
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: rgba(74, 222, 128, 0.15);
        border: 1px solid #4ade80;
        color: #4ade80;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        {{ $message }}
    </div>
@endif

<div class="page-header">
    <div class="page-title">
        <h2>AKUN DRIVER</h2>
        <p>Kelola data akun driver</p>
    </div>
    <button class="btn-add" onclick="openModal('addModal')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
        TAMBAH DRIVER
    </button>
</div>

<div class="search-bar">
    <div class="search-box">
        <svg viewBox="0 0 24 24">
            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Cari nama driver, telepon, atau pemilik..." onkeyup="searchTable()">
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
            </svg>
        </div>
        <div class="stat-info">
            <h3>{{ $drivers->count() }}</h3>
            <p>Total Driver</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
        </div>
        <div class="stat-info">
            <h3>{{ $drivers->where('status', 'active')->count() }}</h3>
            <p>Driver Aktif</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
        </div>
        <div class="stat-info">
            <h3>{{ $drivers->where('status', 'inactive')->count() }}</h3>
            <p>Driver Nonaktif</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <svg viewBox="0 0 24 24">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        <h3>DAFTAR DRIVER</h3>
    </div>
    <table class="data-table" id="driverTable">
        <thead>
            <tr>
                <th>NAMA</th>
                <th>KONTAK</th>
                <th>PEMILIK KENDARAAN</th>
                <th>UNIT</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drivers as $driver)
            <tr>
                <td>
                    <div class="driver-name">
                        <div class="driver-avatar">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div class="driver-info">
                            <span>{{ $driver->name }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="contact-info">
                        <div class="contact-item">
                            <svg viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            {{ $driver->phone }}
                        </div>
                        <div class="contact-item">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            {{ $driver->email }}
                        </div>
                    </div>
                </td>
                <td>
                    <div class="owner-info">
                        <div class="owner-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                            </svg>
                        </div>
                        <div class="owner-details">
                            <span class="company">{{ $driver->nama_pemilik }}</span>
                            <span class="type">{{ $driver->own_type }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    @if($driver->unitTruck)
                        <span class="unit-badge">{{ $driver->unitTruck->no_unit }}</span>
                    @else
                        <span class="unit-badge" style="opacity: 0.5;">Belum Ada Unit</span>
                    @endif
                </td>
                <td>
                    <span class="status-badge {{ $driver->status }}">
                        @if($driver->status == 'active')
                            AKTIF
                        @elseif($driver->status == 'inactive')
                            NONAKTIF
                        @else
                            DITANGGUHKAN
                        @endif
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="editDriver({{ $driver->id }})" title="Edit">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                        </button>
                        <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus driver ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus">
                                <svg viewBox="0 0 24 24">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #888;">
                    Belum ada data driver
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Driver Baru</h3>
            <button class="modal-close" onclick="closeModal('addModal')">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('drivers.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add_name">Nama Driver *</label>
                    <input type="text" id="add_name" name="name" placeholder="Masukkan nama driver" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="add_phone">No. Telepon *</label>
                        <input type="text" id="add_phone" name="phone" placeholder="08123456789" required>
                    </div>
                    <div class="form-group">
                        <label for="add_email">Email *</label>
                        <input type="email" id="add_email" name="email" placeholder="driver@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="add_password">Password *</label>
                    <input type="password" id="add_password" name="password" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="form-group">
                    <label for="add_own_type">Tipe Kepemilikan *</label>
                    <select id="add_own_type" name="own_type" required>
                        <option value="">Pilih Tipe</option>
                        <option value="PT/perusahaan">PT/Perusahaan</option>
                        <option value="perseorangan">Perseorangan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="add_nama_pemilik">Nama Pemilik Kendaraan *</label>
                    <input type="text" id="add_nama_pemilik" name="nama_pemilik" placeholder="Masukkan nama pemilik" required>
                </div>

                <div class="form-group">
                    <label for="add_status">Status *</label>
                    <select id="add_status" name="status" required>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                        <option value="ditangguhkan">Ditangguhkan</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Driver</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Driver</h3>
            <button class="modal-close" onclick="closeModal('editModal')">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_name">Nama Driver *</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_phone">No. Telepon *</label>
                        <input type="text" id="edit_phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email *</label>
                        <input type="email" id="edit_email" name="email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_password">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" id="edit_password" name="password" placeholder="Minimal 8 karakter">
                </div>

                <div class="form-group">
                    <label for="edit_own_type">Tipe Kepemilikan *</label>
                    <select id="edit_own_type" name="own_type" required>
                        <option value="PT/perusahaan">PT/Perusahaan</option>
                        <option value="perseorangan">Perseorangan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_nama_pemilik">Nama Pemilik Kendaraan *</label>
                    <input type="text" id="edit_nama_pemilik" name="nama_pemilik" required>
                </div>

                <div class="form-group">
                    <label for="edit_status">Status *</label>
                    <select id="edit_status" name="status" required>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                        <option value="ditangguhkan">Ditangguhkan</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-submit">Update Driver</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function editDriver(id) {
        fetch(`/drivers/${id}/edit`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('edit_name').value = data.name || '';
            document.getElementById('edit_phone').value = data.phone || '';
            document.getElementById('edit_email').value = data.email || '';
            document.getElementById('edit_password').value = ''; // Reset password
            document.getElementById('edit_own_type').value = data.own_type || '';
            document.getElementById('edit_nama_pemilik').value = data.nama_pemilik || '';
            document.getElementById('edit_status').value = data.status || 'active';
            document.getElementById('editForm').action = `/drivers/${id}`;
            openModal('editModal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data driver: ' + error.message);
        });
    }

    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('driverTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            // Search in name, phone, email, and owner name
            for (let j = 0; j < 3; j++) {
                if (cells[j]) {
                    const textValue = cells[j].textContent || cells[j].innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            rows[i].style.display = found ? '' : 'none';
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('active');
        }
    }
</script>

@endsection