# ✅ Fix: Route Names di Template Builder

## Problem
Error saat mengakses `/admin/templates/create`:
```
Route [input] not defined.
Route [jadwal] not defined.
Route [staff-manager] not defined.
```

## Root Cause
Di sidebar template builder, route names yang digunakan tidak sesuai dengan yang didefinisikan di `routes/web.php`:

**Yang Salah:**
- `route('input')` ❌
- `route('jadwal')` ❌
- `route('staff-manager')` ❌

**Yang Benar:**
- `route('media.input')` ✅
- `route('schedule.index')` ✅
- `route('staff.index')` ✅

## Solution
Update route names di sidebar template builder.

### File yang Diupdate:
**`resources/views/admin/templates/builder.blade.php`**

```php
// BEFORE (❌ Error)
<a href="{{ route('input') }}" class="nav-link">
<a href="{{ route('jadwal') }}" class="nav-link">
<a href="{{ route('staff-manager') }}" class="nav-link">

// AFTER (✅ Fixed)
<a href="{{ route('media.input') }}" class="nav-link">
<a href="{{ route('schedule.index') }}" class="nav-link">
<a href="{{ route('staff.index') }}" class="nav-link">
```

## Route Names Reference
Untuk referensi, berikut adalah route names yang benar:

| Menu | Route Name | URL |
|------|-----------|-----|
| Dashboard | `dashboard.pegawai` | `/dashboard` |
| Input Media | `media.input` | `/input` |
| Jadwal Media | `schedule.index` | `/schedule` |
| Master Layout | `layout` | `/layout` |
| Staff Manager | `staff.index` | `/staff` |
| Logout | `logout` | `/logout` |

## Testing:
1. ✅ Akses `/admin/templates/create` - Tidak ada error lagi
2. ✅ Klik menu sidebar - Semua link berfungsi
3. ✅ Navigasi antar halaman - Smooth
4. ✅ Template builder - Berfungsi normal

## Status: ✅ FIXED
Error "Route not defined" di template builder sudah teratasi!

## Note:
File `template-selector.blade.php` sudah menggunakan route names yang benar sejak awal, jadi tidak perlu diupdate.
