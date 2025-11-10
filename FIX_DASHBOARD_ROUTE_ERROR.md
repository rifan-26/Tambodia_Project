# ✅ Fix: Route [dashboard] not defined

## Problem
Error: **Symfony\Component\Routing\Exception\RouteNotFoundException**
```
Route [dashboard] not defined.
```

## Root Cause
Laravel 11 menggunakan route name `dashboard` sebagai default HOME route untuk redirect setelah login, tetapi di aplikasi kita route yang didefinisikan adalah `dashboard.pegawai`, bukan `dashboard`.

## Solution
Menambahkan alias route `dashboard` yang redirect ke `/dashboard` (yang menggunakan name `dashboard.pegawai`).

### File yang Diupdate:
**`routes/web.php`**

```php
// ===== DASHBOARD ROUTES =====
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.pegawai');
// Alias untuk backward compatibility
Route::redirect('/home', '/dashboard')->name('dashboard');
```

## Penjelasan:
1. **Route utama**: `/dashboard` dengan name `dashboard.pegawai` (tetap digunakan di seluruh aplikasi)
2. **Route alias**: `/home` redirect ke `/dashboard` dengan name `dashboard` (untuk Laravel framework)
3. Ini memastikan backward compatibility dengan Laravel framework yang expect route name `dashboard`

## Testing:
1. ✅ Akses `/admin/templates` - Tidak ada error lagi
2. ✅ Login - Redirect ke dashboard berhasil
3. ✅ Route `dashboard.pegawai` tetap berfungsi
4. ✅ Route `dashboard` sekarang tersedia

## Alternative Solution (jika masih error):
Jika masih ada error, bisa juga mengubah semua referensi dari `dashboard.pegawai` menjadi `dashboard`, tapi ini memerlukan update di banyak file.

Solusi saat ini lebih baik karena:
- Minimal changes
- Backward compatible
- Tidak break existing code

## Status: ✅ FIXED
Error "Route [dashboard] not defined" sudah teratasi!
