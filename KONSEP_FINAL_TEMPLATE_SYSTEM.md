# Konsep Final: Template System dengan Design Builder

## Overview

Sistem template dengan 2 halaman utama:
1. **Master Layout** - Halaman pilih & manage template
2. **Design Builder** - Halaman design template (seperti Canva)

## Flow Diagram

```
┌─────────────────────────────────────────────────────────┐
│           MASTER LAYOUT (/layout)                        │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌─────────┐│
│  │          │  │          │  │          │  │    +    ││
│  │Template 1│  │Template 2│  │Template 3│  │  Tambah ││
│  │          │  │          │  │          │  │ Template││
│  └──────────┘  └──────────┘  └──────────┘  └─────────┘│
│                                                          │
│  [Klik Template] → Load & Edit di Master Layout         │
│  [Klik + Tambah] → Redirect ke Design Builder           │
│                                                          │
└─────────────────────────────────────────────────────────┘
                          ↓ Klik "Tambah Template"
┌─────────────────────────────────────────────────────────┐
│      DESIGN BUILDER (/admin/templates/create)           │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌────────┐  ┌──────────────────────┐  ┌─────────────┐│
│  │ Grid   │  │                      │  │ Properties  ││
│  │Selector│  │   Design Canvas      │  │   Panel     ││
│  │        │  │                      │  │             ││
│  │ 1-col  │  │   [Preview]          │  │ • Text      ││
│  │ 2-col  │  │                      │  │ • Font      ││
│  │ 3-col  │  │                      │  │ • Color     ││
│  │ 2x2    │  │                      │  │ • Size      ││
│  │ 3x3    │  │                      │  │             ││
│  └────────┘  └──────────────────────┘  └─────────────┘│
│                                                          │
│  Toolbar: [Text] [Color] [Image] [Undo] [Redo]         │
│                                                          │
│  [Simpan Template] → Kembali ke Master Layout           │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

## Halaman 1: Master Layout (/layout)

### Tampilan Awal
```
┌─────────────────────────────────────────────────────────┐
│  Master Layout                                           │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Template                                                │
│                                                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌─────────┐│
│  │ [thumb]  │  │ [thumb]  │  │ [thumb]  │  │    +    ││
│  │          │  │          │  │          │  │         ││
│  │Template 1│  │Template 2│  │Template 3│  │ Tambah  ││
│  │          │  │          │  │          │  │Template ││
│  │ [Pilih]  │  │ [Pilih]  │  │ [Pilih]  │  │         ││
│  │ [Edit]   │  │ [Edit]   │  │ [Edit]   │  │         ││
│  │ [Hapus]  │  │ [Hapus]  │  │ [Hapus]  │  │         ││
│  └──────────┘  └──────────┘  └──────────┘  └─────────┘│
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### Fitur:
1. **Card Template** - Tampilkan semua template yang tersimpan
   - Thumbnail preview
   - Nama template
   - Button: Pilih, Edit, Hapus

2. **Klik Template** → Load template ke Master Layout
   - Tampilkan background
   - Tampilkan grid 6 posisi
   - Tampilkan deskripsi
   - User bisa edit & save

3. **Klik "Tambah Template"** → Redirect ke `/admin/templates/create`

## Halaman 2: Design Builder (/admin/templates/create)

### Layout
```
┌─────────────────────────────────────────────────────────┐
│  [Nama Template Input]  [Preview] [Simpan] [Batal]      │
├──────┬──────────────────────────────────────┬───────────┤
│      │                                      │           │
│ Grid │         Design Canvas                │Properties │
│Select│                                      │  Panel    │
│      │                                      │           │
│ 1col │  ┌────────────────────────────┐     │ Text:     │
│ 2col │  │                            │     │ • Content │
│ 3col │  │   [Grid Areas]             │     │ • Font    │
│ 2x2  │  │                            │     │ • Size    │
│ 3x3  │  │   [Elements]               │     │ • Color   │
│      │  │                            │     │           │
│      │  └────────────────────────────┘     │ Color:    │
│      │                                      │ • Picker  │
│      │                                      │           │
│      │                                      │ Image:    │
│      │                                      │ • Upload  │
│      │                                      │ • Fit     │
├──────┴──────────────────────────────────────┴───────────┤
│  [Text] [Color] [Image] [Undo] [Redo] [Zoom: 100%]     │
└─────────────────────────────────────────────────────────┘
```

### Fitur Design Builder:

#### 1. Grid Selector (Panel Kiri)
- 1 Column
- 2 Columns
- 3 Columns
- Grid 2x2
- Grid 3x3
- Custom Grid

#### 2. Design Canvas (Tengah)
- Preview real-time
- Click area untuk add element
- Drag & drop elements
- Zoom in/out (50% - 150%)
- Device preview (Desktop/Mobile)

#### 3. Toolbar (Bawah)
- **Add Text**: Tambah elemen teks
- **Add Color**: Tambah background color
- **Add Image**: Upload & tambah gambar
- **Undo**: Batalkan perubahan
- **Redo**: Ulangi perubahan
- **Zoom**: Atur zoom level

#### 4. Properties Panel (Kanan)
Tampil ketika element dipilih:

**Text Properties:**
- Content (textarea)
- Font Family (dropdown: Arial, Roboto, Times, dll)
- Font Size (slider: 10-100px)
- Font Weight (Normal, Bold, Light)
- Text Color (color picker)
- Text Align (Left, Center, Right)
- Line Height
- Letter Spacing

**Color Properties:**
- Background Color (color picker)
- Opacity (slider: 0-1)
- Gradient (optional)

**Image Properties:**
- Upload Image
- Object Fit (Cover, Contain, Fill)
- Object Position (Center, Top, Bottom, etc)
- Opacity (slider: 0-1)
- Filters (optional: Brightness, Contrast, etc)

#### 5. Save Template
- Input nama template
- Generate thumbnail
- Save ke database
- Redirect ke Master Layout

## Database Structure

```sql
layout_templates:
- id
- name (nama template)
- description (deskripsi)
- grid_type (1-col, 2-col, 3-col, 2x2, 3x3)
- grid_config (JSON: konfigurasi grid)
- elements (JSON: array elemen design)
- thumbnail_path (path thumbnail preview)
- is_active (boolean)
- created_by (user ID)
- created_at
- updated_at
```

### Grid Config JSON:
```json
{
  "type": "2x2",
  "rows": 2,
  "columns": 2,
  "areas": [
    {"id": 1, "row": 1, "col": 1, "rowSpan": 1, "colSpan": 1},
    {"id": 2, "row": 1, "col": 2, "rowSpan": 1, "colSpan": 1},
    {"id": 3, "row": 2, "col": 1, "rowSpan": 1, "colSpan": 1},
    {"id": 4, "row": 2, "col": 2, "rowSpan": 1, "colSpan": 1}
  ],
  "gap": "20px",
  "padding": "30px"
}
```

### Elements JSON:
```json
[
  {
    "id": "elem-1",
    "type": "text",
    "gridArea": 1,
    "content": "Welcome to BPS",
    "styles": {
      "fontFamily": "Roboto",
      "fontSize": "24px",
      "fontWeight": "bold",
      "color": "#333333",
      "textAlign": "center",
      "lineHeight": "1.5",
      "letterSpacing": "0px"
    }
  },
  {
    "id": "elem-2",
    "type": "color",
    "gridArea": 2,
    "styles": {
      "backgroundColor": "#1345BE",
      "opacity": 1
    }
  },
  {
    "id": "elem-3",
    "type": "image",
    "gridArea": 3,
    "mediaId": 15,
    "imagePath": "/storage/templates/image.jpg",
    "styles": {
      "objectFit": "cover",
      "objectPosition": "center",
      "opacity": 1
    }
  }
]
```

## Implementation Plan

### Phase 1: Update Master Layout UI
1. Ganti UI Template Manager dengan card grid
2. Tampilkan template cards dengan thumbnail
3. Add button "Tambah Template" yang redirect ke builder
4. Implement load template functionality

### Phase 2: Reuse Design Builder
1. Gunakan halaman builder yang sudah ada (`/admin/templates/create`)
2. Update dengan font selector
3. Add more text properties (line-height, letter-spacing)
4. Improve color picker
5. Add gradient support (optional)

### Phase 3: Integration
1. Link "Tambah Template" ke builder
2. Link "Edit" template ke builder dengan data
3. After save di builder → redirect ke Master Layout
4. Show success message

### Phase 4: Polish
1. Add loading states
2. Improve animations
3. Add keyboard shortcuts
4. Add tooltips & help

## User Flow

### Create New Template:
1. Buka Master Layout (`/layout`)
2. Klik card "Tambah Template"
3. Redirect ke Design Builder
4. Pilih grid layout
5. Tambah elements (text, color, image)
6. Edit properties (font, color, size, dll)
7. Klik "Simpan Template"
8. Input nama template
9. Save & redirect ke Master Layout
10. Template baru muncul di card grid

### Use Existing Template:
1. Buka Master Layout
2. Klik "Pilih" pada template card
3. Template ter-load (background + grid + deskripsi)
4. Edit jika perlu
5. Klik "Simpan Layout"
6. Apply ke landing page

### Edit Template:
1. Buka Master Layout
2. Klik "Edit" pada template card
3. Redirect ke Design Builder dengan data template
4. Edit elements & properties
5. Klik "Simpan Template"
6. Update & redirect ke Master Layout

## Files to Modify

1. `resources/views/layout-manager.blade.php`
   - Update UI dengan card grid
   - Add "Tambah Template" button
   - Implement load template

2. `resources/views/admin/templates/builder.blade.php`
   - Add font selector
   - Add more text properties
   - Improve UI

3. `public/js/template-builder.js`
   - Add font management
   - Add text properties
   - Improve element editing

4. `app/Http/Controllers/LayoutController_clean.php`
   - Keep existing template methods

5. `app/Http/Controllers/TemplateController.php`
   - Keep existing builder methods

## Next Steps

1. Update Master Layout UI dengan card grid template
2. Add link "Tambah Template" → redirect ke builder
3. Test flow: Create → Save → Load → Edit
4. Polish & improve UX

Sistem ini menggabungkan yang terbaik dari kedua approach:
- **Master Layout**: Simple, quick access, load template
- **Design Builder**: Powerful, full design tools, create from scratch
