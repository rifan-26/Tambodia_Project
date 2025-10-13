# 🔄 SISTEM MERGE LAYOUT - Jadwal + Default

## 🎯 CARA KERJA BARU

### **❌ SEBELUMNYA (Salah):**
```
Jika ada jadwal aktif:
→ SEMUA gambar layout default HILANG
→ Hanya tampil media terjadwal
→ Posisi lain jadi kosong
```

**Contoh:**
- Layout default: Gambar A (pos 1), B (pos 2), C (pos 3), D (pos 4), E (pos 5), F (pos 6)
- Jadwal: Gambar X di posisi 3
- **Hasil:** Hanya Gambar X yang tampil, A,B,D,E,F HILANG ❌

---

### **✅ SEKARANG (Benar):**
```
Jika ada jadwal aktif:
→ Hanya posisi terjadwal yang DIGANTI
→ Posisi lain TETAP tampil dari layout default
→ Merge antara jadwal dan default
```

**Contoh:**
- Layout default: Gambar A (pos 1), B (pos 2), C (pos 3), D (pos 4), E (pos 5), F (pos 6)
- Jadwal: Gambar X di posisi 3
- **Hasil:** A, B, **X**, D, E, F (hanya posisi 3 yang diganti) ✅

---

## 🔧 TECHNICAL IMPLEMENTATION

### **Method: `mergeLayoutWithSchedule()`**

```php
private function mergeLayoutWithSchedule($defaultMedia, $scheduledMedia)
{
    // 1. Buat position map dari layout default
    $positionMap = [];
    foreach ($defaultMedia as $media) {
        if ($media->layout_order) {
            $positionMap[$media->layout_order] = $media;
        }
    }
    
    // 2. Override dengan scheduled media (hanya posisi yang dijadwalkan)
    foreach ($scheduledMedia as $media) {
        if ($media->layout_order) {
            $positionMap[$media->layout_order] = $media;
            \Log::info("🔄 Position {$media->layout_order} replaced with scheduled: {$media->name}");
        }
    }
    
    // 3. Convert back to collection, sorted by position
    ksort($positionMap);
    return collect(array_values($positionMap));
}
```

---

## 📋 CONTOH USE CASE

### **Use Case 1: Promo di Posisi Tengah**

**Setup:**
```
Layout Default:
- Posisi 1: Gambar Default A
- Posisi 2: Gambar Default B
- Posisi 3: Gambar Default C
- Posisi 4: Gambar Default D
- Posisi 5: Gambar Default E
- Posisi 6: Gambar Default F

Jadwal Baru:
- Media: banner-promo.jpg
- Posisi: 3
- Tanggal: 2025-10-13 - 2025-10-20
```

**Hasil di Landing Page:**
```
┌─────────┬─────────┬─────────┐
│ Pos 1   │ Pos 2   │ Pos 3   │
│ Def A   │ Def B   │ PROMO   │ ← Hanya pos 3 diganti
├─────────┼─────────┼─────────┤
│ Pos 4   │ Pos 5   │ Pos 6   │
│ Def D   │ Def E   │ Def F   │ ← Tetap default
└─────────┴─────────┴─────────┘
```

---

### **Use Case 2: Multiple Schedules**

**Setup:**
```
Layout Default:
- Posisi 1-6: Gambar Default A, B, C, D, E, F

Jadwal:
1. Video X di posisi 2 (tanggal 1-10 Nov)
2. Gambar Y di posisi 5 (tanggal 1-10 Nov)
```

**Hasil di Landing Page:**
```
┌─────────┬─────────┬─────────┐
│ Pos 1   │ Pos 2   │ Pos 3   │
│ Def A   │ VIDEO X │ Def C   │ ← Pos 2 diganti
├─────────┼─────────┼─────────┤
│ Pos 4   │ Pos 5   │ Pos 6   │
│ Def D   │ IMG Y   │ Def F   │ ← Pos 5 diganti
└─────────┴─────────┴─────────┘
```

---

### **Use Case 3: Conflict Resolution**

**Setup:**
```
Layout Default:
- Posisi 3: Gambar Default C

Jadwal:
1. Gambar X di posisi 3 (tanggal 1-5 Okt, waktu 08:00)
2. Gambar Y di posisi 3 (tanggal 10-15 Okt, waktu 08:00)
```

**Hasil:**
- Tanggal 1-5 Okt: Tampil Gambar X di posisi 3
- Tanggal 6-9 Okt: Tampil Gambar Default C di posisi 3 (tidak ada jadwal)
- Tanggal 10-15 Okt: Tampil Gambar Y di posisi 3 (jadwal terbaru)
- Tanggal 16+: Tampil Gambar Default C di posisi 3

