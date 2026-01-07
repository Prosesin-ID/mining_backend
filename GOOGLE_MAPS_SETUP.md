# 🗺️ Panduan Integrasi Google Maps API

## Daftar Isi
- [Persiapan Google Cloud Platform](#persiapan-google-cloud-platform)
- [Mendapatkan API Key](#mendapatkan-api-key)
- [Konfigurasi di Aplikasi Laravel](#konfigurasi-di-aplikasi-laravel)
- [Cara Penggunaan](#cara-penggunaan)
- [Troubleshooting](#troubleshooting)

---

## 📋 Persiapan Google Cloud Platform

### 1. Buat Akun Google Cloud Platform
1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Login dengan akun Google Anda
3. Jika baru pertama kali, Anda akan mendapat **$300 kredit gratis** untuk 90 hari

### 2. Buat Project Baru
1. Di bagian atas halaman, klik **Select a project** atau nama project saat ini
2. Klik tombol **NEW PROJECT**
3. Isi detail project:
   - **Project name**: `Mining Backend` (atau nama yang Anda inginkan)
   - **Location**: Pilih organization jika ada, atau biarkan "No organization"
4. Klik **CREATE**
5. Tunggu beberapa detik hingga project terbuat

---

## 🔑 Mendapatkan API Key

### 1. Aktifkan Google Maps JavaScript API
1. Di Google Cloud Console, pastikan project yang benar sudah dipilih
2. Buka menu navigasi (☰) → **APIs & Services** → **Library**
3. Cari **"Maps JavaScript API"**
4. Klik pada hasil pencarian **Maps JavaScript API**
5. Klik tombol **ENABLE**
6. Tunggu hingga API diaktifkan (biasanya beberapa detik)

### 2. Aktifkan Geocoding API (Opsional tapi Disarankan)
1. Masih di **API Library**
2. Cari **"Geocoding API"**
3. Klik pada hasil pencarian
4. Klik tombol **ENABLE**

> **Catatan**: Geocoding API berguna untuk mengkonversi alamat menjadi koordinat dan sebaliknya

### 3. Buat API Key
1. Buka menu navigasi (☰) → **APIs & Services** → **Credentials**
2. Klik tombol **+ CREATE CREDENTIALS** di bagian atas
3. Pilih **API key**
4. API Key akan dibuat dan muncul di popup
5. **SALIN** API Key yang muncul (contoh: `AIzaSyD...`)
6. Klik **CLOSE**

### 4. Amankan API Key (PENTING!)

#### Langkah-langkah Restrict API Key:
1. Di halaman **Credentials**, temukan API key yang baru dibuat
2. Klik icon **edit** (pensil) di sebelah API key
3. Lakukan konfigurasi berikut:

#### A. Application Restrictions

**Untuk Development (Lokal):**
Anda punya 2 pilihan:

**Pilihan 1: Tanpa Restrictions (RECOMMENDED untuk development)**
- Pilih **None** 
- Ini memudahkan testing di lokal
- ⚠️ Nanti wajib ditambahkan restrictions sebelum production!

**Pilihan 2: Dengan Restrictions (Lebih aman)**
- Pilih **HTTP referrers (web sites)**
- Klik **ADD AN ITEM**
- Tambahkan **hanya localhost** dulu:
  ```
  http://localhost:8000/*
  http://127.0.0.1:8000/*
  ```

**Untuk Production (Nanti setelah deploy):**
- Edit API Key lagi
- Tambahkan domain production:
  ```
  http://localhost:8000/*
  http://127.0.0.1:8000/*
  https://yourdomain.com/*
  ```
  (Ganti `yourdomain.com` dengan domain production Anda)

> 💡 **Tips**: Untuk production, sebaiknya buat API Key terpisah dengan restrictions ketat

#### B. API Restrictions
1. Pilih **Restrict key**
2. Centang API berikut:
   - ✅ Maps JavaScript API
   - ✅ Geocoding API (jika sudah diaktifkan)
3. Klik **SAVE**

---

## ⚙️ Konfigurasi di Aplikasi Laravel

### 1. Simpan API Key di Environment File

Buka file `.env` di root project Laravel Anda, tambahkan:

```env
GOOGLE_MAPS_API_KEY=AIzaSyD...your-actual-api-key
```

> **⚠️ PENTING**: 
> - Ganti `AIzaSyD...your-actual-api-key` dengan API Key asli Anda
> - JANGAN commit file `.env` ke Git!
> - Pastikan `.env` ada di `.gitignore`

### 2. Tambahkan ke Config File (Opsional)

Buat file `config/services.php` atau tambahkan ke file yang sudah ada:

```php
return [
    // ... konfigurasi lain

    'google' => [
        'maps' => [
            'api_key' => env('GOOGLE_MAPS_API_KEY', ''),
        ],
    ],
];
```

### 3. Gunakan di Blade Template

Di file blade view Anda, panggil API key:

```blade
<script>
    const GOOGLE_MAPS_API_KEY = "{{ env('GOOGLE_MAPS_API_KEY') }}";
</script>
```

Atau jika menggunakan config:

```blade
<script>
    const GOOGLE_MAPS_API_KEY = "{{ config('services.google.maps.api_key') }}";
</script>
```

---

## 🎯 Cara Penggunaan

### Fitur yang Tersedia:

#### 1. **Klik di Peta untuk Set Lokasi**
- Klik tombol "Tambah Checkpoint" atau "Edit"
- Modal akan terbuka dengan peta interaktif
- **Klik di manapun pada peta**
- Latitude dan Longitude akan otomatis terisi
- Marker akan muncul di lokasi yang dipilih

#### 2. **Search Location (Geocoding)**
- Ketik alamat atau nama tempat di search box
- Tekan Enter atau klik tombol search
- Peta akan zoom ke lokasi tersebut
- Latitude dan Longitude otomatis terisi

#### 3. **Drag Marker**
- Setelah marker muncul, Anda bisa drag marker tersebut
- Koordinat akan update secara real-time

#### 4. **Current Location**
- Klik tombol "Use My Location"
- Browser akan meminta izin akses lokasi
- Peta akan center ke lokasi Anda saat ini

#### 5. **Manual Input**
- Anda tetap bisa input koordinat manual
- Ketik latitude dan longitude
- Marker akan update otomatis

---

## 🔧 Troubleshooting

### ❌ Peta Tidak Muncul / Error "Google Maps JavaScript API error"

**Penyebab:**
- API Key tidak valid atau belum diset
- API belum diaktifkan
- API Key restrict terlalu ketat

**Solusi:**
1. Periksa API Key di file `.env`
2. Pastikan Maps JavaScript API sudah **ENABLE**
3. Cek browser console (F12) untuk error detail
4. Periksa API restrictions di Google Cloud Console

### ❌ Error "RefererNotAllowedMapError"

**Penyebab:**
- URL aplikasi tidak ada di HTTP referrers restrictions

**Solusi:**
1. Buka Google Cloud Console
2. Edit API Key
3. Tambahkan URL aplikasi ke HTTP referrers:
   ```
   http://localhost:8000/*
   http://127.0.0.1:8000/*
   ```

### ❌ Peta Muncul tapi Tidak Bisa Klik

**Penyebab:**
- JavaScript error
- Z-index modal terlalu tinggi

**Solusi:**
1. Periksa browser console untuk error
2. Pastikan JavaScript Google Maps sudah load dengan benar
3. Cek z-index CSS pada elemen map

### ❌ Search Location Tidak Berfungsi

**Penyebab:**
- Geocoding API belum diaktifkan
- API Key tidak punya akses ke Geocoding API

**Solusi:**
1. Aktifkan **Geocoding API** di Google Cloud Console
2. Tambahkan Geocoding API ke API restrictions di API Key

### ❌ Quota Exceeded / Billing Error

**Penyebab:**
- Belum setup billing account
- Sudah melebihi free tier

**Solusi:**
1. Google Maps API punya free tier:
   - **28,000 map loads per month** (gratis)
   - **40,000 geocoding requests per month** (gratis)
2. Setup billing account di Google Cloud:
   - Buka **Billing** di Google Cloud Console
   - Link credit card (tidak akan dicharge selama masih di free tier)
3. Monitor usage di dashboard

---

## 💰 Pricing Information

### Free Tier (Bulanan):
- ✅ Maps JavaScript API: 28,000 loads
- ✅ Geocoding API: 40,000 requests
- ✅ Static Maps API: 25,000 loads
- ✅ Kredit gratis $200/bulan untuk semua Google Maps Platform APIs

### Biaya setelah Free Tier:
- Maps JavaScript API: $7 per 1,000 loads
- Geocoding API: $5 per 1,000 requests

> **Catatan**: Untuk aplikasi skala kecil hingga menengah, free tier biasanya sudah cukup!

---

## 📱 Tips & Best Practices

### 1. Keamanan
- ✅ Selalu gunakan API restrictions
- ✅ Jangan expose API key di public repository
- ✅ Gunakan HTTP referrers untuk aplikasi web
- ✅ Monitor usage secara berkala

### 2. Performance
- ✅ Load Google Maps script hanya di halaman yang memerlukan
- ✅ Gunakan lazy loading untuk peta
- ✅ Cache geocoding results jika memungkinkan

### 3. UX
- ✅ Berikan feedback visual saat loading
- ✅ Set default location yang masuk akal (Indonesia)
- ✅ Tambahkan zoom controls dan search box
- ✅ Buat marker draggable untuk kemudahan editing

### 4. Development
- ✅ Gunakan API Key berbeda untuk development dan production
- ✅ Test di berbagai browser
- ✅ Handle error dengan graceful fallback

---

## 📞 Support & Resources

### Dokumentasi Resmi:
- [Google Maps JavaScript API Docs](https://developers.google.com/maps/documentation/javascript)
- [Geocoding API Docs](https://developers.google.com/maps/documentation/geocoding)
- [API Key Best Practices](https://developers.google.com/maps/api-security-best-practices)

### Dashboard & Monitoring:
- [Google Cloud Console](https://console.cloud.google.com/)
- [APIs & Services Dashboard](https://console.cloud.google.com/apis/dashboard)
- [Billing Dashboard](https://console.cloud.google.com/billing)

---

## ✅ Checklist Setup

Gunakan checklist ini untuk memastikan setup sudah benar:

- [ ] Buat Google Cloud Project
- [ ] Enable Maps JavaScript API
- [ ] Enable Geocoding API (opsional)
- [ ] Buat API Key
- [ ] Setup API restrictions (HTTP referrers)
- [ ] Setup API restrictions (API list)
- [ ] Simpan API Key di `.env`
- [ ] Test di browser
- [ ] Verifikasi tidak ada error di console
- [ ] Setup billing account (untuk production)

---

## 🎉 Selamat!

Jika Anda sudah mengikuti semua langkah di atas, Google Maps sudah terintegrasi dengan aplikasi Laravel Anda. 

Fitur yang bisa digunakan:
- ✅ Klik di peta untuk set koordinat
- ✅ Search lokasi
- ✅ Drag marker
- ✅ Deteksi lokasi saat ini
- ✅ Input manual koordinat

Happy Mapping! 🗺️
