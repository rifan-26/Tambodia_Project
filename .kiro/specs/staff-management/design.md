# Dokumen Desain

## Ringkasan

Sistem manajemen petugas akan diimplementasikan sebagai bagian dari Layout Manager yang sudah ada, dengan menambahkan sistem tab untuk memisahkan antara manajemen Gallery dan manajemen Petugas. Desain ini menggunakan arsitektur Laravel MVC dengan Blade templates untuk frontend dan RESTful API untuk operasi CRUD.

## Arsitektur

### Arsitektur Backend
- **Framework**: Laravel 10.x
- **Controller**: LayoutController_clean (sudah ada, akan ditambahkan method baru)
- **Model**: Staff (sudah ada)
- **Database**: MySQL dengan tabel `staff`
- **Storage**: Laravel Storage (public disk) untuk foto petugas
- **Routing**: RESTful API routes

### Arsitektur Frontend
- **View Engine**: Laravel Blade
- **JavaScript**: Vanilla JS / jQuery untuk interaksi AJAX
- **CSS Framework**: Bootstrap 5 / Tailwind CSS
- **Component**: Tab Navigation System

### Struktur Aplikasi
```
Layout Manager
├── Tab Navigation
│   ├── Tab Gallery (existing)
│   │   └── Gallery Management Interface
│   └── Tab Petugas (new)
│       ├── Staff List Display
│       ├── Add Staff Form
│       ├── Edit Staff Modal
│       └── Delete Confirmation
└── Landing Page Integration
    └── Staff Display Section
```

## Komponen dan Interface

### 1. Tab Navigation Component
- **Tujuan**: Menyediakan navigasi antara halaman Gallery dan Petugas
- **Tanggung Jawab**:
  - Menampilkan dua tab: "Gallery" dan "Petugas"
  - Menandai tab aktif dengan styling yang berbeda
  - Mengatur visibility konten berdasarkan tab yang dipilih
  - Menyimpan state tab aktif di localStorage

**HTML Structure**:
```html
<ul class="nav nav-tabs" id="layoutTabs">
    <li class="nav-item">
        <a class="nav-link active" data-tab="gallery">Gallery</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-tab="staff">Petugas</a>
    </li>
</ul>
```

### 2. Staff List Component
- **Tujuan**: Menampilkan daftar semua petugas
- **Tanggung Jawab**:
  - Fetch data petugas dari API
  - Render card/list item untuk setiap petugas
  - Menampilkan foto dan nama petugas
  - Menyediakan tombol Edit dan Hapus

**Data Structure**:
```javascript
{
    id: 1,
    name: "John Doe",
    photo_path: "staff/photo123.jpg",
    position: 1,
    is_active: true,
    created_at: "2025-01-01",
    updated_at: "2025-01-01"
}
```

### 3. Add/Edit Staff Form Component
- **Tujuan**: Form untuk menambah atau mengedit data petugas
- **Tanggung Jawab**:
  - Validasi input (nama, foto)
  - Preview foto sebelum upload
  - Submit data ke API
  - Menampilkan feedback sukses/error

**Form Fields**:
- Nama Petugas (text input, required)
- Foto Petugas (file input, required untuk add, optional untuk edit)
- Posisi (select: 1 atau 2)
- Preview Image (dynamic)

### 4. Delete Confirmation Modal
- **Tujuan**: Konfirmasi sebelum menghapus data petugas
- **Tanggung Jawab**:
  - Menampilkan dialog konfirmasi
  - Mengirim request delete ke API
  - Refresh list setelah penghapusan

### 5. Landing Page Staff Display
- **Tujuan**: Menampilkan petugas di halaman landing
- **Tanggung Jawab**:
  - Fetch data petugas aktif
  - Render foto dan nama dalam layout responsif
  - Menampilkan berdasarkan posisi (1 atau 2)

## Model Data

### Staff Model
```php
class Staff extends Model
{
    protected $table = 'staff';
    
    protected $fillable = [
        'name',
        'photo_path',
        'position',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer'
    ];
    
    // Accessor untuk URL foto lengkap
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path 
            ? asset('storage/' . $this->photo_path)
            : asset('images/default-avatar.png');
    }
}
```

### Database Schema
```sql
CREATE TABLE staff (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    position INT NOT NULL DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_position (position),
    INDEX idx_is_active (is_active)
);
```

## API Endpoints

### Staff Management API

| Method | Endpoint | Deskripsi | Request Body | Response |
|--------|----------|-----------|--------------|----------|
| GET | `/api/staff` | Get all staff | - | `{success, staff[]}` |
| POST | `/api/staff` | Create staff | `{name, photo, position}` | `{success, message, staff}` |
| PUT | `/api/staff/{id}` | Update staff | `{name, photo?, position}` | `{success, message, staff}` |
| DELETE | `/api/staff/{id}` | Delete staff | - | `{success, message}` |

### Request Validation Rules

**POST /api/staff**:
```php
[
    'name' => 'required|string|max:255',
    'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
    'position' => 'required|integer|in:1,2'
]
```

**PUT /api/staff/{id}**:
```php
[
    'name' => 'required|string|max:255',
    'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    'position' => 'required|integer|in:1,2'
]
```

## Penanganan Error

