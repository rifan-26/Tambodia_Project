# 🔧 FIX UPLOAD ERROR - Step by Step Guide

## ❌ ERROR: "The file failed to upload"

Error ini terjadi karena masalah konfigurasi PHP atau permissions. Mari kita fix step by step.

---

## 🎯 STEP 1: TEST PHP CONFIGURATION

### **A. Test Upload Config:**
```
Buka di browser: http://127.0.0.1:8000/test_upload.php
```

**Check:**
- ✅ upload_max_filesize: Harus >= 256M
- ✅ post_max_size: Harus >= 256M
- ✅ Temp dir exists: Harus YES
- ✅ Temp dir writable: Harus YES
- ✅ Storage exists: Harus YES
- ✅ Storage writable: Harus YES

### **B. Jika ADA yang NO/Merah:**

#### **FIX 1: Edit php.ini**
```
1. Buka: C:\laragon\bin\php\php8.x.x\php.ini
   (x.x = versi PHP Anda, misal: php8.1.10)

2. Cari dan edit:
   upload_max_filesize = 256M
   post_max_size = 256M
   max_execution_time = 300
   memory_limit = 512M

3. Save file

4. Restart Apache di Laragon
```

#### **FIX 2: Fix Temp Directory**
```bash
# Buka Command Prompt sebagai Administrator
cd C:\laragon\tmp
mkdir uploads
icacls uploads /grant Everyone:(OI)(CI)F
```

#### **FIX 3: Fix Storage Permissions**
```bash
# Buka Command Prompt sebagai Administrator
cd C:\laragon\www\laraveladmin
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T
```

---

## 🎯 STEP 2: TEST FILE UPLOAD

### **A. Test dengan Form Sederhana:**
```
1. Buka: http://127.0.0.1:8000/test_upload.php
2. Pilih file audio kecil (< 5MB)
3. Klik "Test Upload"
4. Lihat hasilnya
```

### **B. Expected Result:**
```
✅ Upload Successful!
✅ File Moved Successfully to: ...
```

### **C. Jika Masih Error:**
**Lihat Error Code:**
- **Error 1 (UPLOAD_ERR_INI_SIZE)** → php.ini upload_max_filesize terlalu kecil
- **Error 4 (UPLOAD_ERR_NO_FILE)** → File tidak ter-submit
- **Error 6 (UPLOAD_ERR_NO_TMP_DIR)** → Temp directory tidak ada
- **Error 7 (UPLOAD_ERR_CANT_WRITE)** → Permission error

---

## 🎯 STEP 3: CHECK LARAVEL LOGS

### **A. Buka Laravel Log:**
```
File: C:\laragon\www\laraveladmin\storage\logs\laravel.log
```

### **B. Cari Log Terbaru:**
```
📁 Upload attempt
❌ Upload failed

Lihat detail:
- error_code: Kode error PHP
- error_message: Pesan error
- upload_max_filesize: Nilai di php.ini
- post_max_size: Nilai di php.ini
- tmp_dir: Lokasi temp directory
```

### **C. Fix Berdasarkan Log:**

#### **Jika error_code = 1:**
```
File melebihi upload_max_filesize
FIX: Naikkan upload_max_filesize di php.ini
```

#### **Jika error_code = 4:**
```
No file uploaded
FIX: 
1. Clear browser cache (Ctrl+Shift+R)
2. Check form HTML: <input type="file" name="file">
3. Check JavaScript FormData
```

#### **Jika error_code = 6:**
```
Missing temporary folder
FIX:
1. Buat folder: C:\laragon\tmp\uploads
2. Set permissions full control
```

#### **Jika error_code = 7:**
```
Failed to write to disk
FIX:
1. Check disk space
2. Fix storage permissions (lihat STEP 1, FIX 3)
```

---

## 🎯 STEP 4: TEST LARAVEL UPLOAD

### **A. Clear All Cache:**
```bash
cd C:\laragon\www\laraveladmin
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload
```

### **B. Test Upload via Laravel:**
```
1. Buka: http://127.0.0.1:8000/input
2. Klik "+ Tambah Media Baru"
3. Pilih "Audio"
4. Buka Console (F12)
5. Pilih file audio
6. Klik "Next" → "Upload"
7. Watch Console & Network Tab
```

