# Dokumen Desain - Template Layout Builder

## Gambaran Umum

Sistem Template Layout Builder adalah aplikasi visual drag-and-drop yang memungkinkan administrator untuk membuat, mengelola, dan menerapkan template layout kustom untuk halaman landing. Sistem ini menggunakan arsitektur Laravel MVC dengan frontend interaktif berbasis JavaScript untuk memberikan pengalaman design yang intuitif seperti aplikasi design profesional.

## Arsitektur

### Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                     Browser (Frontend)                       │
│  ┌──────────────────┐  ┌──────────────────┐                │
│  │ Master Layout    │  │ Template Builder │                │
│  │ Page             │  │ Page             │                │
│  │ - Template List  │  │ - Grid Selector  │                │
│  │ - Preview        │  │ - Design Canvas  │                │
│  │ - Select/Edit    │  │ - Toolbox        │                │
│  └──────────────────┘  └──────────────────┘                │
└─────────────────────────────────────────────────────────────┘
                          ↕ HTTP/AJAX
┌─────────────────────────────────────────────────────────────┐
│                   Laravel Backend (MVC)                      │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Controllers Layer                        │  │
│  │  - TemplateController (CRUD operations)              │  │
│  │  - LandingController (render active template)        │  │
│  └──────────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Models Layer                             │  │
│  │  - LayoutTemplate                                     │  │
│  │  - TemplateElement                                    │  │
│  │  - Media                                              │  │
│  └──────────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Database (SQLite)                        │  │
│  │  - layout_templates                                   │  │
│  │  - template_elements                                  │  │
│  │  - media                                              │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### Technology Stack

**Backend:**
- Laravel 11.x (PHP Framework)
- SQLite Database
- Eloquent ORM
- Laravel Validation
- Laravel Storage (untuk file upload)

**Frontend:**
- Blade Templates
- Vanilla JavaScript (ES6+)
- HTML5 Canvas API (untuk preview)
- CSS Grid & Flexbox
- Bootstrap 5 (UI Components)
- Font Awesome (Icons)

**Design Tools:**
- Drag & Drop API
- Color Picker (HTML5 Input Color)
- File Upload API
- JSON untuk menyimpan konfigurasi template

## Komponen dan Interface

### 1. Halaman Master Layout (`/admin/templates`)

**Tujuan:** Menampilkan daftar semua template dan memungkinkan administrator untuk memilih, edit, atau hapus template.

**Komponen UI:**
- **Template Grid**: Grid card yang menampilkan preview thumbnail setiap template
- **Template Card**: 
  - Thumbnail preview (screenshot dari template)
  - Nama template
  - Tanggal dibuat/diupdate
  - Badge "Active" untuk template yang sedang digunakan
  - Tombol aksi: "Pilih", "Edit", "Hapus"
- **Add Template Button**: Tombol floating action button untuk membuat template baru
- **Search & Filter**: Input pencarian dan filter berdasarkan tanggal

**Controller:** `TemplateController@index`

**View:** `resources/views/admin/templates/index.blade.php`

### 2. Halaman Template Builder (`/admin/templates/create` atau `/admin/templates/{id}/edit`)

**Tujuan:** Interface visual untuk mendesain template dengan berbagai tools.

**Layout Struktur:**
```
┌─────────────────────────────────────────────────────────┐
│  Header: [Template Name Input] [Save] [Cancel]         │
├─────────────────────────────────────────────────────────┤
│  ┌──────────┐  ┌──────────────────────────┐  ┌───────┐ │
│  │          │  │                          │  │       │ │
│  │  Grid    │  │     Design Canvas        │  │ Props │ │
│  │ Selector │  │   (Preview Template)     │  │ Panel │ │
│  │          │  │                          │  │       │ │
│  │  - 1 Col │  │                          │  │ Text  │ │
│  │  - 2 Col │  │                          │  │ Color │ │
│  │  - 3 Col │  │                          │  │ Image │ │
│  │  - 2x2   │  │                          │  │ Size  │ │
│  │  - 3x3   │  │                          │  │       │ │
│  │  - Custom│  │                          │  │       │ │
│  │          │  │                          │  │       │ │
│  └──────────┘  └──────────────────────────┘  └───────┘ │
├─────────────────────────────────────────────────────────┤
│  Toolbar: [Text] [Color] [Image] [Undo] [Redo]         │
└─────────────────────────────────────────────────────────┘
```

