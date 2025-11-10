# Design Document - Template Builder Modal

## Overview

Implementasi Template Builder dalam modal full-screen yang muncul di halaman Master Layout (`/layout`) tanpa redirect. Builder akan dimuat secara dinamis dan terintegrasi dengan template selector yang ada.

## Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│ Master Layout Page (/layout)                                │
│                                                              │
│ ┌──────────┐  ┌─────────────────────────────────────────┐  │
│ │ Sidebar  │  │ Main Content                            │  │
│ │          │  │                                         │  │
│ │ • Menu   │  │ Template Selector (Default View)       │  │
│ │ • Menu   │  │ [+ Add] [Tmpl 1] [Tmpl 2]              │  │
│ │          │  │                                         │  │
│ │          │  │ ┌─────────────────────────────────────┐ │  │
│ │          │  │ │ Builder Modal (Hidden by default)   │ │  │
│ │          │  │ │                                     │ │  │
│ │          │  │ │ [Header: Back | Name | Save]        │ │  │
│ │          │  │ │                                     │ │  │
│ │          │  │ │ [Grid] [Canvas] [Properties]        │ │  │
│ │          │  │ │                                     │ │  │
│ │          │  │ └─────────────────────────────────────┘ │  │
│ └──────────┘  └─────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### Component Structure

```
master-layout.blade.php
├── Sidebar (Always visible)
├── Template Selector (Main content)
│   ├── Template Grid
│   └── Template Cards
└── Builder Modal (Overlay)
    ├── Modal Overlay (Background)
    ├── Modal Panel (Container)
    │   ├── Builder Header
    │   │   ├── Back Button
    │   │   ├── Template Name Input
    │   │   └── Action Buttons (Preview, Save)
    │   └── Builder Content
    │       ├── Grid Selector Panel
    │       ├── Canvas Area
    │       └── Properties Panel
    └── Builder State Manager (JavaScript)
```

## Components and Interfaces

### 1. Modal Overlay Component

**Purpose**: Background overlay yang menggelapkan konten di belakang modal

**HTML Structure**:
```html
<div id="builderOverlay" class="builder-overlay">
  <!-- Transparent background, click to close -->
</div>
```

**CSS**:
```css
.builder-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 2000;
  display: none;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.builder-overlay.active {
  display: block;
  opacity: 1;
}
```

### 2. Modal Panel Component

**Purpose**: Container utama untuk builder content

**HTML Structure**:
```html
<div id="builderModal" class="builder-modal">
  <div class="builder-header">
    <!-- Header content -->
  </div>
  <div class="builder-content">
    <!-- Builder interface -->
  </div>
</div>
```

**CSS**:
```css
.builder-modal {
  position: fixed;
  top: 0;
  right: -100%;
  width: calc(100% - 280px); /* Minus sidebar */
  height: 100%;
  background: white;
  z-index: 2001;
  transition: right 0.3s ease;
  display: flex;
  flex-direction: column;
}

.builder-modal.active {
  right: 0;
}
```

### 3. Builder Content Component

**Purpose**: Interface builder (grid selector, canvas, properties)

**Approach**: Reuse existing builder HTML structure from `builder.blade.php`

**Options**:
- **Option A**: Include builder HTML inline (simpler, larger file)
- **Option B**: Load via AJAX (cleaner, requires endpoint)
- **Option C**: Use Blade component (best practice)

**Recommended**: Option C - Blade Component

**Structure**:
```
resources/views/components/
└── template-builder.blade.php  (Builder interface)
```

### 4. Builder State Manager (JavaScript)

**Purpose**: Manage modal state, builder data, and interactions

**Class Structure**:
```javascript
class TemplateBuilderModal {
  constructor() {
    this.isOpen = false;
    this.mode = null; // 'create' or 'edit'
    this.templateId = null;
    this.templateData = {};
    this.hasUnsavedChanges = false;
  }
  
  open(mode, templateId = null) { }
  close() { }
  save() { }
  loadTemplate(id) { }
  initBuilder() { }
  trackChanges() { }
  confirmClose() { }
}
```

## Data Models

### Template Data Structure

