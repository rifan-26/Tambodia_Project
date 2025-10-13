# INSTRUKSI MIGRATION UNTUK SISTEM PENJADWALAN

## ⚠️ PENTING: Jalankan Migration Ini Untuk Mengaktifkan Fitur Penjadwalan

### Cara 1: Via Laravel Artisan (Recommended)
```bash
php artisan migrate
```

### Cara 2: Via SQL Manual (Jika Artisan Tidak Bisa)

Jalankan SQL berikut di database MySQL Anda:

```sql
ALTER TABLE `schedules` 
ADD COLUMN `layout_type` VARCHAR(255) DEFAULT 'grid' AFTER `time`,
ADD COLUMN `layout_positions` JSON NULL AFTER `layout_type`,
ADD COLUMN `display_duration` INT DEFAULT 10 AFTER `layout_positions`,
ADD COLUMN `auto_rotate` BOOLEAN DEFAULT TRUE AFTER `display_duration`,
ADD COLUMN `layout_settings` JSON NULL AFTER `auto_rotate`,
ADD COLUMN `is_active` BOOLEAN DEFAULT TRUE AFTER `layout_settings`;
```

### Cara 3: Via phpMyAdmin
1. Buka phpMyAdmin
2. Pilih database Laravel Anda
3. Pilih tabel `schedules`
4. Klik tab "Structure"
5. Tambahkan kolom-kolom berikut:

| Column Name | Type | Length | Default | After |
|-------------|------|--------|---------|-------|
| layout_type | VARCHAR | 255 | 'grid' | time |
| layout_positions | JSON | - | NULL | layout_type |
| display_duration | INT | - | 10 | layout_positions |
| auto_rotate | BOOLEAN | - | TRUE | display_duration |
| layout_settings | JSON | - | NULL | auto_rotate |
| is_active | BOOLEAN | - | TRUE | layout_settings |

## ✅ Setelah Migration Berhasil:

1. **Landing Page** akan berfungsi normal tanpa error
2. **Sistem Penjadwalan** akan aktif dengan fitur:
   - Pilih posisi layout (1-6)
   - Preview posisi visual
   - Validasi konflik jadwal
   - Auto rotate dan durasi tampil

3. **File yang Perlu Diupdate** (setelah migration):
   - Ganti `LandingController.php` dengan versi lengkap
   - Ganti `ScheduleController.php` dengan versi lengkap

## 🔄 File Backup:
- `LandingController-full.php` (versi lengkap)
- `ScheduleController-full.php` (versi lengkap)

## 📞 Jika Ada Masalah:
1. Cek apakah semua kolom sudah ditambahkan
2. Restart web server
3. Clear cache Laravel: `php artisan cache:clear`