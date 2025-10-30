# Dashboard Features - Auto Play & Select All

## 📋 Overview

Penjelasan fungsi tombol "Auto Play" dan "Select All" di halaman Dashboard.

---

## 1. 🎵 Auto Play Toggle

### Lokasi:
Di bagian **Scheduled Audio** (Audio Terjadwal) di Dashboard

### Tampilan:
```
┌─────────────────────────────────┐
│ 🎵 Scheduled Audio             │
│                                 │
│ Audio Name                      │
│ Senin, 10:00                    │
│                                 │
│ [Auto Play ⚪] [▶ Play]        │
└─────────────────────────────────┘
```

### Fungsi:
**Auto Play** adalah toggle switch untuk mengaktifkan/menonaktifkan pemutaran audio otomatis berdasarkan jadwal.

#### Ketika AKTIF (ON):
- ✅ Audio akan **otomatis diputar** saat waktu jadwal tiba
- ✅ Sistem akan **memonitor jadwal** secara berkala
- ✅ Audio akan diputar **tanpa interaksi manual**
- ✅ Cocok untuk audio yang harus diputar tepat waktu (contoh: bell sekolah, pengumuman)

#### Ketika NONAKTIF (OFF):
- ❌ Audio **tidak akan diputar otomatis**
- ❌ Harus klik button **"Play"** manual untuk memutar
- ❌ Jadwal tetap ada tapi tidak aktif
- ✅ Cocok untuk audio yang hanya diputar saat dibutuhkan

### Cara Menggunakan:

1. **Aktifkan Auto Play:**
   - Klik toggle switch hingga berubah warna (biasanya hijau/biru)
   - Audio akan otomatis diputar saat jadwal aktif
   - Sistem akan menampilkan notifikasi saat audio diputar

2. **Nonaktifkan Auto Play:**
   - Klik toggle switch hingga mati (abu-abu)
   - Audio tidak akan diputar otomatis
   - Gunakan button "Play" untuk memutar manual

### Use Cases:

| Scenario | Auto Play | Alasan |
|----------|-----------|--------|
| **Bell Sekolah** | ✅ ON | Harus tepat waktu, otomatis |
| **Pengumuman Rutin** | ✅ ON | Terjadwal, tidak perlu manual |
| **Background Music** | ✅ ON | Continuous playback |
| **Audio Testing** | ❌ OFF | Hanya saat testing |
| **Audio Cadangan** | ❌ OFF | Hanya saat dibutuhkan |

### Technical Details:

```javascript
// Ketika toggle diaktifkan
isAutoPlayEnabled = true;
// Sistem mulai check jadwal setiap 5 detik
// Jika waktu sekarang = waktu jadwal → play audio

// Ketika toggle dinonaktifkan
isAutoPlayEnabled = false;
// Sistem stop monitoring
// Audio hanya bisa diputar manual dengan button Play
```

---

## 2. ☑️ Select All Checkbox

### Lokasi:
Di bagian **Media Library** (Daftar Media) di Dashboard

### Tampilan:
```
┌─────────────────────────────────┐
│ [☑ Select All]  0 selected     │
│ [👁 Show] [👁‍🗨 Hide]            │
├─────────────────────────────────┤
│ [☐] Media 1                     │
│ [☐] Media 2                     │
│ [☐] Media 3                     │
└─────────────────────────────────┘
```

### Fungsi:
**Select All** adalah checkbox untuk memilih semua media sekaligus agar bisa melakukan aksi bulk (massal).

#### Ketika DICENTANG:
- ✅ **Semua media** di halaman akan terpilih
- ✅ Counter menunjukkan jumlah media terpilih (contoh: "15 selected")
- ✅ Button **"Show"** dan **"Hide"** menjadi aktif
- ✅ Bisa melakukan aksi ke semua media sekaligus

#### Ketika TIDAK DICENTANG:
- ❌ Semua media **tidak terpilih**
- ❌ Counter menunjukkan "0 selected"
- ❌ Button "Show" dan "Hide" tidak aktif
- ✅ Bisa pilih media satu per satu secara manual

### Cara Menggunakan:

#### 1. Select All (Pilih Semua):
```
1. Klik checkbox "Select All"
2. Semua media terpilih (checkbox tercentang)
3. Counter update: "15 selected"
4. Button "Show" dan "Hide" aktif
```

#### 2. Bulk Show (Tampilkan Semua):
```
1. Select All → Pilih semua media
2. Klik button "👁 Show"
3. Semua media terpilih akan ditampilkan di landing page
4. Berguna untuk: Menampilkan banyak media sekaligus
```

#### 3. Bulk Hide (Sembunyikan Semua):
```
1. Select All → Pilih semua media
2. Klik button "👁‍🗨 Hide"
3. Semua media terpilih akan disembunyikan dari landing page
4. Berguna untuk: Membersihkan landing page dengan cepat
```

#### 4. Select Individual (Pilih Manual):
```
1. Jangan centang "Select All"
2. Klik checkbox pada media yang diinginkan saja
3. Counter update: "3 selected"
4. Klik "Show" atau "Hide" untuk media terpilih saja
```

### Use Cases:

| Scenario | Action | Steps |
|----------|--------|-------|
| **Tampilkan Semua Media** | Bulk Show | Select All → Show |
| **Sembunyikan Semua Media** | Bulk Hide | Select All → Hide |
| **Tampilkan Beberapa Media** | Individual Select | Pilih manual → Show |
| **Bersihkan Landing Page** | Bulk Hide | Select All → Hide |
| **Update Visibility Massal** | Bulk Action | Select All → Show/Hide |

### Benefits:

#### 1. Efisiensi Waktu
- ✅ Tidak perlu klik satu per satu
- ✅ Aksi massal dalam sekali klik
- ✅ Hemat waktu untuk banyak media

#### 2. Bulk Operations
- ✅ Show multiple media sekaligus
- ✅ Hide multiple media sekaligus
- ✅ Manage visibility dengan mudah

#### 3. Flexibility
- ✅ Bisa pilih semua atau sebagian
- ✅ Bisa deselect individual items
- ✅ Counter menunjukkan jumlah terpilih

### Technical Details:

```javascript
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
  const checkboxes = document.querySelectorAll('.media-checkbox');
  checkboxes.forEach(cb => {
    cb.checked = this.checked;
  });
  updateSelectedCount();
});

// Bulk Show
document.getElementById('btnBulkShow').addEventListener('click', function() {
  const selected = getSelectedMedia();
  // Show all selected media on landing page
  bulkUpdateVisibility(selected, true);
});

// Bulk Hide
document.getElementById('btnBulkHide').addEventListener('click', function() {
  const selected = getSelectedMedia();
  // Hide all selected media from landing page
  bulkUpdateVisibility(selected, false);
});
```

---

## 📊 Comparison

| Feature | Auto Play | Select All |
|---------|-----------|------------|
| **Lokasi** | Scheduled Audio | Media Library |
| **Fungsi** | Auto play audio by schedule | Bulk select media |
| **Target** | Audio terjadwal | Semua media |
| **Action** | Play/Stop automatic | Show/Hide visibility |
| **Use Case** | Scheduled playback | Bulk operations |

---

## 💡 Tips & Best Practices

### Auto Play:
1. ✅ **Aktifkan** untuk audio yang harus tepat waktu
2. ✅ **Nonaktifkan** untuk audio testing atau cadangan
3. ✅ **Monitor** notifikasi untuk memastikan audio diputar
4. ✅ **Test** dengan button "Play" sebelum mengaktifkan auto play

### Select All:
1. ✅ **Gunakan** untuk bulk operations (show/hide banyak media)
2. ✅ **Deselect** individual items jika tidak ingin semua terpilih
3. ✅ **Check counter** untuk memastikan jumlah media terpilih
4. ✅ **Preview** sebelum bulk hide untuk menghindari kesalahan

---

## 🎯 Quick Reference

### Auto Play:
- **ON** = Audio play otomatis saat jadwal aktif
- **OFF** = Audio harus diputar manual dengan button Play

### Select All:
- **Checked** = Semua media terpilih → Bisa bulk show/hide
- **Unchecked** = Tidak ada yang terpilih → Pilih manual

---

**Documentation Date:** 30 Oktober 2025  
**Status:** ✅ Complete