```javascript
{
  id: number,
  name: string,
  description: string,
  grid_type: string,  // '1-col', '2-col', '2x2', etc
  grid_config: {
    columns: number,
    rows: number,
    areas: string[]
  },
  elements: [
    {
      area: string,
      type: string,  // 'text', 'color', 'image'
      content: any,
      styles: object
    }
  ],
  is_active: boolean,
  created_by: number
}
```

### Builder State

```javascript
{
  currentGrid: string,
  selectedArea: string,
  elements: array,
  history: array,  // For undo/redo
  historyIndex: number
}
```

## API Endpoints

### Existing Endpoints (Reuse)

```
POST   /admin/templates          - Create template
PUT    /admin/templates/{id}     - Update template
GET    /admin/templates/{id}/edit - Get template data
POST   /admin/templates/upload-image - Upload image
```

### Response Format

```json
{
  "success": true,
  "message": "Template saved successfully",
  "template": {
    "id": 1,
    "name": "Template Name",
    ...
  }
}
```

## Interaction Flow

### Create New Template Flow

```
1. User clicks "+ Tambah Template"
   ↓
2. JavaScript: builderModal.open('create')
   ↓
3. Show overlay + slide modal from right
   ↓
4. Initialize empty builder
   ↓
5. User designs template
   ↓
6. User clicks "Simpan"
   ↓
7. JavaScript: builderModal.save()
   ↓
8. AJAX POST to /admin/templates
   ↓
9. On success: Close modal + reload template list
   ↓
10. Show success message
```

### Edit Template Flow

```
1. User clicks "Edit" on template card
   ↓
2. JavaScript: builderModal.open('edit', templateId)
   ↓
3. Show overlay + slide modal from right
   ↓
4. AJAX GET template data
   ↓
5. Populate builder with template data
   ↓
6. User edits template
   ↓
7. User clicks "Simpan"
   ↓
8. JavaScript: builderModal.save()
   ↓
9. AJAX PUT to /admin/templates/{id}
   ↓
10. On success: Close modal + reload template list
```

### Close Modal Flow

```
1. User clicks "Kembali" / Overlay / ESC
   ↓
2. Check if hasUnsavedChanges
   ↓
3. If yes: Show confirmation dialog
   ↓
4. If confirmed: Close modal
   ↓
5. Hide overlay + slide modal to right
   ↓
6. Clear builder state
```

## Error Handling

### Save Errors

```javascript
try {
  const response = await fetch('/admin/templates', {
    method: 'POST',
    body: JSON.stringify(data)
  });
  
  if (!response.ok) {
    throw new Error('Save failed');
  }
  
  // Success
  this.close();
  loadTemplates();
  
} catch (error) {
  Swal.fire({
    title: 'Error',
    text: 'Gagal menyimpan template',
    icon: 'error'
  });
}
```

### Load Errors

```javascript
try {
  const response = await fetch(`/admin/templates/${id}/edit`);
  const data = await response.json();
  
  this.populateBuilder(data);
  
} catch (error) {
  Swal.fire({
    title: 'Error',
    text: 'Gagal memuat template',
    icon: 'error'
  });
  this.close();
}
```

## Testing Strategy

### Unit Tests
- Modal open/close functionality
- State management
- Data validation

### Integration Tests
- AJAX save/load
- Template list reload
- Error handling

### Manual Tests
- Click "+ Tambah Template" → Modal opens
- Design template → Save → Modal closes → Template appears
- Click "Edit" → Modal opens with data
- Click overlay → Confirmation if unsaved → Modal closes
- Press ESC → Same as overlay click

## Performance Considerations

### Lazy Loading
- Builder content loaded only when modal opens
- Images loaded on-demand

### Debouncing
- Auto-save draft debounced to 30 seconds
- Change tracking debounced to 500ms

### Memory Management
- Clear builder state on close
- Remove event listeners on close
- Clear localStorage drafts after save

## Browser Compatibility

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Accessibility

- Modal trap focus when open
- ESC key to close
- ARIA labels for buttons
- Keyboard navigation support

## Security

- CSRF token in all AJAX requests
- Input validation on client and server
- XSS prevention in template name
- File upload validation for images

## Future Enhancements

- Real-time collaboration
- Template versioning
- Template preview in modal
- Drag-and-drop template import
- Template marketplace

## Implementation Notes

- Reuse existing builder JavaScript (`template-builder.js`)
- Maintain backward compatibility with existing routes
- Progressive enhancement approach
- Mobile-first responsive design
