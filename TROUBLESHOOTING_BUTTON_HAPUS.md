# Troubleshooting Button Hapus - Master Profile

## Masalah: Button Mengarahkan ke Halaman Kosong

### Penyebab
Browser tidak bisa mengirim DELETE request langsung dari onclick event dan akan mencoba navigate ke URL tersebut, menghasilkan halaman kosong.

### Solusi yang Diterapkan
✅ **Route diubah dari DELETE ke POST**
- Sebelum: `DELETE /api/staff/{id}`
- Sesudah: `POST /api/staff/{id}/delete`

✅ **JavaScript fetch method diubah**
```javascript
// Sebelum
fetch(`/api/staff/${id}`, { method: 'DELETE' })

// Sesudah
fetch(`/api/staff/${id}/delete`, { method: 'POST' })
```

## Cara Verifikasi Perbaikan

### 1. Cek Route Terdaftar
```bash
php artisan route:list --name=staff
```

Harus muncul:
```
POST  api/staff/{id}/delete  api.staff.delete › LayoutController_clean@deleteStaff
```

### 2. Test di Browser
1. Buka halaman Master Profile
2. Buka Console Browser (F12)
3. Klik button Hapus
4. Periksa Console log:
   - "Deleting staff with ID: X"
   - "Delete response status: 200"
5. Dialog SweetAlert2 harus muncul
6. Setelah konfirmasi, data harus terhapus

### 3. Cek Network Tab
1. Buka Network tab di DevTools (F12)
2. Klik button Hapus dan konfirmasi
3. Harus ada request:
   - URL: `/api/staff/{id}/delete`
   - Method: `POST`
   - Status: `200 OK`
   - Response: `{"success": true, "message": "Staff berhasil dihapus"}`

## Masalah Umum Lainnya

### SweetAlert2 Tidak Muncul
**Gejala:** Klik button hapus tapi tidak ada dialog konfirmasi

**Solusi:**
1. Cek Console: `SweetAlert2 loaded: true`
2. Jika false, pastikan CDN SweetAlert2 ter-load:
   ```html
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
   ```

### CSRF Token Error
**Gejala:** Error 419 atau "CSRF token mismatch"

**Solusi:**
1. Pastikan meta tag ada di head:
   ```html
   <meta name="csrf-token" content="{{ csrf_token() }}">
   ```
2. Pastikan header di fetch request:
   ```javascript
   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
   ```

### Data Tidak Terhapus
**Gejala:** Dialog sukses muncul tapi data masih ada

**Solusi:**
1. Cek response di Network tab
2. Cek log Laravel: `storage/logs/laravel.log`
3. Pastikan controller method `deleteStaff()` berjalan dengan benar
4. Cek apakah file foto terhapus dari storage

### Button Tidak Bisa Diklik
**Gejala:** Button tidak merespon klik

**Solusi:**
1. Cek apakah fungsi `window.deleteStaff` terdefinisi:
   ```javascript
   console.log(typeof window.deleteStaff); // harus 'function'
   ```
2. Cek onclick attribute di HTML:
   ```html
   onclick="window.deleteStaff(1, 'Nama Staff')"
   ```
3. Pastikan tidak ada JavaScript error di Console

## File yang Terlibat

### Frontend
- `resources/views/staff-manager.blade.php` - View dengan button hapus dan JavaScript

### Backend
- `routes/web.php` - Route definition
- `app/Http/Controllers/LayoutController_clean.php` - Controller method deleteStaff()

### Database
- `staff` table - Data petugas
- `storage/app/public/staff/` - Folder foto petugas

## Testing Checklist

- [ ] Route `POST /api/staff/{id}/delete` terdaftar
- [ ] Console log "SweetAlert2 loaded: true" muncul
- [ ] Button hapus bisa diklik
- [ ] Dialog konfirmasi SweetAlert2 muncul
- [ ] Setelah konfirmasi, loading overlay muncul
- [ ] Request POST ke `/api/staff/{id}/delete` berhasil (status 200)
- [ ] Response JSON: `{"success": true}`
- [ ] Dialog sukses muncul
- [ ] Data petugas hilang dari list
- [ ] Foto petugas terhapus dari storage

## Kontak Support
Jika masalah masih berlanjut, sertakan informasi berikut:
1. Screenshot Console Browser (F12)
2. Screenshot Network tab saat klik button hapus
3. Log dari `storage/logs/laravel.log`
4. Browser dan versi yang digunakan

---
**Last Updated:** 30 Oktober 2025
