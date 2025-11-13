# 📦 Instruksi Import Database

## Untuk Teman yang Menerima File

### 1️⃣ Pastikan MySQL Sudah Running

Cek MySQL service sudah jalan:
```powershell
# Cek status MySQL
Get-Service | Where-Object {$_.Name -like "*mysql*"}

# Atau cek process
Get-Process | Where-Object {$_.ProcessName -like "*mysql*"}
```

### 2️⃣ Create Database Baru

Buka MySQL command line atau HeidiSQL/phpMyAdmin:

```sql
CREATE DATABASE tambodia_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3️⃣ Import Database

**Opsi A: Via Command Line (Recommended)**

```powershell
# Ganti path sesuai lokasi file SQL
mysql -u root -p tambodia_project < tambodia_project_backup_2025-11-13_124117.sql
```

Masukkan password MySQL Anda saat diminta.

**Opsi B: Via HeidiSQL**

1. Buka HeidiSQL
2. Connect ke MySQL
3. Pilih database `tambodia_project`
4. File → Load SQL file
5. Pilih file `tambodia_project_backup_2025-11-13_124117.sql`
6. Klik Execute (F9)

**Opsi C: Via phpMyAdmin**

1. Buka phpMyAdmin
2. Pilih database `tambodia_project`
3. Tab "Import"
4. Choose file → pilih file SQL
5. Klik "Go"

### 4️⃣ Update File .env

Edit file `.env` di project Laravel:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1          # Pakai localhost
DB_PORT=3306
DB_DATABASE=tambodia_project
DB_USERNAME=root            # Username MySQL Anda
DB_PASSWORD=                # Password MySQL Anda
```

### 5️⃣ Clear Cache Laravel

```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 6️⃣ Test Akses Website

```powershell
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

### 7️⃣ Login ke Dashboard

- URL: `http://127.0.0.1:8000/login`
- Email: (tanya ke yang kirim database)
- Password: (tanya ke yang kirim database)

---

## ⚠️ Troubleshooting

### Error: "Access denied for user"
- Pastikan username dan password di `.env` benar
- Coba user `root` dengan password MySQL Anda

### Error: "Database does not exist"
- Pastikan sudah create database: `CREATE DATABASE tambodia_project;`

### Error: "Table already exists"
- Drop database dulu: `DROP DATABASE tambodia_project;`
- Lalu create lagi dan import ulang

### Website masih error
- Jalankan: `php artisan migrate:fresh` (HATI-HATI: ini akan hapus semua data!)
- Atau import ulang database

---

## 📝 Catatan Penting

1. **File SQL sudah include semua data:**
   - Users
   - Media
   - Schedules
   - Staff
   - Layout templates
   - Dll.

2. **Folder yang perlu di-copy juga:**
   - `storage/app/public/` (berisi uploaded files)
   - Pastikan folder ini juga di-copy dari komputer pengirim

3. **Setelah copy folder storage:**
   ```powershell
   php artisan storage:link
   ```

4. **Jika ada error permission:**
   ```powershell
   # Windows
   icacls storage /grant Users:F /T
   icacls bootstrap/cache /grant Users:F /T
   ```

---

## ✅ Checklist

- [ ] MySQL sudah running
- [ ] Database `tambodia_project` sudah dibuat
- [ ] File SQL sudah di-import
- [ ] File `.env` sudah diupdate
- [ ] Cache sudah di-clear
- [ ] Folder `storage/app/public` sudah di-copy
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] Website bisa diakses

---

**Jika masih ada masalah, hubungi yang kirim database!** 📞
