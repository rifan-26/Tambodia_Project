# 🔧 Check & Fix Template Database

## Langkah-langkah Troubleshooting:

### 1. **Cek Browser Console**
Buka browser console (F12) dan lihat error message yang muncul saat load `/layout`

**Kemungkinan Error:**
- `HTTP error! status: 500` → Server error, cek Laravel log
- `HTTP error! status: 404` → Route tidak ditemukan
- `Column not found` → Migration belum dijalankan
- `undefined` → Response format salah

### 2. **Test API Langsung**
Buka browser dan akses:
```
http://127.0.0.1:8000/api/layout/templates
```

**Expected Response:**
```json
{
  "success": true,
  "templates": []
}
```

**Jika Error 500:**
- Cek Laravel log: `storage/logs/laravel.log`
- Kemungkinan: Column not found, migration belum jalan

### 3. **Run Migration**
```bash
# Check migration status
php artisan migrate:status

# Run migration
php artisan migrate

# Jika ada error, rollback dulu
php artisan migrate:rollback
php artisan migrate
```

### 4. **Check Database Structure**
```bash
# Masuk ke database
php artisan tinker

# Check columns
\DB::select("DESCRIBE layout_templates");
```

**Expected Columns:**
- id
- name
- description
- thumbnail_path ✅ (NEW)
- grid_type ✅ (NEW)
- grid_config ✅ (NEW)
- elements ✅ (NEW)
- is_active
- created_by
- created_at
- updated_at
- deleted_at

**Jika kolom lama masih ada:**
- background_media_id ❌ (OLD - harus dihapus)
- grid_positions ❌ (OLD - harus dihapus)
- layout_description ❌ (OLD - harus dihapus)

### 5. **Clear All Cache**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 6. **Test Create Template**
```bash
php artisan tinker

# Create test template
$template = new \App\Models\LayoutTemplate();
$template->name = 'Test Template';
$template->description = 'Test';
$template->grid_type = '2x2';
$template->grid_config = ['columns' => 2, 'rows' => 2];
$template->elements = [];
$template->is_active = false;
$template->created_by = 1;
$template->save();

# Check if saved
\App\Models\LayoutTemplate::count();
```

### 7. **Alternative: Fresh Migration**
**⚠️ WARNING: Ini akan menghapus semua data!**

```bash
# Backup database dulu!
php artisan db:backup  # jika ada

# Fresh migration
php artisan migrate:fresh

# Atau specific table
php artisan migrate:fresh --path=database/migrations/2025_11_09_141940_update_layout_templates_table_for_builder.php
```

## Quick Fix Commands:

```bash
# 1. Run migration
php artisan migrate

# 2. Clear cache
php artisan cache:clear && php artisan config:clear && php artisan route:clear

# 3. Restart server (jika menggunakan artisan serve)
# Ctrl+C lalu
php artisan serve
```

## Debugging Steps:

### Check Laravel Log:
```bash
# Windows
type storage\logs\laravel.log | findstr "ERROR"

# Linux/Mac
tail -f storage/logs/laravel.log
```

### Check Migration Files:
```bash
# List migrations
php artisan migrate:status

# Check specific migration
php artisan migrate:status | findstr "layout_templates"
```

### Manual Database Check:
```sql
-- Check table structure
DESCRIBE layout_templates;

-- Check if table exists
SHOW TABLES LIKE 'layout_templates';

-- Check data
SELECT * FROM layout_templates;
```

## Common Issues & Solutions:

### Issue 1: "Column 'grid_type' not found"
**Solution**: Migration belum dijalankan
```bash
php artisan migrate
```

### Issue 2: "Column 'background_media_id' not found"
**Solution**: Model masih reference kolom lama
- Pastikan `LayoutTemplate.php` sudah diupdate
- Clear cache: `php artisan cache:clear`

### Issue 3: "SQLSTATE[42S02]: Base table or view not found"
**Solution**: Table belum dibuat
```bash
php artisan migrate
```

### Issue 4: API returns empty array but shows error
**Solution**: JavaScript error, check browser console

### Issue 5: "Call to undefined relationship"
**Solution**: Controller masih load relationship lama
- Pastikan `LayoutController_clean.php` sudah diupdate
- Hapus `with(['backgroundMedia'])`

## After Fix:

1. ✅ Refresh halaman `/layout`
2. ✅ Seharusnya muncul card "+ Tambah Template"
3. ✅ Console tidak ada error
4. ✅ API `/api/layout/templates` return `{"success": true, "templates": []}`

## Need Help?

Jika masih error, kirim:
1. Screenshot error di browser console
2. Laravel log (`storage/logs/laravel.log`)
3. Output dari `php artisan migrate:status`
4. Response dari `/api/layout/templates`
