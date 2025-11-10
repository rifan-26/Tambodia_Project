# Revisi: Template System di Master Layout

## Konsep Baru (Yang Benar)

Template system terintegrasi LANGSUNG di halaman Master Layout (`/layout`), bukan halaman terpisah.

### Fitur yang Akan Ditambahkan:

1. **Simpan Template**
   - Button "Simpan sebagai Template" di halaman Master Layout
   - Modal input nama template
   - Menyimpan:
     - Background image yang dipilih
     - 6 posisi grid media yang sudah diatur
     - Deskripsi landing page
   - Tersimpan ke database

2. **Load Template**
   - Dropdown/List template yang tersedia
   - Klik template → otomatis load:
     - Background image
     - Media di 6 posisi grid
     - Deskripsi
   - Langsung diterapkan ke Master Layout

3. **Manage Templates**
   - List template yang sudah disimpan
   - Rename template
   - Delete template
   - Set as default (opsional)

### UI Changes di Master Layout:

```
┌─────────────────────────────────────────────────────┐
│  Master Layout                                       │
├─────────────────────────────────────────────────────┤
│                                                      │
│  [📋 Template Tersimpan]  [💾 Simpan Template]     │
│                                                      │
│  ┌──────────────────────────────────────────────┐  │
│  │ Pilih Template:                               │  │
│  │ [Dropdown: Template 1, Template 2, ...]      │  │
│  │ [Load Template] [Hapus Template]             │  │
│  └──────────────────────────────────────────────┘  │
│                                                      │
│  [Background Selector] - existing                   │
│  [Grid 6 Posisi]       - existing                   │
│  [Preview & Deskripsi] - existing                   │
│                                                      │
└─────────────────────────────────────────────────────┘
```

### Database Structure:

Gunakan tabel `layout_templates` yang sudah ada, tapi struktur lebih sederhana:

```php
layout_templates:
- id
- name (nama template)
- background_media_id (ID media background)
- grid_positions (JSON: {1: media_id, 2: media_id, ...})
- description (deskripsi landing page)
- created_by
- created_at
- updated_at
```

### Flow:

**Simpan Template:**
1. User atur layout di Master Layout (background + 6 grid + deskripsi)
2. Klik "Simpan sebagai Template"
3. Input nama template
4. Save ke database

**Load Template:**
1. Pilih template dari dropdown
2. Klik "Load Template"
3. System load data dari database
4. Apply ke Master Layout:
   - Set background
   - Set media di 6 posisi grid
   - Set deskripsi
5. User bisa langsung "Simpan Layout" untuk apply ke landing page

### Implementation Plan:

1. Tambah section "Template Manager" di atas existing content
2. Tambah button "Simpan sebagai Template"
3. Tambah dropdown template selector
4. Tambah fungsi JavaScript:
   - `saveAsTemplate()` - simpan current layout
   - `loadTemplate(id)` - load template by ID
   - `deleteTemplate(id)` - hapus template
5. Update LayoutController untuk handle template operations
6. Simplify database structure

Ini lebih sederhana dan user-friendly!