### **C. Check Console Logs:**
```javascript
Expected:
🎵 Setting file accept: audio/*,.mp3,...
📁 File input changed: 1 files
📄 File selected: {name, type, size, jenisMedia}
```

### **D. Check Network Tab:**
```
F12 → Network → Filter: XHR
Look for: POST /media

Response:
{
  "success": false,
  "message": "...", // Error message
  "php_upload_error_code": X,
  "debug": {...}
}
```

---

## 🎯 STEP 5: ALTERNATIVE SOLUTIONS

### **Option 1: Use .htaccess**
Buat file `.htaccess` di `public/`:
```apache
php_value upload_max_filesize 256M
php_value post_max_size 256M
php_value max_execution_time 300
php_value max_input_time 300
```

### **Option 2: Edit Laravel Config**
File: `config/app.php`
```php
// Add to boot method
ini_set('upload_max_filesize', '256M');
ini_set('post_max_size', '256M');
ini_set('max_execution_time', '300');
```

### **Option 3: Test dengan Postman**
```
POST http://127.0.0.1:8000/media

Headers:
X-CSRF-TOKEN: [token dari meta tag]
Accept: application/json

Body (form-data):
jenisMedia: audio
namaFile: Test Audio
file: [pilih file audio]
```

---

## 🎯 STEP 6: FINAL CHECKLIST

### **✅ Before Upload:**
- [ ] php.ini upload_max_filesize >= 256M
- [ ] php.ini post_max_size >= 256M
- [ ] Temp directory exists & writable
- [ ] Storage directory exists & writable
- [ ] Apache restarted after php.ini changes
- [ ] All Laravel caches cleared
- [ ] Browser cache cleared (Ctrl+Shift+R)

### **✅ During Upload:**
- [ ] Console shows file selected logs
- [ ] Network tab shows POST request
- [ ] No JavaScript errors in console
- [ ] Progress bar appears

### **✅ After Upload:**
- [ ] Check laravel.log for detailed errors
- [ ] Check response in Network tab
- [ ] Test with different file (smaller size)
- [ ] Test with different format (MP3 vs WAV)

---

## 📊 DIAGNOSTIC TABLE

| Symptom | Cause | Solution |
|---------|-------|----------|
| **"File melebihi upload_max_filesize"** | PHP limit | Edit php.ini → Restart Apache |
| **"No file uploaded"** | JavaScript/Form issue | Check console logs + FormData |
| **"Missing temporary folder"** | Temp dir error | Create C:\laragon\tmp\uploads |
| **"Failed to write to disk"** | Permission error | Fix storage permissions |
| **File dialog tidak muncul** | JavaScript error | Clear browser cache |
| **Upload stuck at 0%** | Network/Server issue | Check Apache error log |

---

## 🆘 EMERGENCY FIXES

### **Quick Fix 1: Reset Everything**
```bash
# Stop Apache
# Edit php.ini (set all limits to 256M+)
# Restart Apache
cd C:\laragon\www\laraveladmin
php artisan config:clear
php artisan cache:clear
php artisan view:clear
composer dump-autoload
# Clear browser cache (Ctrl+Shift+R)
# Try upload again
```

### **Quick Fix 2: Use Smaller File**
```
Test dengan file MP3 < 1MB
Jika berhasil → Problem: File size limit
Jika gagal → Problem: Configuration or Permissions
```

### **Quick Fix 3: Check Apache Error Log**
```
Location: C:\laragon\bin\apache\apache2.4.x\logs\error.log
Look for: PHP Fatal error, upload errors
```

---

## 📞 WHAT TO SHARE IF STILL ERROR:

1. **Screenshot dari:**
   - http://127.0.0.1:8000/test_upload.php (test results)
   - Console logs (F12 → Console)
   - Network tab (F12 → Network → POST /media)

2. **Laravel log excerpt:**
   ```bash
   tail -n 50 storage/logs/laravel.log
   ```

3. **PHP Info:**
   - upload_max_filesize value
   - post_max_size value
   - upload_tmp_dir value

4. **Test results:**
   - Does test_upload.php work?
   - What error code appears?
   - File size being uploaded?

---

**Created:** 13 Oktober 2025
**Purpose:** Complete guide to fix "The file failed to upload" error
**Status:** Ready for debugging
