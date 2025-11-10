# New Builder Concept: Free-Form Canvas

## Konsep Baru

### Current Design (Grid-Based)
- ❌ User harus pilih grid preset (1-col, 2-col, 2x2, dll)
- ❌ Elemen terbatas pada grid areas
- ❌ Tidak fleksibel untuk custom layout

### New Design (Free-Form Canvas)
- ✅ Canvas portrait (9:16 ratio, seperti layar TV vertikal)
- ✅ Drag & drop elemen ke posisi manapun
- ✅ Resize elemen secara bebas
- ✅ Rotate, layer management
- ✅ Seperti Canva/Figma tapi simplified

---

## Visual Concept

```
┌─────────────────────────────────────────────────────────┐
│ Toolbar                                                  │
│ [Text] [Image] [Shape] [Color] | [Undo] [Redo] [Zoom]  │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Layers Panel    │    Canvas (Portrait)    │  Properties│
│                  │                          │            │
│  □ Text 1        │  ┌──────────────────┐  │  Position  │
│  □ Image 1       │  │                  │  │  X: 100    │
│  □ Background    │  │   [Text Here]    │  │  Y: 50     │
│                  │  │                  │  │            │
│                  │  │  ┌──────────┐   │  │  Size      │
│                  │  │  │  Image   │   │  │  W: 200    │
│                  │  │  └──────────┘   │  │  H: 150    │
│                  │  │                  │  │            │
│                  │  │                  │  │  Style     │
│                  │  └──────────────────┘  │  Font: ... │
│                  │                          │  Color: ...│
│                  │                          │            │
└─────────────────────────────────────────────────────────┘
```

---

## Features

### 1. Canvas
- **Size**: 1080x1920px (9:16 portrait ratio)
- **Background**: Customizable (color, gradient, image)
- **Zoom**: 25%, 50%, 75%, 100%, 150%, 200%
- **Grid**: Optional snap-to-grid
- **Rulers**: Optional rulers for alignment

### 2. Elements

#### Text Element
- Drag to add
- Resize by dragging corners
- Edit inline (double-click)
- Properties:
  - Font family, size, weight
  - Color, alignment
  - Line height, letter spacing
  - Shadow, stroke

#### Image Element
- Drag to add
- Upload or URL
- Resize & crop
- Properties:
  - Opacity
  - Filters (brightness, contrast, blur)
  - Border radius
  - Shadow

#### Shape Element
- Rectangle, Circle, Triangle
- Drag to add
- Resize & rotate
- Properties:
  - Fill color
  - Border color & width
  - Border radius
  - Shadow

#### Color Block
- Full background or partial
- Gradient support
- Opacity

### 3. Interactions

#### Drag & Drop
```javascript
// Add element
toolbar.addEventListener('click', (e) => {
  if (e.target.matches('[data-tool="text"]')) {
    addTextElement();
  }
});

// Drag element
element.addEventListener('mousedown', startDrag);
document.addEventListener('mousemove', drag);
document.addEventListener('mouseup', stopDrag);
```

#### Resize
```javascript
// Resize handles on corners and edges
element.addEventListener('mousedown', (e) => {
  if (e.target.matches('.resize-handle')) {
    startResize(e);
  }
});
```

#### Select & Multi-Select
```javascript
// Click to select
canvas.addEventListener('click', selectElement);

// Ctrl+Click for multi-select
canvas.addEventListener('click', (e) => {
  if (e.ctrlKey) {
    toggleSelection(element);
  }
});
```

### 4. Layers Panel
- List all elements
- Drag to reorder (z-index)
- Show/hide layers
- Lock layers
- Rename layers

### 5. Properties Panel
- Context-sensitive
- Shows properties of selected element
- Live preview of changes

---

## Data Structure

### Template Data
```javascript
{
  id: 1,
  name: "Template Name",
  canvas: {
    width: 1080,
    height: 1920,
    background: {
      type: "color", // or "gradient" or "image"
      value: "#ffffff"
    }
  },
  elements: [
    {
      id: "elem-1",
      type: "text",
      content: "Hello World",
      position: { x: 100, y: 50 },
      size: { width: 200, height: 50 },
      rotation: 0,
      zIndex: 1,
      styles: {
        fontFamily: "Arial",
        fontSize: 24,
        color: "#000000",
        textAlign: "left"
      }
    },
    {
      id: "elem-2",
      type: "image",
      src: "/path/to/image.jpg",
      position: { x: 50, y: 200 },
      size: { width: 300, height: 200 },
      rotation: 0,
      zIndex: 2,
      styles: {
        opacity: 1,
        borderRadius: 10
      }
    }
  ]
}
```

---

## Implementation Plan

### Phase 1: Canvas Setup
1. Create portrait canvas (1080x1920)
2. Add zoom controls
3. Add background customization
4. Add rulers & grid (optional)

### Phase 2: Basic Elements
1. Text element with drag & drop
2. Image element with upload
3. Shape elements (rectangle, circle)
4. Color blocks

### Phase 3: Interactions
1. Drag to move elements
2. Resize handles
3. Rotation handles
4. Selection (single & multi)

