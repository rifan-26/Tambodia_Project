# ✅ Master Layout - All-in-One Dashboard

## Konsep Baru:

Semua fitur Master Layout (Template Selector + Template Builder) sekarang **menjadi satu halaman** di dalam dashboard. Tidak ada redirect ke halaman terpisah.

## Struktur:

```
┌─────────────────────────────────────────────────────────────────┐
│ Sidebar │ Main Content (Template Selector)                      │
│         │                                                        │
│ • Menu  │ ┌────────────────────────────────────────────────────┐│
│ • Menu  │ │ Master Layout                                      ││
│         │ └────────────────────────────────────────────────────┘│
│         │                                                        │
│         │ [Template 1] [Template 2] [+ Tambah Template]         │
│         │ [Template 3] [Template 4]                             │
│         │                                                        │
│         │ ┌─ Builder Panel (Slide from right) ─────────────────┐│
│         │ │ [Kembali] [Template Name] [Preview] [Simpan]       ││
│         │ │                                                     ││
│         │ │ [Builder Content in iframe]                        ││
│         │ │                                                     ││
│         │ └─────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────────────┘
```

## Fitur:

### 1. **Template Selector (Default View)**
- Grid layout dengan template cards
- Card "+ Tambah Template"
- Button Pilih/Edit/Hapus untuk setiap template
- Badge "Active" untuk template aktif

### 2. **Builder Panel (Slide Panel)**
- Muncul dari kanan saat klik "Edit" atau "+ Tambah"
- Overlay gelap di belakang
- Builder dimuat dalam iframe
- Header dengan: Kembali, Template Name, Preview, Simpan
- Tidak pindah halaman, tetap di dashboard

### 3. **Flow Interaksi:**

#### **Tambah Template:**
1. User klik card "+ Tambah Template"
2. Builder panel slide dari kanan
3. Overlay muncul
4. Builder dimuat dalam iframe
5. User design template
6. Klik "Simpan" → Panel tutup → Kembali ke selector
7. Template baru muncul di grid

#### **Edit Template:**
1. User klik button "Edit" pada template
2. Builder panel slide dari kanan
3. Template data dimuat di builder
4. User edit template
5. Klik "Simpan" → Panel tutup → Kembali ke selector
6. Template terupdate di grid

#### **Pilih Template:**
1. User klik button "Pilih"
2. Konfirmasi dengan SweetAlert2
3. Template diaktifkan
4. Badge "Active" muncul
5. Tetap di halaman yang sama

#### **Hapus Template:**
1. User klik button "Hapus"
2. Konfirmasi dengan SweetAlert2
3. Template dihapus
4. Grid diupdate
5. Tetap di halaman yang sama

## File Structure:

```
resources/views/
├── master-layout-dashboard.blade.php    # Main dashboard (all-in-one)
├── components/
│   └── template-selector-content.blade.php  # Template grid component
└── admin/templates/
    └── builder.blade.php                # Builder (loaded in iframe)
```

## Technical Implementation:

### 1. **Slide Panel**
- CSS: `position: fixed`, `right: -100%` → `right: 0`
- Transition: `0.3s ease`
- Width: `calc(100% - 280px)` (minus sidebar)

### 2. **Overlay**
- CSS: `position: fixed`, `background: rgba(0,0,0,0.5)`
- Click overlay → Close builder

### 3. **Iframe Communication**
- Builder dimuat dalam iframe
- PostMessage API untuk komunikasi
- Event: `template-saved` → Close panel & reload

### 4. **JavaScript Interception**
```javascript
// Intercept link clicks
document.addEventListener('click', function(e) {
    const target = e.target.closest('a[href*="/admin/templates/"]');
    if (target) {
        e.preventDefault();
        openBuilder(mode, id);
    }
});
```

## Keuntungan:

1. **Single Page Experience**: Tidak ada page reload
2. **Smooth Transition**: Slide animation yang smooth
3. **Context Preservation**: User tetap di dashboard
4. **Better UX**: Lebih cepat dan intuitif
5. **Consistent Navigation**: Sidebar selalu visible

## Route:

```php
Route::get('/layout', function() {
    return view('master-layout-dashboard');
})->name('layout');
```

## API Endpoints (Tetap Sama):

| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/api/layout/templates` | Load all templates |
| POST | `/admin/templates/{id}/activate` | Activate template |
| DELETE | `/admin/templates/{id}` | Delete template |
| GET | `/admin/templates/create?embedded=1` | Builder (iframe) |
| GET | `/admin/templates/{id}/edit?embedded=1` | Builder (iframe) |

## Testing:

1. ✅ Akses `/layout` - Dashboard dengan template selector
2. ✅ Klik "+ Tambah Template" - Builder slide dari kanan
3. ✅ Design template - Builder berfungsi normal
4. ✅ Klik "Simpan" - Panel tutup, template muncul di grid
5. ✅ Klik "Edit" - Builder slide dengan data template
6. ✅ Klik "Kembali" atau overlay - Panel tutup
7. ✅ Klik "Pilih" - Template diaktifkan tanpa reload
8. ✅ Klik "Hapus" - Template dihapus tanpa reload
9. ✅ Navigasi sidebar - Tetap berfungsi normal

## Responsive:

- Mobile: Builder panel full width
- Tablet: Builder panel adjusted
- Desktop: Builder panel `calc(100% - 280px)`

## Notes:

- Parameter `?embedded=1` di URL builder untuk menandakan mode iframe
- Builder bisa detect mode ini dan adjust layout jika perlu
- PostMessage digunakan untuk komunikasi iframe ↔ parent
- Overlay click → Close builder (UX pattern standard)

Sekarang Master Layout adalah **true single-page dashboard** dengan semua fitur terintegrasi! 🎉
