# 🚀 Quick Start - Google Maps Integration

## ⚡ Langkah Cepat (5 Menit)

### 1️⃣ Dapatkan API Key

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih yang sudah ada
3. **Enable APIs:**
   - Maps JavaScript API
   - Geocoding API (opsional)
4. **Buat Credentials:**
   - Klik "Create Credentials" → "API Key"
   - Copy API Key yang muncul

### 2️⃣ Setup di Laravel

Tambahkan ke file `.env`:

```env
GOOGLE_MAPS_API_KEY=AIzaSyD...your-api-key-here
```

### 3️⃣ Test!

1. Jalankan aplikasi Laravel: `php artisan serve`
2. Buka halaman Checkpoints
3. Klik "Tambah Checkpoint"
4. Peta Google Maps akan muncul!

---

## ✨ Fitur yang Tersedia

### 🖱️ Klik di Peta
- Klik di manapun pada peta untuk set koordinat
- Marker akan muncul otomatis
- Lat/Long langsung terisi

### 🔍 Search Lokasi
```
Contoh pencarian:
- Jakarta, Indonesia
- Monas
- -6.2088, 106.8456
```

### 📍 Drag Marker
- Setelah marker muncul, drag ke posisi yang lebih tepat
- Koordinat update real-time

### 🌍 Lokasi Saya
- Klik tombol "Lokasi Saya"
- Browser akan minta izin
- Peta auto-center ke lokasi Anda

---

## 🛠️ Troubleshooting Cepat

### ❌ Peta Tidak Muncul?

**Solusi:**
1. Cek API Key di `.env` sudah benar
2. Pastikan Maps JavaScript API sudah **ENABLE**
3. Buka browser console (F12) untuk lihat error

### ❌ Error "RefererNotAllowedMapError"?

**Solusi:**
1. Edit API Key di Google Cloud Console
2. Tambahkan di HTTP referrers:
   ```
   http://localhost:8000/*
   http://127.0.0.1:8000/*
   ```

### ❌ Search Tidak Jalan?

**Solusi:**
- Enable **Geocoding API** di Google Cloud Console
- Tunggu 2-3 menit setelah enable API

---

## 💡 Tips Penggunaan

### Untuk Hasil Terbaik:

1. **Zoom yang Tepat:**
   - Zoom in untuk akurasi tinggi
   - Gunakan zoom 15-18 untuk detail lokasi

2. **Search dengan Tepat:**
   - Gunakan nama lengkap lokasi
   - Tambahkan kota/provinsi untuk hasil lebih akurat
   - Contoh: "Bundaran HI, Jakarta" ✅ vs "HI" ❌

3. **Verifikasi Koordinat:**
   - Setelah klik, lihat koordinat di display
   - Pastikan koordinat masuk akal untuk wilayah Anda
   - Indonesia: Lat (-11 s/d 6), Long (95 s/d 141)

4. **Drag untuk Fine-tune:**
   - Gunakan klik untuk lokasi umum
   - Gunakan drag marker untuk posisi tepat

---

## 📊 Quota & Limits

### Free Tier Google Maps:
- ✅ **28,000 map loads/bulan** - GRATIS
- ✅ **40,000 geocoding requests/bulan** - GRATIS
- ✅ **$200 kredit gratis/bulan** untuk semua API

### Monitoring:
Cek usage di: [Google Cloud Console - APIs Dashboard](https://console.cloud.google.com/apis/dashboard)

---

## 🔐 Security Best Practices

### ✅ DO:
- Restrict API Key dengan HTTP referrers
- Gunakan environment variables (`.env`)
- Monitor usage secara berkala
- Set billing alerts di Google Cloud

### ❌ DON'T:
- Commit API Key ke Git
- Share API Key di public
- Biarkan API Key tanpa restrictions

---

## 📚 Dokumentasi Lengkap

Untuk panduan detail, lihat: [GOOGLE_MAPS_SETUP.md](GOOGLE_MAPS_SETUP.md)

---

## 🎯 Checklist Setup

- [ ] Google Cloud Project dibuat
- [ ] Maps JavaScript API enabled
- [ ] API Key dibuat
- [ ] API Key disimpan di `.env`
- [ ] HTTP referrers diset (untuk production)
- [ ] Test buka halaman Checkpoint
- [ ] Peta muncul dan bisa diklik
- [ ] Koordinat terisi otomatis

---

## 💬 Butuh Bantuan?

### Resources:
- 📖 [Dokumentasi Lengkap](GOOGLE_MAPS_SETUP.md)
- 🌐 [Google Maps JS Docs](https://developers.google.com/maps/documentation/javascript)
- 🎥 [Video Tutorial](https://www.youtube.com/results?search_query=google+maps+api+tutorial)

### Common Issues:
1. API Key tidak valid → Cek `.env`
2. Peta abu-abu → API belum enabled
3. Billing error → Setup billing account
4. Quota exceeded → Upgrade atau optimasi usage

---

## 🎉 Selamat!

Google Maps sudah terintegrasi! Sekarang Anda bisa:
- ✅ Klik peta untuk set koordinat
- ✅ Search lokasi
- ✅ Drag marker
- ✅ Gunakan lokasi real-time

**Happy Mapping!** 🗺️
