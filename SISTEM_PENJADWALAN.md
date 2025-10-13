# 📅 SISTEM PENJADWALAN MEDIA - DOKUMENTASI LENGKAP

## 🎯 OVERVIEW

Sistem penjadwalan media yang terintegrasi untuk menampilkan **Gambar**, **Video**, dan **Audio** secara otomatis sesuai jadwal yang ditentukan.

---

## 📋 FITUR UTAMA

### 1. **PENJADWALAN GAMBAR & VIDEO**
- ✅ Tampil di **Landing Page** (`/`)
- ✅ Bisa pilih **posisi grid** (1-6)
- ✅ Otomatis muncul sesuai **tanggal**, **hari**, dan **waktu**
- ✅ Conflict resolution (jadwal terbaru prioritas)
- ✅ Auto-save ke database

### 2. **PENJADWALAN AUDIO**
- ✅ Tampil di **Dashboard** (`/dashboard`)
- ✅ **Auto-play** sesuai jadwal
- ✅ **Auto-stop** setelah durasi selesai
- ✅ Toggle auto-play on/off
- ✅ Refresh schedule tanpa reload page

---

## 🗄️ DATABASE STRUCTURE

### Table: `schedules`

```sql
CREATE TABLE schedules (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    media_id BIGINT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    day_of_week VARCHAR(20) NULL,  -- senin, selasa, rabu, kamis, jumat, sabtu, minggu
    time TIME NULL,
    layout_position INT NULL,       -- 1-6 untuk grid position (Gambar/Video)
    display_duration INT NULL,      -- duration dalam detik (Audio)
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);
```

### Kolom Penting:
- `media_id` - ID media yang dijadwalkan
- `start_date` - Tanggal mulai jadwal
- `end_date` - Tanggal akhir (null = selamanya)
- `day_of_week` - Hari spesifik (null = setiap hari)
- `time` - Waktu spesifik (null = sepanjang hari)
- `layout_position` - Posisi 1-6 untuk Gambar/Video
- `display_duration` - Durasi playback untuk Audio

---

## 🎬 CARA KERJA

### **A. PENJADWALAN MEDIA (Gambar & Video)**

#### 1. **Buat Jadwal:**
```
Dashboard → Jadwal → Pilih Media → Set:
- Tanggal Mulai
- Tanggal Akhir (optional)
- Hari dalam Minggu (optional)
- Waktu (optional)
- Posisi Grid (1-6) ✅ WAJIB
```

#### 2. **Sistem Menyimpan:**
```php
Schedule::create([
    'media_id' => $mediaId,
    'start_date' => '2025-10-13',
    'end_date' => '2025-12-31',     // atau null
    'day_of_week' => 'senin',        // atau null
    'time' => '08:00',               // atau null
    'layout_position' => 3,          // Posisi 1-6
]);
```

#### 3. **Landing Page Auto-Display:**
- Landing page mengecek jadwal aktif
- Media muncul di posisi grid yang dipilih
- Jika ada conflict, jadwal terbaru yang menang
- Fallback ke layout default jika tidak ada jadwal

---

### **B. PENJADWALAN AUDIO**

#### 1. **Buat Jadwal Audio:**
```
Dashboard → Jadwal → Pilih Audio → Set:
- Tanggal Mulai
- Tanggal Akhir (optional)
- Hari dalam Minggu (optional)
- Waktu (optional)
- Durasi (dalam detik) ✅ WAJIB
```

#### 2. **Sistem Menyimpan:**
```php
Schedule::create([
    'media_id' => $audioId,
    'start_date' => '2025-10-13',
    'end_date' => null,
    'day_of_week' => null,
    'time' => '09:00',
    'display_duration' => 30,       // 30 detik
]);
```

#### 3. **Dashboard Auto-Play:**
- Dashboard mengecek jadwal audio aktif setiap 10 detik
- Audio auto-play saat jadwal aktif
- Auto-stop setelah `display_duration` selesai
- Tidak loop, play sekali saja

---

## 🔧 TECHNICAL IMPLEMENTATION

### **Controller: ScheduleController.php**

```php
public function store(Request $request)
{
    $media = Media::findOrFail($request->media_id);
    
    // Validasi berbeda untuk Audio vs Gambar/Video
    if ($media->type === 'Audio') {
        // Audio: Durasi wajib, posisi tidak perlu
        $request->validate([
            'media_id' => 'required',
            'start_date' => 'required|date',
            'display_duration' => 'required|integer|min:1',
        ]);
    } else {
        // Gambar/Video: Posisi wajib, durasi tidak perlu
        $request->validate([
            'media_id' => 'required',
            'start_date' => 'required|date',
            'layout_position' => 'required|integer|between:1,6',
        ]);
    }
    
    Schedule::create($request->all());
}
```

