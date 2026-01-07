# 📍 Checkpoint Management System - Google Maps Integration

> Sistem manajemen checkpoint dengan integrasi Google Maps untuk memudahkan pemilihan lokasi secara visual dan akurat.

---

## 🌟 Fitur Utama

### ✨ Integrasi Google Maps Interactive
- **Klik & Point**: Klik langsung di peta untuk set koordinat
- **Search Location**: Cari alamat atau nama tempat
- **Drag Marker**: Pindahkan marker untuk posisi yang lebih tepat  
- **Current Location**: Deteksi lokasi saat ini otomatis
- **Visual Feedback**: Lihat koordinat real-time saat memilih lokasi

### 🎯 Checkpoint Management
- Tambah, edit, hapus checkpoint
- Kategori: Bongkar & Quarry
- Radius detection zone
- Status aktif/nonaktif
- Search & filter data

---

## 📁 Struktur File

```
mining_backend/
├── 📄 GOOGLE_MAPS_SETUP.md           # Panduan lengkap setup Google Maps API
├── 🚀 QUICK_START_GOOGLE_MAPS.md     # Quick start 5 menit
├── 📋 GOOGLE_MAPS_INTEGRATION.md     # File ini
├── 📝 .env.google-maps.example       # Contoh konfigurasi .env
│
├── resources/views/checkpoints/
│   └── index.blade.php               # View dengan Google Maps terintegrasi
│
├── app/
│   ├── Models/
│   │   └── CheckPoint.php            # Model Checkpoint
│   └── Http/Controllers/
│       └── CheckPointController.php  # Controller Checkpoint
│
└── .env                              # Konfigurasi environment (tambahkan API Key di sini)
```

---

## 🚀 Quick Setup

### 1. Setup Google Maps API Key

```bash
# Ikuti panduan lengkap di:
# - GOOGLE_MAPS_SETUP.md (Panduan detail)
# - QUICK_START_GOOGLE_MAPS.md (Setup cepat)
```

### 2. Tambahkan ke .env

```env
GOOGLE_MAPS_API_KEY=AIzaSyD...your-actual-api-key
```

### 3. Jalankan Aplikasi

```bash
php artisan serve
```

### 4. Akses Halaman Checkpoint

```
http://localhost:8000/checkpoints
```

---

## 📖 Dokumentasi

### 📚 Panduan Setup (Pilih salah satu sesuai kebutuhan)

#### Untuk Pengguna Baru:
👉 **[QUICK_START_GOOGLE_MAPS.md](QUICK_START_GOOGLE_MAPS.md)**
- Setup dalam 5 menit
- Langkah-langkah singkat dan jelas
- Troubleshooting cepat

#### Untuk Detail Lengkap:
👉 **[GOOGLE_MAPS_SETUP.md](GOOGLE_MAPS_SETUP.md)**
- Panduan lengkap step-by-step dengan screenshot guidance
- Penjelasan setiap konfigurasi
- Security best practices
- Pricing & quota information
- Troubleshooting mendalam

---

## 🎮 Cara Penggunaan

### Menambah Checkpoint Baru

1. **Klik tombol "TAMBAH CHECKPOINT"**
2. **Modal akan terbuka dengan peta interaktif**
3. **Pilih lokasi dengan salah satu cara:**
   - 🖱️ Klik langsung di peta
   - 🔍 Ketik alamat di search box
   - 📍 Klik "Lokasi Saya" untuk gunakan GPS
4. **Drag marker untuk fine-tuning posisi**
5. **Koordinat akan otomatis terisi**
6. **Isi form:**
   - Nama Checkpoint
   - Kategori (Bongkar/Quarry)
   - Radius (meter)
   - Status (Aktif/Nonaktif)
7. **Klik "Simpan Checkpoint"**

### Edit Checkpoint

1. **Klik icon Edit (pensil) pada checkpoint yang ingin diubah**
2. **Modal akan terbuka dengan:**
   - Peta menampilkan lokasi saat ini
   - Form terisi dengan data yang ada
3. **Update lokasi jika perlu:**
   - Klik di peta untuk pindah lokasi
   - Drag marker untuk adjust
   - Search lokasi baru
4. **Update data lainnya**
5. **Klik "Update Checkpoint"**

---

## 🎯 Tips & Best Practices

### Memilih Lokasi yang Akurat

#### Zoom Level:
- **Zoom 10-12**: Untuk lihat area kota
- **Zoom 15-16**: Untuk pilih lokasi spesifik (Recommended)
- **Zoom 18-20**: Untuk detail bangunan

#### Search Tips:
```
✅ Good:
- "Bundaran HI, Jakarta"
- "Pelabuhan Tanjung Priok"
- "Jl. Sudirman No. 1, Jakarta"

❌ Avoid:
- "HI"
- "Priok"
- "Jalan"
```

#### Verifikasi Koordinat:
- **Indonesia Latitude**: -11° hingga 6°
- **Indonesia Longitude**: 95° hingga 141°
- Jika di luar range, cek ulang lokasi

---

## 🛠️ Troubleshooting

### Peta Tidak Muncul

**Kemungkinan Penyebab:**
1. API Key belum diset di `.env`
2. Maps JavaScript API belum di-enable
3. Internet connection issue

**Solusi:**
```bash
# 1. Cek .env
cat .env | grep GOOGLE_MAPS_API_KEY

# 2. Clear cache Laravel
php artisan config:clear
php artisan cache:clear

# 3. Restart server
php artisan serve
```

### Error "RefererNotAllowedMapError"

**Penyebab**: API Key restrictions terlalu ketat

