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
        text-decoration: none;
    }

    .btn-add:hover {
        background: #C19B2C;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }

    .search-filter-bar {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        display: flex;
        gap: 20px;
    }

    .search-box {
        flex: 1;
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

    .filter-dropdown {
        min-width: 200px;
    }

    .filter-dropdown select {
        width: 100%;
        padding: 12px 15px;
        background: rgba(30, 30, 30, 0.5);
        border: 1px solid #2a2a2a;
        border-radius: 8px;
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-dropdown select:focus {
        outline: none;
        border-color: #D4AF37;
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

    .checkpoint-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkpoint-icon {
        width: 10px;
        height: 10px;
        background: #D4AF37;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .checkpoint-name span {
        color: #fff;
        font-weight: 500;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .category-badge.bongkar {
        background: rgba(212, 175, 55, 0.15);
        color: #D4AF37;
        border: 1px solid #D4AF37;
    }

    .category-badge.quarry {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border: 1px solid #f59e0b;
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
        <h2>CHECKPOINTS</h2>
        <p>Kelola titik checkpoint unit</p>
    </div>
    <button class="btn-add" onclick="openModal('addModal')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
        TAMBAH CHECKPOINT
    </button>
</div>

<div class="search-filter-bar">
    <div class="search-box">
        <svg viewBox="0 0 24 24">
            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Cari checkpoint..." onkeyup="searchTable()">
    </div>
    <div class="filter-dropdown">
        <select id="categoryFilter" onchange="filterTable()">
            <option value="">Semua Kategori</option>
            <option value="bongkar">Bongkar</option>
            <option value="quarry">Quarry</option>
        </select>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <svg viewBox="0 0 24 24">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
        </svg>
        <h3>DAFTAR CHECKPOINT</h3>
    </div>
    <table class="data-table" id="checkpointTable">
        <thead>
            <tr>
                <th>NAMA</th>
                <th>KATEGORI</th>
                <th>KOORDINAT</th>
                <th>RADIUS</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($checkPoints as $checkpoint)
            <tr>
                <td>
                    <div class="checkpoint-name">
                        <div class="checkpoint-icon"></div>
                        <span>{{ $checkpoint->name }}</span>
                    </div>
                </td>
                <td>
                    <span class="category-badge {{ $checkpoint->kategori }}">
                        @if($checkpoint->kategori == 'bongkar')
                            📦 BONGKAR
                        @else
                            ⛏️ QUARRY
                        @endif
                    </span>
                </td>
                <td>{{ $checkpoint->latitude }}, {{ $checkpoint->longitude }}</td>
                <td>{{ $checkpoint->radius }}m</td>
                <td>
                    <span class="status-badge {{ $checkpoint->status == 'active' ? 'active' : 'inactive' }}">
                        {{ $checkpoint->status == 'active' ? 'AKTIF' : 'NONAKTIF' }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="editCheckpoint({{ $checkpoint->id }})" title="Edit">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                        </button>
                        <form action="{{ route('checkpoints.destroy', $checkpoint->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus checkpoint ini?')">
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
                    Belum ada data checkpoint
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
            <h3>Tambah Checkpoint Baru</h3>
            <button class="modal-close" onclick="closeModal('addModal')">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('checkpoints.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="add_name">Nama Checkpoint *</label>
                    <input type="text" id="add_name" name="name" placeholder="Masukkan nama checkpoint" required>
                </div>

                <div class="form-group">
                    <label for="add_kategori">Kategori *</label>
                    <select id="add_kategori" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="bongkar">Bongkar</option>
                        <option value="quarry">Quarry</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="add_latitude">Latitude *</label>
                        <input type="number" step="any" id="add_latitude" name="latitude" placeholder="-6.2088" required>
                    </div>
                    <div class="form-group">
                        <label for="add_longitude">Longitude *</label>
                        <input type="number" step="any" id="add_longitude" name="longitude" placeholder="106.8456" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="add_radius">Radius (meter)</label>
                        <input type="number" id="add_radius" name="radius" placeholder="100" value="100">
                    </div>
                    <div class="form-group">
                        <label for="add_status">Status *</label>
                        <select id="add_status" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 20px; padding: 15px; background: rgba(212, 175, 55, 0.1); border: 1px solid #D4AF37; border-radius: 8px;">
                    <p style="margin: 0; font-size: 12px; color: #D4AF37;">
                        💡 <strong>Tips:</strong> Klik pada peta untuk mendapatkan koordinat, atau masukkan secara manual. Format: Latitude (-6.2088), Longitude (106.8456)
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Checkpoint</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Checkpoint</h3>
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
                    <label for="edit_name">Nama Checkpoint *</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="edit_kategori">Kategori *</label>
                    <select id="edit_kategori" name="kategori" required>
                        <option value="bongkar">Bongkar</option>
                        <option value="quarry">Quarry</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_latitude">Latitude *</label>
                        <input type="number" step="any" id="edit_latitude" name="latitude" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_longitude">Longitude *</label>
                        <input type="number" step="any" id="edit_longitude" name="longitude" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_radius">Radius (meter)</label>
                        <input type="number" id="edit_radius" name="radius">
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status *</label>
                        <select id="edit_status" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-submit">Update Checkpoint</button>
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

    function editCheckpoint(id) {
        console.log('Edit checkpoint ID:', id); // Debug
        
        fetch(`/checkpoints/${id}/edit`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status); // Debug
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data); // Debug
            
            // Pastikan elemen ada sebelum set value
            const nameInput = document.getElementById('edit_name');
            const kategoriSelect = document.getElementById('edit_kategori');
            const latInput = document.getElementById('edit_latitude');
            const longInput = document.getElementById('edit_longitude');
            const radiusInput = document.getElementById('edit_radius');
            const statusSelect = document.getElementById('edit_status');
            const editForm = document.getElementById('editForm');
            
            if (nameInput) nameInput.value = data.name || '';
            if (kategoriSelect) kategoriSelect.value = data.kategori || '';
            if (latInput) latInput.value = data.latitude || '';
            if (longInput) longInput.value = data.longitude || '';
            if (radiusInput) radiusInput.value = data.radius || '';
            if (statusSelect) statusSelect.value = data.status || 'active';
            if (editForm) editForm.action = `/checkpoints/${id}`;
            
            openModal('editModal');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data checkpoint: ' + error.message);
        });
    }

    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('checkpointTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[0];
            if (nameCell) {
                const textValue = nameCell.textContent || nameCell.innerText;
                rows[i].style.display = textValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }

    function filterTable() {
        const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
        const table = document.getElementById('checkpointTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const categoryCell = rows[i].getElementsByTagName('td')[1];
            if (categoryCell) {
                const categoryBadge = categoryCell.querySelector('.category-badge');
                if (categoryBadge) {
                    const category = categoryBadge.classList.contains('bongkar') ? 'bongkar' : 'quarry';
                    rows[i].style.display = categoryFilter === '' || category === categoryFilter ? '' : 'none';
                }
            }
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