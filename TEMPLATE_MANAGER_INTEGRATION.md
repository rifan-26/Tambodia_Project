# Template Manager Integration

## Akses Template Manager

Template Manager sudah terintegrasi dengan sistem Master Layout. Berikut cara mengaksesnya:

### 1. Dari Dashboard
- Login ke dashboard admin
- Klik menu "Master Layout" di sidebar
- Di halaman Master Layout, akan ada tombol "Template Manager" atau link ke `/admin/templates`

### 2. Akses Langsung
- URL: `http://your-domain.com/admin/templates`
- Halaman ini menampilkan semua template yang tersedia

## Fitur Template Manager

### Halaman Template List (`/admin/templates`)
- Melihat semua template yang sudah dibuat
- Preview thumbnail setiap template
- Tombol aksi:
  - **Pilih**: Aktifkan template untuk landing page
  - **Edit**: Edit template di builder
  - **Hapus**: Hapus template (tidak bisa hapus yang aktif)
- Tombol **+ (FAB)**: Buat template baru

### Halaman Template Builder (`/admin/templates/create` atau `/admin/templates/{id}/edit`)
- **Grid Selector (Kiri)**: Pilih tipe grid (1-col, 2-col, 3-col, 2x2, 3x3)
- **Canvas (Tengah)**: Area design template
- **Properties Panel (Kanan)**: Edit properties elemen yang dipilih
- **Toolbar**:
  - Add Text: Tambah elemen teks
  - Add Color: Tambah warna background
  - Add Image: Upload dan tambah gambar
  - Undo/Redo: Batalkan/ulangi perubahan
  - Zoom: Atur zoom canvas (50%-150%)

## Cara Menggunakan

### Membuat Template Baru
1. Klik tombol **+** di halaman template list
2. Pilih grid layout dari panel kiri
3. Klik area grid di canvas
4. Pilih tool (Text/Color/Image) dari toolbar
5. Klik area grid untuk menambahkan elemen
6. Edit properties di panel kanan
7. Klik **Simpan Template**

### Mengedit Template
1. Klik tombol **Edit** pada template card
2. Template akan dimuat di builder
3. Ubah grid, tambah/edit/hapus elemen
4. Klik **Simpan Template**

### Mengaktifkan Template
1. Klik tombol **Pilih** pada template yang diinginkan
2. Konfirmasi aktivasi
3. Template akan langsung diterapkan ke landing page
4. Hanya 1 template yang bisa aktif

### Menghapus Template
1. Klik tombol **Hapus** (ikon trash)
2. Konfirmasi penghapusan
3. Template aktif tidak bisa dihapus

## Integrasi dengan Landing Page

- Ketika template diaktifkan, landing page akan otomatis menggunakan template tersebut
- Jika tidak ada template aktif, landing page akan menggunakan layout default
- Template mendukung responsive design (desktop & mobile)

## Database

Template disimpan di tabel `layout_templates` dengan struktur:
- `name`: Nama template
- `grid_type`: Tipe grid (1-col, 2-col, 3-col, 2x2, 3x3)
- `grid_config`: Konfigurasi grid (JSON)
- `elements`: Array elemen design (JSON)
- `is_active`: Status aktif (boolean)
- `created_by`: User yang membuat

## Routes

```php
// Template Management
GET  /admin/templates           - List templates
GET  /admin/templates/create    - Create new template
POST /admin/templates           - Store template
GET  /admin/templates/{id}/edit - Edit template
PUT  /admin/templates/{id}      - Update template
DELETE /admin/templates/{id}    - Delete template
POST /admin/templates/{id}/activate - Activate template

// API
POST /api/templates/upload-image - Upload image for template
```

## Menambahkan Link di Master Layout

Untuk menambahkan link ke Template Manager di halaman Master Layout, tambahkan button ini di `layout-manager.blade.php`:

```html
<div class="card mb-4">
  <div class="card-header">
    <h5>
      <i class="fas fa-palette me-2"></i>Template Manager
    </h5>
  </div>
  <div class="card-body">
    <p>Kelola template layout untuk halaman landing dengan visual builder</p>
    <a href="{{ route('templates.index') }}" class="btn btn-primary">
      <i class="fas fa-th-large me-2"></i>Buka Template Manager
    </a>
  </div>
</div>
```

Atau tambahkan di sidebar navigation:

```html
<li class="nav-item mb-1">
  <a class="nav-link" href="{{ route('templates.index') }}">
    <i class="bi bi-palette"></i> Template Manager
  </a>
</li>
```
