# ✅ Fix: Gagal Memuat Template

## Problem:
Error "Gagal memuat template" di halaman Master Layout karena:
1. Model `LayoutTemplate` menggunakan field lama (grid_positions, background_media_id)
2. API `/api/layout/templates` mencoba load relationship yang tidak ada
3. Database belum di-migrate ke struktur baru

## Solution:

### 1. **Update Model LayoutTemplate**
File: `app/Models/LayoutTemplate.php`

**Perubahan:**
- ✅ Update `$fillable` untuk field baru (grid_type, grid_config, elements, thumbnail_path)
- ✅ Update `$casts` untuk JSON fields
- ✅ Hapus relationship `backgroundMedia()` (tidak digunakan lagi)
- ✅ Tambah method `activate()`, `deactivate()`, `getUsedMediaIds()`
- ✅ Hapus method `gridMedia()` (tidak digunakan lagi)
- ✅ Fix duplicate methods

**Field Baru:**
```php
protected $fillable = [
    'name',
    'description',
    'thumbnail_path',    // NEW
    'grid_type',         // NEW
    'grid_config',       // NEW
    'elements',          // NEW
    'is_active',
    'created_by'
];

protected $casts = [
    'grid_config' => 'array',  // NEW
    'elements' => 'array',     // NEW
    'is_active' => 'boolean'
];
```

### 2. **Update LayoutController_clean**
File: `app/Http/Controllers/LayoutController_clean.php`

**Perubahan:**
```php
// BEFORE
$templates = \App\Models\LayoutTemplate::with(['backgroundMedia', 'creator'])
    ->orderBy('created_at', 'desc')
    ->get();

// AFTER
$templates = \App\Models\LayoutTemplate::with('creator')
    ->orderBy('updated_at', 'desc')
    ->get();
```

### 3. **Run Migration**
**PENTING**: Jalankan migration untuk update struktur database!

```bash
php artisan migrate
```

Migration file: `2025_11_09_141940_update_layout_templates_table_for_builder.php`

**Perubahan Database:**
- ❌ Drop: `template_data`, `background_image_id`, `is_public`, `user_id`
- ✅ Add: `thumbnail_path`, `grid_type`, `grid_config`, `elements`, `is_active`, `created_by`
- ✅ Add: `soft_deletes`, indexes, foreign keys

### 4. **Struktur Data Template Baru**

```json
{
  "id": 1,
  "name": "Template 1",
  "description": "Deskripsi template",
  "thumbnail_path": "templates/thumbnails/xxx.jpg",
  "grid_type": "2x2",
  "grid_config": {
    "columns": 2,
    "rows": 2,
    "areas": ["A1", "A2", "A3", "A4"]
  },
  "elements": [
    {
      "area": "A1",
      "type": "image",
      "mediaId": 123,
      "styles": {...}
    },
    {
      "area": "A2",
      "type": "text",
      "content": "Hello",
      "styles": {...}
    }
  ],
  "is_active": true,
  "created_by": 1,
  "created_at": "2025-01-01",
  "updated_at": "2025-01-01"
}
```

## Testing Steps:

### 1. **Run Migration**
```bash
php artisan migrate
```

### 2. **Clear Cache**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### 3. **Test API**
```bash
# Test API endpoint
curl http://127.0.0.1:8000/api/layout/templates
```

Expected response:
```json
{
  "success": true,
  "templates": []
}
```

### 4. **Access Page**
- Akses `/layout`
- Seharusnya muncul card "+ Tambah Template"
- Tidak ada error "Gagal memuat template"

## Troubleshooting:

### Error: "Column not found: grid_type"
**Solution**: Run migration
```bash
php artisan migrate
```

### Error: "SQLSTATE[42S22]: Column not found: 'background_media_id'"
**Solution**: Model masih menggunakan field lama, pastikan sudah update model

### Error: "Call to undefined relationship backgroundMedia"
**Solution**: Update LayoutController_clean, hapus `with(['backgroundMedia'])`

### Templates tidak muncul
**Cause**: Database kosong (belum ada template)
**Expected**: Card "+ Tambah Template" muncul

## Files Updated:

1. ✅ `app/Models/LayoutTemplate.php` - Model dengan field baru
2. ✅ `app/Http/Controllers/LayoutController_clean.php` - API getTemplates
3. ⚠️ `database/migrations/2025_11_09_141940_update_layout_templates_table_for_builder.php` - Migration (perlu dijalankan)

## Next Steps:

1. **Run Migration**: `php artisan migrate`
2. **Test API**: Akses `/api/layout/templates`
3. **Test Page**: Akses `/layout`
4. **Create Template**: Klik "+ Tambah Template"

Setelah migration dijalankan, halaman Master Layout akan berfungsi normal! ✅