### Validasi Error
- **File Type Invalid**: "Format file tidak didukung. Gunakan JPG, PNG, atau GIF"
- **File Size Exceeded**: "Ukuran file terlalu besar. Maksimal 5MB"
- **Name Required**: "Nama petugas wajib diisi"
- **Position Invalid**: "Posisi tidak valid"

### Server Error
- **Upload Failed**: "Gagal mengupload foto. Silakan coba lagi"
- **Database Error**: "Gagal menyimpan data. Silakan coba lagi"
- **Not Found**: "Data petugas tidak ditemukan"
- **Delete Failed**: "Gagal menghapus data petugas"

### Error Response Format
```json
{
    "success": false,
    "message": "Error message here",
    "errors": {
        "field_name": ["Error detail"]
    }
}
```

## Strategi Testing

### Unit Testing
- Test Staff model CRUD operations
- Test photo upload functionality
- Test validation rules
- Test accessor methods

### Feature Testing
- Test API endpoints (GET, POST, PUT, DELETE)
- Test file upload with various file types
- Test file size validation
- Test authentication and authorization

### Integration Testing
- Test tab navigation functionality
- Test form submission and data refresh
- Test landing page data display
- Test photo deletion when staff is deleted

### UI Testing
- Test responsive design on mobile/tablet/desktop
- Test form validation feedback
- Test modal interactions
- Test image preview functionality

## Pendekatan Implementasi

### Phase 1: Database dan Model
- Verifikasi tabel `staff` sudah ada (sudah dibuat sebelumnya)
- Verifikasi Staff model sudah ada dan lengkap
- Setup storage link untuk public access

### Phase 2: Backend API
- Verifikasi method CRUD di LayoutController_clean (sudah ada)
- Tambahkan routes untuk API staff
- Test API endpoints dengan Postman/Insomnia

### Phase 3: Tab Navigation System
- Modifikasi view layout-manager untuk menambahkan tab navigation
- Implementasi JavaScript untuk tab switching
- Setup localStorage untuk persist tab state

### Phase 4: Staff Management UI
- Buat form untuk add/edit staff
- Implementasi staff list display
- Tambahkan modal untuk edit dan delete confirmation
- Implementasi AJAX untuk operasi CRUD

### Phase 5: Landing Page Integration
- Tambahkan section untuk display staff di landing page
- Fetch dan render data staff
- Implementasi responsive layout untuk staff display

### Phase 6: Testing dan Optimization
- Test semua functionality
- Optimize image upload (resize, compress)
- Test cross-browser compatibility
- Performance optimization

## Pertimbangan Teknis

### File Upload Optimization
- **Image Resize**: Resize foto ke ukuran maksimal 800x800px
- **Image Compression**: Compress dengan quality 80%
- **Storage Path**: `storage/app/public/staff/`
- **Naming Convention**: `{timestamp}_{random}.{ext}`

### Security
- **CSRF Protection**: Laravel CSRF token untuk semua form
- **File Validation**: Strict validation untuk file type dan size
- **Authorization**: Middleware auth untuk semua staff routes
- **XSS Prevention**: Escape output di Blade templates

### Performance
- **Lazy Loading**: Lazy load images di landing page
- **Caching**: Cache staff data untuk landing page (5 minutes)
- **Pagination**: Implement pagination jika staff > 50
- **Image Optimization**: Serve optimized images dengan intervention/image

### Browser Compatibility
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive design
- Fallback untuk older browsers (IE11+)

### Accessibility
- Alt text untuk semua images
- Keyboard navigation support
- ARIA labels untuk interactive elements
- Screen reader friendly

## UI/UX Design

### Tab Navigation Design
```
┌─────────────────────────────────────┐
│ [Gallery] [Petugas]                 │
├─────────────────────────────────────┤
│                                     │
│  Content Area                       │
│                                     │
└─────────────────────────────────────┘
```

### Staff List Layout
```
┌─────────────────────────────────────┐
│ [+ Tambah Petugas]                  │
├─────────────────────────────────────┤
│ ┌─────┐ John Doe                    │
│ │ IMG │ Posisi: 1                   │
│ └─────┘ [Edit] [Hapus]              │
├─────────────────────────────────────┤
│ ┌─────┐ Jane Smith                  │
│ │ IMG │ Posisi: 2                   │
│ └─────┘ [Edit] [Hapus]              │
└─────────────────────────────────────┘
```

### Landing Page Staff Display
```
┌─────────────────────────────────────┐
│         Petugas Kami                │
├─────────────────────────────────────┤
│  ┌─────┐    ┌─────┐                │
│  │ IMG │    │ IMG │                │
│  └─────┘    └─────┘                │
│  John Doe   Jane Smith              │
└─────────────────────────────────────┘
```

## Integrasi dengan Sistem yang Ada

### Layout Manager Integration
- Tab Petugas akan ditambahkan di samping tab Gallery yang sudah ada
- Menggunakan controller yang sama (LayoutController_clean)
- Sharing authentication dan authorization system
- Consistent UI/UX dengan Gallery management

### Landing Page Integration
- Staff display akan ditambahkan sebagai section baru di landing page
- Menggunakan API endpoint yang sama dengan layout manager
- Responsive design yang konsisten dengan layout grid yang ada
- Cache strategy yang sama dengan media display
