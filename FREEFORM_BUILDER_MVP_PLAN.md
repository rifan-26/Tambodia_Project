# Free-Form Builder MVP - Implementation Plan

## 🎯 MVP Scope (2-3 Days)

### Core Features Only:
1. ✅ Portrait canvas (1080x1920)
2. ✅ Add text element
3. ✅ Add image element  
4. ✅ Drag to move
5. ✅ Resize elements
6. ✅ Delete elements
7. ✅ Save/Load template
8. ✅ Background color

### NOT in MVP (Phase 2):
- ❌ Layers panel
- ❌ Rotation
- ❌ Advanced styling
- ❌ Alignment tools
- ❌ Undo/redo (Fabric.js has built-in)
- ❌ Keyboard shortcuts

---

## 📦 Technology

**Fabric.js 5.3.0** - Canvas manipulation library
- CDN: https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js
- Size: ~200KB (acceptable)
- Features: Drag, resize, rotate out of the box

---

## 🏗️ Implementation Steps

### Step 1: Update Builder Component (30 min)
- Remove grid selector panel
- Add Fabric.js canvas
- Add simple toolbar (Text, Image, Delete)
- Add properties panel (basic)

### Step 2: Initialize Fabric.js (30 min)
- Setup canvas with portrait size
- Configure canvas settings
- Add background color picker

### Step 3: Add Text Element (1 hour)
- Click "Text" button → add text to canvas
- Double-click to edit
- Drag to move
- Resize handles
- Font size, color, alignment

### Step 4: Add Image Element (1 hour)
- Click "Image" button → file picker
- Upload image
- Add to canvas
- Drag to move
- Resize handles

### Step 5: Delete & Selection (30 min)
- Click element to select
- Delete key or button to remove
- Multi-select (Ctrl+Click)

### Step 6: Save/Load (1 hour)
- Export canvas to JSON
- Save to database
- Load from database
- Populate canvas

### Step 7: Integration (1 hour)
- Update modal controller
- Update save method
- Update load method
- Test create & edit flows

### Step 8: Styling & Polish (1 hour)
- Match Tambodia theme
- Responsive canvas
- Loading states
- Error handling

---

## 📊 Total Time Breakdown

| Task | Time |
|------|------|
| Step 1: Component | 30 min |
| Step 2: Fabric.js | 30 min |
| Step 3: Text | 1 hour |
| Step 4: Image | 1 hour |
| Step 5: Delete | 30 min |
| Step 6: Save/Load | 1 hour |
| Step 7: Integration | 1 hour |
| Step 8: Polish | 1 hour |
| **Total** | **6.5 hours** |

**Realistic with breaks**: 1-2 days
**With testing**: 2-3 days

---

## 🚀 Let's Start!

Starting with Step 1: Update Builder Component...
