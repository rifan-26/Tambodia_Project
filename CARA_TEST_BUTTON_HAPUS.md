# Cara Test Button Hapus - Master Profile

## 🔍 Langkah Testing

### 1. Clear Browser Cache
**Penting!** Browser mungkin masih cache file JavaScript lama.

**Cara:**
- Tekan `Ctrl + Shift + Delete` (Windows/Linux) atau `Cmd + Shift + Delete` (Mac)
- Pilih "Cached images and files"
- Klik "Clear data"

**Atau Hard Refresh:**
- Tekan `Ctrl + F5` (Windows/Linux) atau `Cmd + Shift + R` (Mac)

### 2. Buka Halaman Master Profile
```
http://127.0.0.1:8000/staff
```

### 3. Buka Developer Console
- Tekan `F12` atau `Ctrl + Shift + I`
- Pilih tab "Console"

### 4. Verifikasi Libraries Loaded
Di Console, harus muncul:
```
DOM Content Loaded
SweetAlert2 loaded: true
jQuery loaded: true
Toastify loaded: true
Loaded X staff members
```

### 5. Test Button Hapus

#### A. Klik Button Hapus
- Klik button merah "Hapus" pada salah satu card petugas
- **JANGAN** sampai redirect ke halaman kosong!

#### B. Periksa Console Log
Harus muncul:
```
Delete button clicked for staff ID: X Name: Nama Staff
```

#### C. Dialog Konfirmasi Muncul
- Dialog SweetAlert2 harus muncul dengan:
  - Title: "Hapus Petugas?"
  - Pesan: "Apakah Anda yakin ingin menghapus petugas 'Nama Staff'?"
  - Button: "Ya, Hapus!" (merah) dan "Batal" (abu-abu)

#### D. Konfirmasi Hapus
- Klik "Ya, Hapus!"
- Loading overlay harus muncul
- Console log harus muncul:
  ```
  Deleting staff with ID: X
  Delete response status: 200
  ```

#### E. Verifikasi Hasil
- Dialog sukses muncul: "Berhasil! Petugas berhasil dihapus"
- Card petugas hilang dari list
- Data di-refresh otomatis

### 6. Periksa Network Tab (Optional)

#### Buka Network Tab
- Di DevTools, pilih tab "Network"
- Klik button Hapus dan konfirmasi

#### Verifikasi Request
Harus ada request dengan:
- **Name:** `delete`
- **URL:** `http://127.0.0.1:8000/api/staff/X/delete`
- **Method:** `POST`
- **Status:** `200 OK`
- **Response:**
  ```json
  {
    "success": true,
    "message": "Staff berhasil dihapus"
  }
  ```

## ❌ Masalah yang Harus TIDAK Terjadi

### 1. Redirect ke Halaman Kosong
**Gejala:** Setelah klik button hapus, browser navigate ke URL `/api/staff/X/delete` dan menampilkan halaman kosong atau JSON.

**Jika masih terjadi:**
- Hard refresh browser (Ctrl + F5)
- Clear browser cache completely
- Restart browser
- Periksa apakah ada JavaScript error di Console

### 2. Dialog Tidak Muncul
**Gejala:** Klik button hapus tapi tidak ada dialog konfirmasi.

**Solusi:**
- Periksa Console: `SweetAlert2 loaded: true`
- Jika false, refresh halaman
- Periksa koneksi internet (CDN SweetAlert2)

### 3. Error 404 atau 405
**Gejala:** Request gagal dengan error 404 (Not Found) atau 405 (Method Not Allowed).

**Solusi:**
```bash
# Clear Laravel cache
php artisan optimize:clear

# Verify route
php artisan route:list --name=staff
```

## ✅ Checklist Testing

- [ ] Hard refresh browser (Ctrl + F5)
- [ ] Console log "SweetAlert2 loaded: true" muncul
- [ ] Klik button Hapus TIDAK redirect ke halaman kosong
- [ ] Console log "Delete button clicked..." muncul
- [ ] Dialog SweetAlert2 konfirmasi muncul
- [ ] Klik "Ya, Hapus!" menampilkan loading overlay
- [ ] Console log "Deleting staff..." dan "Delete response status: 200" muncul
- [ ] Dialog sukses muncul
- [ ] Card petugas hilang dari list
- [ ] Network tab menunjukkan POST request berhasil (200 OK)

## 🆘 Jika Masih Bermasalah

### 1. Periksa File Sudah Ter-update
```bash
# Cek timestamp file
ls -la resources/views/staff-manager.blade.php
ls -la routes/web.php
```

### 2. Clear Semua Cache
```bash
# Laravel cache
php artisan optimize:clear

# Browser cache
Ctrl + Shift + Delete → Clear all
```

### 3. Restart Development Server
```bash
# Stop server (Ctrl + C)
# Start again
php artisan serve
```

### 4. Test di Browser Lain
- Chrome
- Firefox
- Edge

### 5. Periksa Console untuk Error
- Buka Console (F12)
- Lihat apakah ada error merah
- Screenshot dan laporkan error tersebut

## 📸 Screenshot yang Dibutuhkan Jika Masih Error

1. Console tab (F12) - menunjukkan semua log dan error
2. Network tab - menunjukkan request DELETE/POST
3. Screenshot halaman kosong (jika masih terjadi)
4. Screenshot dialog SweetAlert2 (jika muncul)

---
**Last Updated:** 30 Oktober 2025
**Status:** Ready for Testing