**Komponen UI:**

1. **Grid Selector Panel (Kiri)**
   - List pilihan grid layout preset
   - Preview mini untuk setiap grid
   - Custom grid builder (advanced)

2. **Design Canvas (Tengah)**
   - Area kerja utama untuk mendesain
   - Grid lines sebagai panduan
   - Drag & drop elements
   - Click untuk select element
   - Real-time preview
   - Zoom controls (zoom in/out)
   - Device preview toggle (desktop/mobile)

3. **Properties Panel (Kanan)**
   - Properties untuk element yang dipilih
   - Text properties: font size, color, alignment, content
   - Color properties: background color picker
   - Image properties: upload, position (cover/contain/center), opacity
   - Grid cell properties: padding, margin

4. **Toolbar (Bawah)**
   - Add Text button
   - Add Color button
   - Add Image button
   - Undo/Redo buttons
   - Clear all button

**Controller:** `TemplateController@create`, `TemplateController@edit`

**View:** `resources/views/admin/templates/builder.blade.php`

### 3. Halaman Landing Page (`/`)

**Tujuan:** Menampilkan template yang aktif kepada pengunjung.

**Komponen:**
- Render template berdasarkan konfigurasi dari database
- Dynamic layout generation dari JSON template data
- Responsive design

**Controller:** `LandingController@index`

**View:** `resources/views/landingpage.blade.php` (modified)

## Model Data

### 1. Model: LayoutTemplate

**Tabel:** `layout_templates`

**Struktur Database:**
```php
Schema::create('layout_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Nama template
    $table->text('description')->nullable(); // Deskripsi template
    $table->string('thumbnail_path')->nullable(); // Path ke thumbnail preview
    $table->string('grid_type'); // Tipe grid: '1-col', '2-col', '3-col', '2x2', '3x3', 'custom'
    $table->json('grid_config'); // Konfigurasi grid (rows, columns, areas)
    $table->json('elements'); // Array elemen design (text, color, image)
    $table->boolean('is_active')->default(false); // Template yang sedang digunakan
    $table->unsignedBigInteger('created_by'); // User yang membuat
    $table->timestamps();
    $table->softDeletes(); // Soft delete untuk history
    
    $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
    $table->index('is_active');
});
```

**Struktur JSON `grid_config`:**
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

**Struktur JSON `elements`:**
```json
[
  {
    "id": "elem-1",
    "type": "text",
    "gridArea": 1,
    "content": "Welcome to BPS",
    "styles": {
      "fontSize": "24px",
      "color": "#333333",
      "fontWeight": "bold",
      "textAlign": "center",
      "padding": "20px"
    },
    "position": {
      "x": 0,
      "y": 0,
      "width": "100%",
      "height": "auto"
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
    "imagePath": "/storage/media/background.jpg",
    "styles": {
      "objectFit": "cover",
      "objectPosition": "center",
      "opacity": 0.8
    }
  }
]
```

**Eloquent Relationships:**
```php
class LayoutTemplate extends Model
{
    protected $fillable = [
        'name', 'description', 'thumbnail_path', 'grid_type', 
        'grid_config', 'elements', 'is_active', 'created_by'
    ];
    
    protected $casts = [
        'grid_config' => 'array',
        'elements' => 'array',
        'is_active' => 'boolean'
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function media()
    {
        return $this->belongsToMany(Media::class, 'template_media');
    }
}
```

### 2. Model: Media (Existing - Extended)

**Tabel:** `media` (sudah ada, tidak perlu diubah)

Digunakan untuk menyimpan gambar yang diupload untuk background template.

## API Endpoints

### Template Management