**Solusi**:
1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Edit API Key
3. Tambahkan di HTTP referrers:
   ```
   http://localhost:8000/*
   http://127.0.0.1:8000/*
   https://yourdomain.com/*
   ```

### Koordinat Tidak Terisi

**Check:**
1. Buka browser console (F12)
2. Lihat error messages
3. Pastikan JavaScript tidak blocked
4. Cek apakah Google Maps API sudah load

**Quick Fix:**
```javascript
// Di browser console, test:
console.log(typeof google);
// Should return: "object"

console.log(GOOGLE_MAPS_API_KEY);
// Should return: "AIzaSy..."
```

---

## 🔐 Security Checklist

### Development:
- [x] API Key di `.env` (tidak di-hardcode)
- [x] `.env` ada di `.gitignore`
- [x] Testing di localhost

### Production:
- [ ] Setup API Key restrictions (HTTP referrers)
- [ ] Setup API restrictions (pilih API yang digunakan)
- [ ] Setup billing alerts di Google Cloud
- [ ] Monitor usage secara berkala
- [ ] Gunakan HTTPS untuk domain production

---

## 📊 Google Maps Quota

### Free Tier (Per Bulan):
| Service | Quota | Cukup untuk |
|---------|-------|-------------|
| Maps JavaScript API | 28,000 loads | ~900 loads/hari |
| Geocoding API | 40,000 requests | ~1,300 requests/hari |
| Static Maps API | 25,000 loads | ~800 loads/hari |

### Kredit Gratis:
- 💰 **$200/bulan** untuk semua Google Maps Platform APIs
- Cukup untuk aplikasi skala kecil-menengah

### Monitor Usage:
```
Dashboard: https://console.cloud.google.com/apis/dashboard
```

---

## 🧪 Testing

### Manual Testing Checklist:

#### Basic Functionality:
- [ ] Peta muncul saat buka modal
- [ ] Klik di peta menghasilkan marker
- [ ] Koordinat terisi otomatis
- [ ] Marker bisa di-drag
- [ ] Koordinat update saat drag marker

#### Search Feature:
- [ ] Search box berfungsi
- [ ] Enter key trigger search
- [ ] Hasil search center peta
- [ ] Marker muncul di hasil search

#### Current Location:
- [ ] Browser minta izin lokasi
- [ ] Peta center ke lokasi saat ini
- [ ] Marker muncul di lokasi

#### Form Submission:
- [ ] Koordinat tersimpan ke database
- [ ] Validasi form berjalan
- [ ] Success message muncul
- [ ] Data muncul di tabel

---

## 🔄 Update & Maintenance

### Update Google Maps API:
Google Maps API selalu update otomatis via CDN. Tidak perlu action dari developer.

### Update Laravel Views:
```bash
# Clear view cache jika ada perubahan
php artisan view:clear

# Restart server
php artisan serve
```

### Monitor API Usage:
```bash
# Set reminder bulanan untuk cek:
1. Usage di Google Cloud Console
2. Billing alerts
3. API restrictions masih tepat
```

---

## 📞 Support & Resources

### Dokumentasi:
- 📘 [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript)
- 📙 [Geocoding API](https://developers.google.com/maps/documentation/geocoding)
- 📗 [Laravel Documentation](https://laravel.com/docs)

### Tools:
- 🛠️ [Google Cloud Console](https://console.cloud.google.com/)
- 🔍 [Google Maps Platform](https://mapsplatform.google.com/)
- 💳 [Billing Dashboard](https://console.cloud.google.com/billing)

### Community:
- 💬 Stack Overflow: [google-maps tag](https://stackoverflow.com/questions/tagged/google-maps)
- 🐛 Issue Tracker: [Google Maps Platform](https://issuetracker.google.com/issues?q=componentid:187242)

---

## 📝 Changelog

### Version 1.0.0 (Current)
- ✨ Initial Google Maps integration
- 🗺️ Interactive map with click-to-select
- 🔍 Location search (Geocoding)
- 📍 Current location detection
- 🎯 Draggable markers
- 📊 Real-time coordinate display
- 🎨 Dark theme map styling
- 📱 Responsive design

---

## 🤝 Contributing

Untuk improvement atau bug fixes:

1. Test perubahan secara menyeluruh
2. Update dokumentasi jika perlu
3. Pastikan tidak break existing features
4. Test di berbagai browser (Chrome, Firefox, Safari, Edge)

---

## 📄 License

Project ini menggunakan lisensi yang sama dengan aplikasi Mining Backend.

**Google Maps Platform**: Tunduk pada [Google Maps Platform Terms of Service](https://cloud.google.com/maps-platform/terms)

---

## ✅ Final Checklist

Sebelum deploy ke production:

- [ ] API Key sudah diset di `.env` production
- [ ] API restrictions sudah dikonfigurasi
- [ ] HTTP referrers sudah include domain production
- [ ] Billing account sudah disetup
- [ ] Billing alerts sudah dikonfigurasi
- [ ] Testing di production environment
- [ ] Monitoring dashboard sudah disetup
- [ ] Backup API Key disimpan di tempat aman
- [ ] Team sudah ditraining cara gunakan fitur
- [ ] Dokumentasi sudah dibagikan ke team

---

## 🎉 Selamat!

Anda sekarang memiliki sistem Checkpoint Management dengan Google Maps terintegrasi!

**Features unlocked:**
- ✅ Point & click location selection
- ✅ Visual coordinate management  
- ✅ Real-time location search
- ✅ Professional mapping interface

**Happy Mapping!** 🗺️✨

---

<p align="center">
  Made with ❤️ for Mining Backend Project<br>
  <small>Powered by Laravel & Google Maps Platform</small>
</p>