### **Landing Page: LandingController.php**

```php
public function index()
{
    // Get active schedules
    $activeSchedules = $this->getActiveSchedule();
    
    // Get scheduled media with position conflict resolution
    $media = $this->getScheduledMedia($activeSchedules);
    
    // Fallback to default if no schedules
    if ($media->isEmpty()) {
        $media = Media::where('show_on_landing', true)
                     ->orderBy('layout_order')
                     ->get();
    }
    
    // Get background
    $backgroundImage = $layoutSettings->backgroundMedia;
    
    return view('landingpage', compact('media', 'backgroundImage'));
}
```

### **Dashboard: DashboardController.php**

```php
public function index()
{
    // Get user media
    $media = Media::where('user_id', Auth::id())
                  ->orderBy('created_at', 'desc')
                  ->get();
    
    // Get active audio schedules
    $activeAudioSchedules = $this->getActiveAudioSchedules();
    
    return view('Dashboard', compact('media', 'activeAudioSchedules'));
}

private function getActiveAudioSchedules()
{
    return Schedule::join('media', 'schedules.media_id', '=', 'media.id')
        ->where('media.type', 'Audio')
        ->where('start_date', '<=', now())
        ->where(function($q) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', now());
        })
        // ... day and time filtering
        ->get();
}
```

### **Dashboard JavaScript (Auto-Play Audio)**

```javascript
// Check audio schedules every 10 seconds
setInterval(checkAudioSchedules, 10000);

function checkAudioSchedules() {
    fetch('/api/dashboard/audio-schedules')
        .then(r => r.json())
        .then(data => {
            if (data.success && data.schedules.length > 0) {
                // Auto-play first scheduled audio
                const schedule = data.schedules[0];
                playScheduledAudio(schedule);
            }
        });
}

function playScheduledAudio(schedule) {
    const audio = document.querySelector(`audio[data-schedule-id="${schedule.id}"]`);
    const duration = schedule.display_duration;
    
    audio.play().then(() => {
        console.log(`Playing audio for ${duration} seconds`);
        
        // Auto-stop after duration
        setTimeout(() => {
            audio.pause();
            audio.currentTime = 0;
            console.log('Audio stopped after duration');
        }, duration * 1000);
    });
}
```

---

## 📡 API ENDPOINTS

### **1. Get Active Visual Schedules (Gambar/Video)**
```
GET /api/landing/visual-schedules
Response: {
    success: true,
    schedules: [
        {
            id: 1,
            media: {...},
            layout_position: 3,
            start_date: "2025-10-13",
            time: "08:00"
        }
    ]
}
```

### **2. Get Active Audio Schedules (Dashboard)**
```
GET /api/dashboard/audio-schedules
Response: {
    success: true,
    schedules: [
        {
            id: 2,
            media: {...},
            display_duration: 30,
            start_date: "2025-10-13",
            time: "09:00"
        }
    ]
}
```

### **3. Create Schedule**
```
POST /schedule
Body: {
    media_id: 1,
    start_date: "2025-10-13",
    end_date: "2025-12-31",
    day_of_week: "senin",
    time: "08:00",
    layout_position: 3,        // untuk Gambar/Video
    display_duration: 30       // untuk Audio
}
```

---

## 🧪 TESTING GUIDE

### **Test 1: Jadwal Gambar di Landing Page**

1. **Buat Jadwal:**
   - Login → Dashboard → Jadwal
   - Pilih gambar → Set tanggal hari ini
   - Pilih posisi: 3
   - Simpan

2. **Cek Landing Page:**
   - Buka `/` di browser
   - Gambar harus muncul di posisi grid 3
   - Refresh → gambar tetap di posisi 3

3. **Cek Database:**
   ```sql
   SELECT * FROM schedules WHERE media_id = [id_gambar];
   ```

### **Test 2: Jadwal Audio di Dashboard**

1. **Buat Jadwal Audio:**
   - Login → Dashboard → Jadwal
   - Pilih file audio → Set tanggal hari ini
   - Set waktu = waktu sekarang
   - Set durasi = 30 detik
   - Simpan

2. **Cek Dashboard:**
   - Buka `/dashboard`
   - Section "Audio Terjadwal Aktif" harus muncul
   - Toggle "Auto Play" → ON
   - Audio harus auto-play
   - Harus stop setelah 30 detik

3. **Cek Console:**
   ```
   🎵 Dashboard: Playing scheduled audio [ID]
   🎵 Dashboard: Auto-stopped after 30s
   ```

### **Test 3: Conflict Resolution**