| Method | Endpoint | Controller Method | Deskripsi |
|--------|----------|-------------------|-----------|
| GET | `/admin/templates` | `TemplateController@index` | List semua template |
| GET | `/admin/templates/create` | `TemplateController@create` | Form create template |
| POST | `/admin/templates` | `TemplateController@store` | Simpan template baru |
| GET | `/admin/templates/{id}/edit` | `TemplateController@edit` | Form edit template |
| PUT | `/admin/templates/{id}` | `TemplateController@update` | Update template |
| DELETE | `/admin/templates/{id}` | `TemplateController@destroy` | Hapus template |
| POST | `/admin/templates/{id}/activate` | `TemplateController@activate` | Set template sebagai active |
| POST | `/admin/templates/{id}/duplicate` | `TemplateController@duplicate` | Duplicate template |
| POST | `/admin/templates/{id}/thumbnail` | `TemplateController@generateThumbnail` | Generate thumbnail |

### Template Builder API (AJAX)

| Method | Endpoint | Controller Method | Deskripsi |
|--------|----------|-------------------|-----------|
| POST | `/api/templates/save-draft` | `TemplateController@saveDraft` | Auto-save draft |
| POST | `/api/templates/upload-image` | `TemplateController@uploadImage` | Upload image untuk background |
| GET | `/api/templates/{id}/preview` | `TemplateController@preview` | Preview template |

## Frontend JavaScript Architecture

### Template Builder JavaScript

**File:** `public/js/template-builder.js`

**Struktur:**
```javascript
class TemplateBuilder {
    constructor(canvasElement) {
        this.canvas = canvasElement;
        this.gridConfig = null;
        this.elements = [];
        this.selectedElement = null;
        this.history = [];
        this.historyIndex = -1;
    }
    
    // Grid Management
    setGrid(gridType) { }
    renderGrid() { }
    
    // Element Management
    addElement(type, gridArea) { }
    selectElement(elementId) { }
    updateElement(elementId, properties) { }
    deleteElement(elementId) { }
    
    // Canvas Rendering
    render() { }
    clear() { }
    
    // History Management
    addToHistory() { }
    undo() { }
    redo() { }
    
    // Export/Import
    exportTemplate() { }
    importTemplate(data) { }
    
    // Save
    save() { }
}
```

**Event Handlers:**
- Click pada grid area → select area untuk add element
- Click pada element → select element untuk edit
- Drag element → reposition element
- Color picker change → update background color
- Text input → update text content
- Image upload → add image to element

## Grid Layout Presets

### 1. Single Column (1-col)
```
┌─────────────┐
│             │
│   Area 1    │
│             │
└─────────────┘
```

### 2. Two Columns (2-col)
```
┌──────┬──────┐
│      │      │
│ A1   │  A2  │
│      │      │
└──────┴──────┘
```

### 3. Three Columns (3-col)
```
┌────┬────┬────┐
│    │    │    │
│ A1 │ A2 │ A3 │
│    │    │    │
└────┴────┴────┘
```

### 4. Grid 2x2
```
┌──────┬──────┐
│  A1  │  A2  │
├──────┼──────┤
│  A3  │  A4  │
└──────┴──────┘
```

### 5. Grid 3x3
```
┌────┬────┬────┐
│ A1 │ A2 │ A3 │
├────┼────┼────┤
│ A4 │ A5 │ A6 │
├────┼────┼────┤
│ A7 │ A8 │ A9 │
└────┴────┴────┘
```

### 6. Custom Grid
Administrator dapat membuat grid kustom dengan:
- Jumlah rows dan columns
- Merge cells (colspan/rowspan)
- Custom gap dan padding

## Penanganan Error

### Validation Errors

1. **Template Name Required**
   - Error: "Nama template harus diisi"
   - Action: Highlight input field, show error message

2. **No Grid Selected**
   - Error: "Pilih grid layout terlebih dahulu"
   - Action: Highlight grid selector panel

3. **Image Upload Failed**
   - Error: "Gagal upload gambar. Ukuran maksimal 5MB"
   - Action: Show toast notification, clear file input

4. **Template Save Failed**
   - Error: "Gagal menyimpan template. Coba lagi"
   - Action: Show error modal, keep data in form

### Runtime Errors

1. **Active Template Deletion**
   - Prevent: Tidak bisa hapus template yang sedang aktif
   - Message: "Template aktif tidak dapat dihapus. Pilih template lain terlebih dahulu"

2. **Database Connection Error**
   - Fallback: Show error page dengan retry button
   - Log: Log error ke Laravel log file

