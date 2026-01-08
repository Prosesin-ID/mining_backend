# Fitur Peta Interaktif - Dashboard Admin

## Deskripsi
Peta interaktif pada dashboard admin untuk monitoring real-time lokasi driver dan checkpoint dengan fitur navigasi dan filter.

## Fitur yang Ditambahkan

### 1. **Marker dengan 3 Warna**
- 🔵 **Biru** - Lokasi Admin (user yang login)
- 🟡 **Kuning/Orange** - Lokasi Driver
  - Kuning (#D4AF37): Driver sudah check-in
  - Orange (#f59e0b): Driver belum check-in
- 🟢 **Hijau** - Lokasi Checkpoint (#10b981)

### 2. **Dropdown Navigation**
#### Navigate to Driver
- Dropdown berisi daftar semua driver aktif
- Format: `[Plat Nomor] - [Nama Driver]`
- Klik untuk langsung zoom dan fokus ke lokasi driver
- Marker akan bounce animation selama 2 detik
- Info window otomatis terbuka

#### Navigate to Checkpoint
- Dropdown berisi daftar semua checkpoint
- Format: `[Nama Checkpoint]`
- Klik untuk langsung zoom dan fokus ke checkpoint
- Marker akan bounce animation selama 2 detik
- Info window otomatis terbuka

### 3. **Filter Show/Hide**
Tiga checkbox untuk toggle visibility:
- ✅ **Show Drivers** - Tampilkan/sembunyikan semua marker driver
- ✅ **Show Checkpoints** - Tampilkan/sembunyikan semua marker checkpoint
- ✅ **Show My Location** - Tampilkan/sembunyikan lokasi admin

Filter dapat dikombinasikan:
- Centang hanya "Drivers" → Tampil driver saja
- Centang hanya "Checkpoints" → Tampil checkpoint saja
- Centang keduanya → Tampil driver + checkpoint
- Uncheck semua → Peta kosong (hanya map background)

### 4. **Info Windows**
#### Driver Info Window
```
🚚 [Plat Nomor]
Driver: [Nama Driver]
Checkpoint: [Nama Checkpoint]
Check-in: [HH:mm:ss]
```

#### Checkpoint Info Window
```
📌 [Nama Checkpoint]
Status: ✓ Active / ✗ Inactive
Radius: [X] km
[Deskripsi jika ada]
```

#### Admin Location Info Window
```
📍 Lokasi Admin
Ini adalah lokasi Anda saat ini
```

### 5. **Auto-Refresh**
- Driver locations di-refresh otomatis setiap **30 detik**
- Checkpoint locations di-load sekali saat init (static data)
- Smooth update tanpa reload halaman

## Backend Implementation

### API Endpoints

#### 1. Get Active Driver Locations
```
GET /api/location/active
```
**Response:**
```json
{
  "success": true,
  "data": [
    {
      "driver_id": 1,
      "driver_name": "John Doe",
      "plate_number": "B 1234 XYZ",
      "checkpoint_name": "Checkpoint A",
      "latitude": -6.2088,
      "longitude": 106.8456,
      "check_in_time": "2026-01-08T10:30:00",
      "is_checked_in": true
    }
  ],
  "count": 5
}
```

#### 2. Get Checkpoint Locations
```
GET /api/checkpoints/locations
```
**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Checkpoint A",
      "latitude": -6.2088,
      "longitude": 106.8456,
      "status": "active",
      "radius": 1,
      "description": "Main entrance"
    }
  ],
  "count": 3
}
```

## Frontend Implementation

### JavaScript Variables
```javascript
let map;                      // Google Maps instance
let markers = {};             // Driver markers storage
let checkpointMarkers = {};   // Checkpoint markers storage
let userLocationMarker = null;// Admin location marker
let userLocation = null;      // Admin coordinates
let allDriversData = [];      // All drivers data
let allCheckpointsData = [];  // All checkpoints data
```

### Key Functions

#### initMap()
- Detect admin location via Geolocation API
- Initialize Google Maps with dark theme
- Create admin location marker (blue)
- Load drivers and checkpoints

#### updateMarkers()
- Fetch active driver locations from API
- Create/update driver markers (yellow/orange)
- Update driver dropdown
- Apply current filters

#### loadCheckpoints()
- Fetch checkpoint locations from API
- Create checkpoint markers (green)
- Update checkpoint dropdown
- Apply current filters

#### applyFilters()
- Show/hide markers based on checkbox state
- Maintain marker state without destroying

#### setupNavigationListeners()
- Handle driver dropdown change
- Handle checkpoint dropdown change
- Center map and zoom to selected location
- Animate marker with bounce effect

## Styling

### Map Controls
- Dark theme consistent dengan dashboard
- Hover effects pada dropdown
- Focus state dengan gold border
- Smooth transitions

### Filter Checkboxes
- Custom styled dengan accent color gold
- Hover effects untuk better UX
- Legend dots dengan border dan shadow

### Info Windows
- Clean white background untuk readability
- Color-coded titles (gold/green/blue)
- Compact information layout

## Usage Tips

1. **Monitor Driver Real-time**
   - Lihat posisi semua driver aktif di peta
   - Warna marker menunjukkan status check-in

2. **Quick Navigation**
   - Gunakan dropdown untuk langsung ke lokasi spesifik
   - Marker akan bounce untuk mudah ditemukan

3. **Focus View**
   - Uncheck "Show Checkpoints" untuk fokus ke driver saja
   - Uncheck "Show Drivers" untuk fokus ke checkpoint saja

4. **Track Your Team**
   - Admin location (blue) selalu tampil untuk referensi
   - Berguna untuk estimasi jarak ke driver/checkpoint

## Browser Compatibility
- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Mobile browsers: ✅ Responsive

## Requirements
- Google Maps API Key (sudah dikonfigurasi)
- Geolocation permission untuk admin location
- Active internet connection untuk map tiles

## Performance
- Efficient marker management (update vs recreate)
- Debounced filter application
- Optimized API calls (30s interval)
- Lazy loading for info windows
