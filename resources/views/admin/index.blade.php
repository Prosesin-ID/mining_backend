@extends('layouts.app')

@section('content')
<style>
    .admin-card {
        background: #1a1a1a;
        border: 2px solid #D4AF37;
        border-radius: 12px;
        padding: 24px;
        position: relative;
        transition: all 0.3s;
        min-height: 280px;
        display: flex;
        flex-direction: column;
    }
    
    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
    }
    
    .admin-icon {
        width: 60px;
        height: 60px;
        background: #D4AF37;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    
    .admin-icon svg {
        width: 35px;
        height: 35px;
        fill: #000;
    }
    
    .role-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(212, 175, 55, 0.15);
        color: #D4AF37;
        border: 1px solid #D4AF37;
    }
    
    .admin-name {
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    
    .admin-email {
        font-size: 14px;
        font-weight: 500;
        color: #D4AF37;
        margin-bottom: 20px;
        word-break: break-all;
    }
    
    .admin-info {
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
        font-size: 13px;
    }
    
    .info-row svg {
        width: 16px;
        height: 16px;
        fill: #666;
    }
    
    .admin-actions {
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
    
    .table-admin-id {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    }
    
    .table-admin-id svg {
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
    
    .form-control {
        background: #0a0a0a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 12px 16px;
        color: #fff;
        font-size: 14px;
        transition: all 0.3s;
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
            <h2 style="color: #fff; font-size: 32px; font-weight: 700; margin: 0;">ADMIN ACCOUNTS</h2>
            <p style="color: #888; font-size: 14px; margin: 0;">Kelola akun administrator</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
            </svg>
            TAMBAH ADMIN
        </button>
    </div>

    <!-- Search Box -->
    <div class="mb-4">
        <input type="text" class="search-box" id="searchBox" placeholder="🔍 Cari nama atau email admin...">
    </div>

    <!-- Admin Cards Grid -->
    <div class="row g-4 mb-5" id="adminCards">
        @foreach($admins as $admin)
        <div class="col-md-6 col-lg-4 admin-item" data-name="{{ strtolower($admin->name) }}" data-email="{{ strtolower($admin->email) }}">
            <div class="admin-card">
                <span class="role-badge">ADMIN</span>
                
                <div class="admin-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                
                <div class="admin-name">{{ $admin->name }}</div>
                <div class="admin-email">{{ $admin->email }}</div>
                
                <div class="admin-info">
                    <div class="info-row">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                        </svg>
                        Dibuat: {{ $admin->created_at->format('d M Y') }}
                    </div>
                </div>
                
                <div class="admin-actions">
                    <button class="btn-edit" onclick="editAdmin({{ $admin->id }})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                        EDIT
                    </button>
                    <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus admin ini?')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <h3>DAFTAR ADMIN</h3>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>DIBUAT</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody id="adminTable">
                @foreach($admins as $admin)
                <tr class="admin-row" data-name="{{ strtolower($admin->name) }}" data-email="{{ strtolower($admin->email) }}">
                    <td>
                        <div class="table-admin-id">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            #{{ $admin->id }}
                        </div>
                    </td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <div class="table-actions">
                            <button class="icon-btn edit" onclick="editAdmin({{ $admin->id }})">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-btn delete" onclick="return confirm('Yakin hapus admin ini?')">
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

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required minlength="8">
                        <small style="color: #888; font-size: 12px;">Minimal 8 karakter</small>
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

<!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAdminForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password" id="edit_password" minlength="8">
                        <small style="color: #888; font-size: 12px;">Kosongkan jika tidak ingin mengubah password</small>
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
function editAdmin(id) {
    fetch(`/admin/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_password').value = '';
            
            document.getElementById('editAdminForm').action = `/admin/${id}`;
            
            new bootstrap.Modal(document.getElementById('editAdminModal')).show();
        });
}

// Search functionality
document.getElementById('searchBox').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    
    // Filter cards
    document.querySelectorAll('.admin-item').forEach(item => {
        const name = item.dataset.name;
        const email = item.dataset.email;
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Filter table rows
    document.querySelectorAll('.admin-row').forEach(row => {
        const name = row.dataset.name;
        const email = row.dataset.email;
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

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