3. **Image Not Found**
   - Fallback: Show placeholder image
   - Log: Log missing image path

## Testing Strategy

### Unit Tests

1. **Model Tests**
   - Test LayoutTemplate model CRUD operations
   - Test JSON casting untuk grid_config dan elements
   - Test relationships

2. **Controller Tests**
   - Test template creation
   - Test template activation
   - Test template deletion (prevent active template deletion)

### Feature Tests

1. **Template Management**
   - Test create template flow
   - Test edit template flow
   - Test activate template
   - Test delete template

2. **Template Builder**
   - Test grid selection
   - Test element addition
   - Test element editing
   - Test template save

3. **Landing Page Rendering**
   - Test active template rendering
   - Test fallback when no active template
   - Test responsive rendering

### Browser Tests (Manual)

1. **Cross-browser Testing**
   - Chrome, Firefox, Safari, Edge
   - Test drag & drop functionality
   - Test color picker
   - Test file upload

2. **Responsive Testing**
   - Desktop (1920x1080, 1366x768)
   - Tablet (768x1024)
   - Mobile (375x667, 414x896)

## Implementation Phases

### Phase 1: Database & Models
- Create migration untuk layout_templates
- Create LayoutTemplate model
- Setup relationships

### Phase 2: Master Layout Page
- Create template list view
- Implement template card component
- Add create/edit/delete actions
- Implement template activation

### Phase 3: Template Builder - Basic
- Create builder page layout
- Implement grid selector
- Create design canvas
- Add basic grid rendering

### Phase 4: Template Builder - Elements
- Implement text element
- Implement color element
- Implement image element
- Add element properties panel

### Phase 5: Template Builder - Interactions
- Implement drag & drop
- Add undo/redo functionality
- Implement save functionality
- Add auto-save draft

### Phase 6: Landing Page Integration
- Modify LandingController to load active template
- Create template renderer
- Implement responsive rendering
- Test integration

### Phase 7: Polish & Testing
- Add loading states
- Improve error handling
- Add animations
- Comprehensive testing

## Technical Considerations

### Performance Optimization

1. **Database Queries**
   - Use eager loading untuk relationships
   - Index pada is_active column
   - Cache active template

2. **Frontend Performance**
   - Debounce auto-save (save setiap 5 detik)
   - Lazy load images
   - Optimize canvas rendering

3. **File Storage**
   - Compress uploaded images
   - Generate multiple sizes (thumbnail, medium, large)
   - Use Laravel Storage dengan symbolic link

### Security

1. **Authorization**
   - Only authenticated admin can access template builder
   - Use Laravel Gates/Policies
   - Validate user permissions

2. **File Upload**
   - Validate file type (only images)
   - Validate file size (max 5MB)
   - Sanitize file names
   - Store outside public directory

3. **XSS Prevention**
   - Sanitize text input
   - Escape output in Blade templates
   - Use CSP headers

### Browser Compatibility

1. **Modern Features**
   - CSS Grid (IE 11+ with fallback)
   - Drag & Drop API (All modern browsers)
   - HTML5 Color Input (All modern browsers)
   - JSON support (All browsers)

2. **Fallbacks**
   - Flexbox fallback untuk CSS Grid
   - Manual color input untuk browser tanpa color picker
   - Traditional file input untuk drag & drop

## Accessibility

1. **Keyboard Navigation**
   - Tab navigation untuk semua controls
   - Keyboard shortcuts (Ctrl+Z untuk undo, Ctrl+S untuk save)
   - Focus indicators

2. **Screen Reader Support**
   - ARIA labels untuk interactive elements
   - Alt text untuk images
   - Semantic HTML

3. **Color Contrast**
   - WCAG AA compliance
   - High contrast mode support
   - Color blind friendly palette

## Future Enhancements

1. **Advanced Features**
   - Animation support untuk elements
   - Video background support
   - Multiple pages per template
   - Template marketplace/library

2. **Collaboration**
   - Real-time collaboration (multiple users editing)
   - Version control untuk templates
   - Comments dan feedback system

3. **Analytics**
   - Track template usage
   - A/B testing untuk templates
   - Performance metrics
