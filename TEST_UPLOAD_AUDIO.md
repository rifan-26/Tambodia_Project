# 🎵 TEST UPLOAD AUDIO - Debugging Guide

## 🔧 PERBAIKAN YANG SUDAH DILAKUKAN:

### 1. **File Accept Attribute**
```javascript
// SEBELUM: accept = 'audio/*'
// SEKARANG: accept = 'audio/*,.mp3,.wav,.ogg,.aac,.flac,.m4a'
```

### 2. **Console Logging**
Ditambahkan log untuk tracking:
- File input change detection
- File details (name, type, size)
- Media type selection

### 3. **MIME Type Validation**
Controller sudah support audio dengan lengkap:
```php
'audio' => [
    'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg',
    'audio/x-wav', 'audio/wave', 'audio/aac', 'audio/x-aac',
    'audio/flac', 'audio/x-flac', 'audio/mp4', 'audio/3gpp', 'audio/3gpp2'
]
```

---

## 🧪 CARA TEST UPLOAD AUDIO:

### **STEP 1: Buka Input Media**
```
1. Login: http://127.0.0.1:8000/login
2. Buka: http://127.0.0.1:8000/input
3. Klik tombol "+ Tambah Media Baru"
```

### **STEP 2: Pilih Tipe Audio**
```
1. Klik card "Audio"
2. Cek console (F12 → Console):
   ✅ Harus muncul: "🎵 Setting file accept: audio/*,.mp3,... for type: audio"
```

### **STEP 3: Upload File**
```
1. Klik "Pilih File"
2. Pilih file audio (.mp3, .wav, .ogg)
3. Cek console:
   ✅ Harus muncul: "📁 File input changed: 1 files"
   ✅ Harus muncul: "📄 File selected: {name, type, size, jenisMedia}"
4. Preview audio player harus muncul
```

### **STEP 4: Isi Nama & Submit**
```
1. Isi nama file (atau biarkan auto-fill)
2. Klik "Next" sampai step 3
3. Klik "Upload"
4. ✅ Progress bar harus muncul
5. ✅ Toast "Media berhasil diunggah" harus muncul
```

---

## 🔍 TROUBLESHOOTING:

### **Problem 1: File dialog tidak muncul**
**Check:**
```
1. Buka Console (F12)
2. Cek error merah
3. Pastikan card "Audio" sudah selected (ada border)
```

**Fix:**
```bash
# Clear cache
php artisan view:clear
php artisan cache:clear

# Hard refresh browser
Ctrl + Shift + R
```

---

### **Problem 2: File terpilih tapi tidak ada preview**
**Check Console:**
```javascript
// Harus muncul log ini:
📁 File input changed: 1 files
📄 File selected: {
  name: "song.mp3",
  type: "audio/mpeg",
  size: 5242880,
  jenisMedia: "audio"
}
```

**Jika tidak muncul:**
```
1. Cek apakah file input ter-trigger
2. Cek apakah jenisMedia sudah di-set ke "audio"
3. Reload page dan coba lagi
```

---

### **Problem 3: Upload gagal dengan error 422**
**Check Console Log:**
```
Upload 422 details: {
  message: "...",
  detected_mime: "...",
  allowed: [...]
}
```

**Solusi:**
```
1. Cek MIME type file Anda
2. Pastikan file benar-benar audio
3. Jika MIME type tidak recognized:
   - Gunakan file .mp3 standar
   - Atau convert file ke format yang supported
```

---

### **Problem 4: Upload gagal dengan error 413**
**Meaning:** File terlalu besar

**Check:**
```
1. Ukuran file max: 250MB
2. Cek php.ini settings:
   - upload_max_filesize = 256M
   - post_max_size = 256M
```

**Fix:**
```
1. Buka: c:\laragon\bin\php\php8.x.x\php.ini
2. Edit:
   upload_max_filesize = 256M
   post_max_size = 256M
3. Restart Apache
4. Coba upload lagi
```

---

## 🎯 EXPECTED BEHAVIOR:

### **✅ SUCCESS FLOW:**

```
1. Klik card "Audio"
   → Console: "🎵 Setting file accept..."
   → Card border jadi warna primary

2. Klik "Pilih File"
   → File dialog terbuka
   → Filter: Audio files (*.mp3, *.wav, *.ogg, *.aac, *.flac, *.m4a)

3. Pilih file audio
   → Console: "📁 File input changed: 1 files"
   → Console: "📄 File selected: {...}"
   → Preview area muncul
   → Audio player dengan controls muncul
   → Nama auto-fill dari nama file
   → Button "Next" active

4. Klik "Next" → Step 3
   → Form nama file terlihat
   → Button "Upload" active

5. Klik "Upload"
   → Progress bar: 0% → 100%
   → Toast: "Media berhasil diunggah" (hijau)
   → Kembali ke Step 4 (success)
   → Media grid refresh
   → Audio baru muncul di grid dengan icon 🎵

6. Tutup modal
   → Audio terlihat di daftar media
   → Badge "Audio" warna biru
   → Bisa di-preview, edit, delete
```

---

## 📝 TEST CHECKLIST:

### **Audio Format Support:**
- [ ] MP3 (.mp3) - MPEG Audio
- [ ] WAV (.wav) - Waveform Audio
- [ ] OGG (.ogg) - Ogg Vorbis
- [ ] AAC (.aac) - Advanced Audio Coding
- [ ] FLAC (.flac) - Free Lossless Audio Codec
- [ ] M4A (.m4a) - MPEG-4 Audio

### **File Size:**
- [ ] Small file (<1MB)
- [ ] Medium file (1-10MB)
- [ ] Large file (10-50MB)
- [ ] Very large file (50-250MB)

### **Edge Cases:**
- [ ] File dengan nama spesial (spasi, unicode)
- [ ] File dengan extension uppercase (.MP3)
- [ ] Drag & drop file
- [ ] Cancel dan pilih file lain
- [ ] Upload multiple files sequentially

---

## 🎬 DEMO TEST:

### **Test Case: Upload MP3 File**

```
Given:
  - User sudah login
  - Halaman input media terbuka
  - File test: "test-audio.mp3" (5MB)

When:
  1. User klik "+ Tambah Media Baru"
  2. User klik card "Audio"
  3. User klik "Pilih File"
  4. User pilih "test-audio.mp3"
  5. User klik "Next" (step 2 → 3)
  6. User klik "Upload"

Then:
  ✅ Console log: "📁 File input changed: 1 files"
  ✅ Console log: "📄 File selected: {name: 'test-audio.mp3', type: 'audio/mpeg', ...}"
  ✅ Audio player preview muncul
  ✅ Progress bar: 0% → 100%
  ✅ Toast hijau: "Media berhasil diunggah"
  ✅ File tersimpan di: storage/app/public/media/
  ✅ Database: Record baru di tabel `media` type='Audio'
  ✅ Grid refresh: Audio baru muncul dengan icon 🎵
```

---

## 🔧 MANUAL DEBUGGING:

### **1. Check File Input Element:**
```javascript
// Buka Console, paste ini:
const fileInput = document.querySelector('#fileUpload');
console.log('File Input:', fileInput);
console.log('Accept:', fileInput.getAttribute('accept'));
console.log('Files:', fileInput.files);
```

### **2. Check Form Data:**
```javascript
// Setelah pilih file, paste ini:
const form = document.querySelector('#mediaForm');
const fd = new FormData(form);
for (let [key, value] of fd.entries()) {
    console.log(key, ':', value);
}
```

### **3. Check Media Type:**
```javascript
// Paste ini:
const jenisMedia = document.querySelector('#jenisMedia');
console.log('Jenis Media:', jenisMedia.value);
```

---

## 📊 DATABASE CHECK:

### **Setelah upload berhasil, cek database:**

```sql
-- Check media record
SELECT * FROM media 
WHERE type = 'Audio' 
ORDER BY created_at DESC 
LIMIT 1;

-- Expected result:
-- id: auto
-- user_id: [your_user_id]
-- name: "test-audio"
-- type: "Audio"
-- file_path: "media/[timestamp]_test-audio.mp3"
-- created_at: [now]
```

### **Check file exists:**
```bash
# Windows
dir c:\laragon\www\laraveladmin\storage\app\public\media\*.mp3

# Should show: [timestamp]_test-audio.mp3
```

---

## ✅ SUCCESS INDICATORS:

| Step | Indicator | Status |
|------|-----------|--------|
| 1. Select Audio | Console log "🎵 Setting file accept" | ✅ |
| 2. Choose File | Console log "📁 File input changed" | ✅ |
| 3. File Selected | Console log "📄 File selected" | ✅ |
| 4. Preview | Audio player visible | ✅ |
| 5. Upload | Progress bar 0-100% | ✅ |
| 6. Success | Toast message green | ✅ |
| 7. Database | Record in `media` table | ✅ |
| 8. File | File in `storage/app/public/media/` | ✅ |
| 9. Grid | Audio visible in media grid | ✅ |

---

## 🚨 COMMON ERRORS & FIXES:

### **Error 1: "File harus diunggah"**
**Cause:** File input kosong
**Fix:** Pastikan file benar-benar terpilih, cek console log

### **Error 2: "Tipe file tidak sesuai"**
**Cause:** MIME type tidak match
**Fix:** 
- Gunakan file MP3 standar
- Check dengan MediaInfo tool
- Atau convert file ke format yang supported

### **Error 3: "Ukuran file melebihi 250MB"**
**Cause:** File terlalu besar
**Fix:**
- Compress audio file
- Atau naikkan limit di php.ini

### **Error 4: No console logs appear**
**Cause:** JavaScript error atau cache
**Fix:**
```bash
php artisan view:clear
# Hard refresh: Ctrl + Shift + R
```

---

## 📞 NEXT STEPS IF STILL FAILING:

1. **Screenshot error message** (jika ada)
2. **Copy console logs** (full output)
3. **Test dengan file MP3 sederhana** (< 5MB)
4. **Check Network tab** (F12 → Network) saat upload
5. **Share hasil test** untuk debugging lanjut

---

**Updated:** 13 Oktober 2025
**Status:** Debugging Ready - Please Test Now!