1. **Buat 2 Jadwal di Posisi yang Sama:**
   - Jadwal A: Gambar 1 → Posisi 3 → Tanggal kemarin
   - Jadwal B: Gambar 2 → Posisi 3 → Tanggal hari ini

2. **Expected Result:**
   - Landing page menampilkan Gambar 2 (jadwal terbaru)
   - Gambar 1 tidak tampil (kalah prioritas)

---

## 🔍 TROUBLESHOOTING

### **Problem: Media tidak muncul di Landing Page**

**Check:**
1. Apakah jadwal sudah disimpan?
   ```sql
   SELECT * FROM schedules WHERE media_id = [id];
   ```

2. Apakah tanggal/waktu sudah lewat?
   ```sql
   SELECT * FROM schedules 
   WHERE start_date <= CURDATE() 
   AND (end_date IS NULL OR end_date >= CURDATE());
   ```

3. Apakah ada error di console (F12)?

4. Clear cache:
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

### **Problem: Audio tidak auto-play di Dashboard**

**Check:**
1. Apakah toggle "Auto Play" sudah ON?
2. Apakah ada jadwal aktif?
   ```
   GET /api/dashboard/audio-schedules
   ```
3. Cek console untuk error
4. Refresh dashboard (Ctrl+R)

### **Problem: Audio tidak berhenti setelah durasi**

**Check:**
1. Cek `display_duration` di database
2. Cek console log untuk timeout
3. Pastikan JavaScript tidak ada error

---

## 📝 BEST PRACTICES

### **1. Penjadwalan Media:**
- ✅ Set tanggal yang jelas (start_date & end_date)
- ✅ Gunakan `day_of_week` untuk jadwal mingguan
- ✅ Gunakan `time` untuk jadwal jam spesifik
- ✅ Test jadwal sebelum tanggal aktif

### **2. Penjadwalan Audio:**
- ✅ Set durasi sesuai panjang file audio
- ✅ Jangan set durasi terlalu pendek (<5 detik)
- ✅ Test auto-play di dashboard terlebih dahulu
- ✅ Toggle auto-play OFF saat tidak diperlukan

### **3. Conflict Management:**
- ✅ Hindari jadwal overlap di posisi sama
- ✅ Gunakan end_date untuk jadwal sementara
- ✅ Review jadwal aktif secara berkala

---

## 🎓 CONTOH USE CASE

### **Use Case 1: Promo Akhir Tahun**
```
Tampilkan banner promo di posisi 1 mulai 15 Desember - 31 Desember
```

**Setup:**
- Media: banner-promo.jpg
- Start Date: 2025-12-15
- End Date: 2025-12-31
- Position: 1

### **Use Case 2: Musik Pagi Setiap Senin**
```
Putar musik motivasi setiap Senin jam 08:00 selama 5 menit
```

**Setup:**
- Media: musik-motivasi.mp3
- Start Date: 2025-10-13
- End Date: null (selamanya)
- Day: senin
- Time: 08:00
- Duration: 300 (5 menit)

### **Use Case 3: Video Informasi Jam Istirahat**
```
Tampilkan video informasi di posisi 2 setiap hari jam 12:00-13:00
```

**Setup:**
- Media: info-video.mp4
- Start Date: 2025-10-13
- End Date: null
- Day: null (setiap hari)
- Time: 12:00
- Position: 2

---

## ✅ SUMMARY

Sistem penjadwalan sudah **LENGKAP** dan **TERINTEGRASI**:

1. ✅ **Gambar & Video** → Auto-display di Landing Page dengan posisi grid
2. ✅ **Audio** → Auto-play di Dashboard dengan duration control
3. ✅ **Conflict Resolution** → Jadwal terbaru prioritas
4. ✅ **Fallback System** → Default layout jika tidak ada jadwal
5. ✅ **API Endpoints** → Lengkap untuk semua jenis media
6. ✅ **Auto-Save** → Perubahan langsung tersimpan
7. ✅ **Refresh System** → Dashboard refresh tanpa reload

---

## 🚀 CARA MENGGUNAKAN

### **Untuk Admin:**

1. **Login** → `/login`
2. **Upload Media** → `/input`
3. **Buat Jadwal** → `/schedule` (Jadwal menu)
4. **Set Tanggal & Posisi** → Sesuai kebutuhan
5. **Simpan** → Sistem auto-save
6. **Cek Landing Page** → `/` untuk visual
7. **Cek Dashboard** → `/dashboard` untuk audio

### **Untuk User (Landing Page):**

1. **Buka** → `/`
2. **Lihat Media** → Otomatis sesuai jadwal
3. **Tidak perlu login** → Public access

---

**Dibuat oleh:** Cascade AI Assistant
**Tanggal:** 13 Oktober 2025
**Versi:** 1.0 - Complete Scheduling System