### Phase 4: Layers
1. Layers panel
2. Reorder layers (z-index)
3. Show/hide layers
4. Lock layers

### Phase 5: Properties
1. Properties panel
2. Context-sensitive properties
3. Live preview
4. Undo/redo

### Phase 6: Advanced Features
1. Alignment tools
2. Distribution tools
3. Grouping elements
4. Copy/paste/duplicate
5. Keyboard shortcuts

---

## Technology Stack

### Libraries to Consider

#### Fabric.js (Recommended)
```javascript
// Canvas manipulation library
const canvas = new fabric.Canvas('canvas');

// Add text
const text = new fabric.Text('Hello', {
  left: 100,
  top: 100,
  fontSize: 24
});
canvas.add(text);

// Add image
fabric.Image.fromURL('/image.jpg', (img) => {
  img.set({ left: 50, top: 50 });
  canvas.add(img);
});
```

**Pros**:
- ✅ Built for canvas manipulation
- ✅ Drag, resize, rotate out of the box
- ✅ Good documentation
- ✅ Active community

**Cons**:
- ⚠️ Learning curve
- ⚠️ File size (~200KB)

#### Konva.js (Alternative)
```javascript
const stage = new Konva.Stage({
  container: 'container',
  width: 1080,
  height: 1920
});

const layer = new Konva.Layer();
stage.add(layer);

const text = new Konva.Text({
  x: 100,
  y: 100,
  text: 'Hello',
  fontSize: 24
});
layer.add(text);
```

**Pros**:
- ✅ High performance
- ✅ Good for complex interactions
- ✅ Mobile-friendly

**Cons**:
- ⚠️ Steeper learning curve
- ⚠️ Less examples

#### Custom Implementation
Build from scratch using HTML5 Canvas API

**Pros**:
- ✅ Full control
- ✅ No dependencies
- ✅ Smaller file size

**Cons**:
- ⚠️ More development time
- ⚠️ Need to implement everything
- ⚠️ More bugs to fix

---

## Recommendation

### Use Fabric.js

**Why?**
1. Perfect for this use case
2. Handles drag, resize, rotate automatically
3. Good documentation and examples
4. Active community
5. Proven in production (used by many design tools)

**Implementation**:
```html
<!-- Add Fabric.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

<canvas id="canvas" width="1080" height="1920"></canvas>

<script>
// Initialize canvas
const canvas = new fabric.Canvas('canvas', {
  backgroundColor: '#ffffff'
});

// Add text
function addText() {
  const text = new fabric.IText('Click to edit', {
    left: 100,
    top: 100,
    fontSize: 24,
    fill: '#000000'
  });
  canvas.add(text);
  canvas.setActiveObject(text);
}

// Add image
function addImage(file) {
  const reader = new FileReader();
  reader.onload = (e) => {
    fabric.Image.fromURL(e.target.result, (img) => {
      img.scaleToWidth(300);
      canvas.add(img);
      canvas.setActiveObject(img);
    });
  };
  reader.readAsDataURL(file);
}

// Export to JSON
function saveTemplate() {
  const json = canvas.toJSON();
  // Save to server
}

// Load from JSON
function loadTemplate(json) {
  canvas.loadFromJSON(json, () => {
    canvas.renderAll();
  });
}
</script>
```

---

## Migration Path

### From Current Grid-Based to Free-Form

**Option 1: Replace Completely**
- Remove grid selector
- Remove grid-based logic
- Implement new free-form canvas
- Migrate existing templates (convert grid to absolute positions)

**Option 2: Add as New Mode**
- Keep grid-based mode
- Add "Free-Form" mode toggle
- User can choose which mode to use
- Both modes save to same template structure

**Option 3: Hybrid Approach**
- Start with grid as guide
- Allow breaking out of grid
- Snap-to-grid optional
- Best of both worlds

**Recommendation**: Option 1 (Replace) for cleaner UX

---

## Next Steps

1. **Prototype** - Build simple proof of concept with Fabric.js
2. **Design** - Create detailed UI mockups
3. **Implement** - Build new builder component
4. **Test** - User testing and feedback
5. **Deploy** - Replace old builder

---

## Estimated Timeline

- **Phase 1** (Canvas Setup): 1-2 days
- **Phase 2** (Basic Elements): 2-3 days
- **Phase 3** (Interactions): 2-3 days
- **Phase 4** (Layers): 1-2 days
- **Phase 5** (Properties): 2-3 days
- **Phase 6** (Advanced): 3-5 days

**Total**: 11-18 days (2-3 weeks)

---

## Questions to Clarify

1. **Canvas Size**: 1080x1920 (9:16) atau custom?
2. **Elements**: Text, Image, Shape - ada yang lain?
3. **Export**: PNG, JPG, atau JSON saja?
4. **Collaboration**: Single user atau multi-user?
5. **Templates**: Perlu template library?
6. **Mobile**: Perlu support mobile editing?

---

**Status**: 📋 Concept Document  
**Next**: Prototype with Fabric.js  
**Decision Needed**: Approve concept & choose library