---

## 🧪 TESTING GUIDE

### **Test 1: Single Schedule**

**Step 1 - Setup Layout Default:**
```
1. Login → Layout Manager
2. Isi semua posisi 1-6 dengan gambar
3. Simpan layout
4. Buka landing page → cek semua posisi terisi
```

**Step 2 - Buat Jadwal:**
```
1. Login → Jadwal
2. Pilih gambar BARU (bukan yang di layout)
3. Set tanggal: hari ini
4. Set posisi: 3
5. Simpan
```

**Step 3 - Verify:**
```
1. Buka landing page (/)
2. ✅ Posisi 1,2: Tetap gambar default
3. ✅ Posisi 3: Gambar terjadwal (BARU)
4. ✅ Posisi 4,5,6: Tetap gambar default
```

**Step 4 - Check Logs:**
```bash
tail -f storage/logs/laravel.log | grep Merged
```

Expected:
```
🔄 Merged: Position 3 replaced with scheduled media: [nama_gambar]
📋 Final merged layout: 6 positions
```

---

### **Test 2: Multiple Schedules**

**Setup:**
```
1. Buat jadwal A: Gambar X → Posisi 2
2. Buat jadwal B: Gambar Y → Posisi 5
```

**Verify:**
```
Landing page harus tampil:
- Pos 1: Default
- Pos 2: Gambar X (jadwal)
- Pos 3: Default
- Pos 4: Default
- Pos 5: Gambar Y (jadwal)
- Pos 6: Default
```

---

### **Test 3: Jadwal Expired**

**Setup:**
```
1. Buat jadwal dengan end_date = kemarin
2. Refresh landing page
```

**Expected:**
```
✅ Posisi terjadwal kembali ke default
✅ Semua posisi tampil dari layout manager
```

---

## 🔍 TROUBLESHOOTING

### **Problem: Semua gambar masih hilang saat ada jadwal**

**Solution:**
1. Clear cache:
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

2. Check logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. Verify method dipanggil:
   ```
   Look for: "🔄 Merged: Position X replaced..."
   ```

### **Problem: Jadwal tidak replace posisi**

**Check:**
1. Apakah `layout_order` di scheduled media sudah benar?
   ```sql
   SELECT id, media_id, layout_position 
   FROM schedules 
   WHERE start_date <= CURDATE();
   ```

2. Apakah `layout_order` di default media sudah benar?
   ```sql
   SELECT id, name, layout_order 
   FROM media 
   WHERE show_on_landing = 1;
   ```

### **Problem: Posisi default kosong**

**Check:**
1. Apakah ada media di layout manager?
   ```sql
   SELECT * FROM media WHERE show_on_landing = 1;
   ```

2. Apakah `layout_order` tidak NULL?
3. Set layout di Layout Manager page

---

## 📝 ALGORITMA MERGE

```
FUNCTION mergeLayoutWithSchedule(default, scheduled):
    
    // Step 1: Create position map from default
    positionMap = {}
    FOR EACH media IN default:
        positionMap[media.position] = media
    
    // Step 2: Override with scheduled (replace only scheduled positions)
    FOR EACH media IN scheduled:
        positionMap[media.position] = media  // REPLACE
        LOG "Position X replaced with scheduled media"
    
    // Step 3: Sort by position and return
    SORT positionMap by key
    RETURN collection(positionMap)
```

**Complexity:** O(n + m) where n = default media, m = scheduled media

---

## ✅ SUMMARY

| Aspect | Behavior |
|--------|----------|
| **No Schedule** | Tampil semua dari layout default (6 posisi) |
| **1 Schedule (pos 3)** | Pos 1,2,4,5,6 default, pos 3 jadwal |
| **2 Schedules (pos 2,5)** | Pos 1,3,4,6 default, pos 2,5 jadwal |
| **Conflict (same pos)** | Jadwal terbaru menang |
| **Expired schedule** | Kembali ke layout default |
| **Empty default** | Hanya tampil scheduled media |

---

**Key Points:**
1. ✅ Scheduled media **REPLACE** posisi tertentu saja
2. ✅ Posisi lain **TETAP** dari layout default
3. ✅ System **MERGE** keduanya
4. ✅ Conflict resolution: **jadwal terbaru prioritas**
5. ✅ Fallback: **layout default jika tidak ada jadwal**

---

**Updated:** 13 Oktober 2025
**Feature:** Merge Layout System v2.0
