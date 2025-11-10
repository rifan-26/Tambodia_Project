/**
 * Free-Form Template Builder with Fabric.js
 * Drag & drop canvas-based builder
 */

class FreeFormBuilder {
    constructor() {
        this.canvas = null;
        this.canvasWidth = 1080;
        this.canvasHeight = 1920;
        this.selectedObject = null;
        this.clipboard = null;
        
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.init());
        } else {
            this.init();
        }
    }
    
    init() {
        console.log('Initializing FreeFormBuilder');
        
        // Check if Fabric.js is loaded
        if (typeof fabric === 'undefined') {
            console.error('Fabric.js not loaded!');
            return;
        }
        
        // Initialize canvas
        this.initCanvas();
        
        // Setup event listeners
        this.setupEventListeners();
        
        console.log('FreeFormBuilder initialized');
    }
    
    initCanvas() {
        const canvasEl = document.getElementById('fabricCanvas');
        if (!canvasEl) {
            console.error('Canvas element not found');
            return;
        }
        
        // Initialize Fabric canvas
        this.canvas = new fabric.Canvas('fabricCanvas', {
            width: this.canvasWidth,
            height: this.canvasHeight,
            backgroundColor: '#ffffff'
        });
        
        // Canvas events
        this.canvas.on('selection:created', (e) => this.onObjectSelected(e));
        this.canvas.on('selection:updated', (e) => this.onObjectSelected(e));
        this.canvas.on('selection:cleared', () => this.onObjectDeselected());
        this.canvas.on('object:modified', () => this.onObjectModified());
        this.canvas.on('object:added', () => this.updateLayersList());
        this.canvas.on('object:removed', () => this.updateLayersList());
        
        console.log('Canvas initialized:', this.canvasWidth, 'x', this.canvasHeight);
        
        // Initial layers list
        this.updateLayersList();
    }
    
    setupEventListeners() {
        // Add Text button
        const btnAddText = document.getElementById('btnAddText');
        if (btnAddText) {
            btnAddText.addEventListener('click', () => this.addText());
        }
        
        // Add Image button
        const btnAddImage = document.getElementById('btnAddImage');
        if (btnAddImage) {
            btnAddImage.addEventListener('click', () => this.triggerImageUpload());
        }
        
        // Add Shape dropdown
        const btnAddShape = document.getElementById('btnAddShape');
        const shapeMenu = document.getElementById('shapeMenu');
        if (btnAddShape && shapeMenu) {
            btnAddShape.addEventListener('click', (e) => {
                e.stopPropagation();
                shapeMenu.classList.toggle('show');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', () => {
                shapeMenu.classList.remove('show');
            });
            
            // Shape menu items
            shapeMenu.querySelectorAll('[data-shape]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const shape = e.currentTarget.dataset.shape;
                    this.addShape(shape);
                    shapeMenu.classList.remove('show');
                });
            });
        }
        
        // Copy, Paste, Duplicate, Delete
        const btnCopy = document.getElementById('btnCopy');
        if (btnCopy) btnCopy.addEventListener('click', () => this.copySelected());
        
        const btnPaste = document.getElementById('btnPaste');
        if (btnPaste) btnPaste.addEventListener('click', () => this.pasteObject());
        
        const btnDuplicate = document.getElementById('btnDuplicate');
        if (btnDuplicate) btnDuplicate.addEventListener('click', () => this.duplicateSelected());
        
        const btnDelete = document.getElementById('btnDelete');
        if (btnDelete) btnDelete.addEventListener('click', () => this.deleteSelected());
        
        // Alignment buttons
        const btnAlignLeft = document.getElementById('btnAlignLeft');
        if (btnAlignLeft) btnAlignLeft.addEventListener('click', () => this.alignLeft());
        
        const btnAlignCenter = document.getElementById('btnAlignCenter');
        if (btnAlignCenter) btnAlignCenter.addEventListener('click', () => this.alignCenter());
        
        const btnAlignRight = document.getElementById('btnAlignRight');
        if (btnAlignRight) btnAlignRight.addEventListener('click', () => this.alignRight());
        
        const btnAlignTop = document.getElementById('btnAlignTop');
        if (btnAlignTop) btnAlignTop.addEventListener('click', () => this.alignTop());
        
        const btnAlignMiddle = document.getElementById('btnAlignMiddle');
        if (btnAlignMiddle) btnAlignMiddle.addEventListener('click', () => this.alignMiddle());
        
        const btnAlignBottom = document.getElementById('btnAlignBottom');
        if (btnAlignBottom) btnAlignBottom.addEventListener('click', () => this.alignBottom());
        
        // Layer order
        const btnBringForward = document.getElementById('btnBringForward');
        if (btnBringForward) btnBringForward.addEventListener('click', () => this.bringForward());
        
        const btnSendBackward = document.getElementById('btnSendBackward');
        if (btnSendBackward) btnSendBackward.addEventListener('click', () => this.sendBackward());
        
        // Background color
        const bgColor = document.getElementById('canvasBackground');
        if (bgColor) {
            bgColor.addEventListener('change', (e) => this.setBackgroundColor(e.target.value));
        }
        
        // Grid toggle
        const showGrid = document.getElementById('showGrid');
        if (showGrid) {
            showGrid.addEventListener('change', (e) => this.toggleGrid(e.target.checked));
        }
        
        // Zoom
        const zoomLevel = document.getElementById('zoomLevel');
        if (zoomLevel) {
            zoomLevel.addEventListener('change', (e) => this.setZoom(parseFloat(e.target.value)));
        }
        
        // Image upload
        const imageUpload = document.getElementById('imageUpload');
        if (imageUpload) {
            imageUpload.addEventListener('change', (e) => this.handleImageUpload(e));
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => this.handleKeyboard(e));
    }
    
    addText() {
        const text = new fabric.IText('Double-click to edit', {
            left: 100,
            top: 100,
            fontSize: 40,
            fill: '#000000',
            fontFamily: 'Arial'
        });
        
        this.canvas.add(text);
        this.canvas.setActiveObject(text);
        this.canvas.renderAll();
        
        console.log('Text added');
    }
    
    addShape(shapeType) {
        let shape;
        
        switch(shapeType) {
            case 'rect':
                shape = new fabric.Rect({
                    left: 100,
                    top: 100,
                    width: 200,
                    height: 150,
                    fill: '#6f42c1',
                    stroke: '#000000',
                    strokeWidth: 0
                });
                break;
                
            case 'circle':
                shape = new fabric.Circle({
                    left: 100,
                    top: 100,
                    radius: 75,
                    fill: '#6f42c1',
                    stroke: '#000000',
                    strokeWidth: 0
                });
                break;
                
            case 'triangle':
                shape = new fabric.Triangle({
                    left: 100,
                    top: 100,
                    width: 150,
                    height: 150,
                    fill: '#6f42c1',
                    stroke: '#000000',
                    strokeWidth: 0
                });
                break;
                
            case 'line':
                shape = new fabric.Line([50, 50, 250, 50], {
                    stroke: '#000000',
                    strokeWidth: 3
                });
                break;
        }
        
        if (shape) {
            this.canvas.add(shape);
            this.canvas.setActiveObject(shape);
            this.canvas.renderAll();
            console.log('Shape added:', shapeType);
        }
    }
    
    triggerImageUpload() {
        const imageUpload = document.getElementById('imageUpload');
        if (imageUpload) {
            imageUpload.click();
        }
    }
    
    handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validate file
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar');
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5MB');
            return;
        }
        
        // Read file
        const reader = new FileReader();
        reader.onload = (event) => {
            fabric.Image.fromURL(event.target.result, (img) => {
                // Scale image to fit canvas
                const maxWidth = this.canvasWidth * 0.5;
                const maxHeight = this.canvasHeight * 0.5;
                
                if (img.width > maxWidth) {
                    img.scaleToWidth(maxWidth);
                }
                if (img.height > maxHeight) {
                    img.scaleToHeight(maxHeight);
                }
                
                // Center image
                img.set({
                    left: (this.canvasWidth - img.getScaledWidth()) / 2,
                    top: (this.canvasHeight - img.getScaledHeight()) / 2
                });
                
                this.canvas.add(img);
                this.canvas.setActiveObject(img);
                this.canvas.renderAll();
                
                console.log('Image added');
            });
        };
        reader.readAsDataURL(file);
        
        // Reset input
        e.target.value = '';
    }
    
    deleteSelected() {
        const activeObjects = this.canvas.getActiveObjects();
        if (activeObjects.length > 0) {
            activeObjects.forEach(obj => {
                this.canvas.remove(obj);
            });
            this.canvas.discardActiveObject();
            this.canvas.renderAll();
            
            console.log('Objects deleted:', activeObjects.length);
        }
    }
    
    copySelected() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.clone((cloned) => {
                this.clipboard = cloned;
                console.log('Object copied');
                
                // Enable paste button
                const btnPaste = document.getElementById('btnPaste');
                if (btnPaste) btnPaste.disabled = false;
            });
        }
    }
    
    pasteObject() {
        if (this.clipboard) {
            this.clipboard.clone((clonedObj) => {
                this.canvas.discardActiveObject();
                clonedObj.set({
                    left: clonedObj.left + 20,
                    top: clonedObj.top + 20,
                    evented: true,
                });
                
                if (clonedObj.type === 'activeSelection') {
                    clonedObj.canvas = this.canvas;
                    clonedObj.forEachObject((obj) => {
                        this.canvas.add(obj);
                    });
                    clonedObj.setCoords();
                } else {
                    this.canvas.add(clonedObj);
                }
                
                this.clipboard.top += 20;
                this.clipboard.left += 20;
                this.canvas.setActiveObject(clonedObj);
                this.canvas.requestRenderAll();
                
                console.log('Object pasted');
            });
        }
    }
    
    duplicateSelected() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.clone((cloned) => {
                this.canvas.discardActiveObject();
                cloned.set({
                    left: cloned.left + 20,
                    top: cloned.top + 20,
                    evented: true,
                });
                
                if (cloned.type === 'activeSelection') {
                    cloned.canvas = this.canvas;
                    cloned.forEachObject((obj) => {
                        this.canvas.add(obj);
                    });
                    cloned.setCoords();
                } else {
                    this.canvas.add(cloned);
                }
                
                this.canvas.setActiveObject(cloned);
                this.canvas.requestRenderAll();
                
                console.log('Object duplicated');
            });
        }
    }
    
    // Alignment methods
    alignLeft() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.set({ left: 0 });
            this.canvas.renderAll();
        }
    }
    
    alignCenter() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.set({ left: (this.canvasWidth - activeObject.getScaledWidth()) / 2 });
            this.canvas.renderAll();
        }
    }
    
    alignRight() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.set({ left: this.canvasWidth - activeObject.getScaledWidth() });
            this.canvas.renderAll();
        }
    }
    
    alignTop() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.set({ top: 0 });
            this.canvas.renderAll();
        }
    }
    
    alignMiddle() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.set({ top: (this.canvasHeight - activeObject.getScaledHeight()) / 2 });
            this.canvas.renderAll();
        }
    }
    
    alignBottom() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            activeObject.set({ top: this.canvasHeight - activeObject.getScaledHeight() });
            this.canvas.renderAll();
        }
    }
    
    // Layer order methods
    bringForward() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            this.canvas.bringForward(activeObject);
            this.canvas.renderAll();
        }
    }
    
    sendBackward() {
        const activeObject = this.canvas.getActiveObject();
        if (activeObject) {
            this.canvas.sendBackwards(activeObject);
            this.canvas.renderAll();
        }
    }
    
    toggleGrid(show) {
        // TODO: Implement grid overlay
        console.log('Grid toggle:', show);
    }
    
    setBackgroundColor(color) {
        this.canvas.setBackgroundColor(color, () => {
            this.canvas.renderAll();
        });
        console.log('Background color:', color);
    }
    
    setZoom(zoom) {
        this.canvas.setZoom(zoom);
        this.canvas.renderAll();
        console.log('Zoom:', zoom);
    }
    
    onObjectSelected(e) {
        this.selectedObject = e.selected[0];
        
        // Enable action buttons
        const buttons = ['btnDelete', 'btnCopy', 'btnDuplicate', 
                        'btnAlignLeft', 'btnAlignCenter', 'btnAlignRight',
                        'btnAlignTop', 'btnAlignMiddle', 'btnAlignBottom',
                        'btnBringForward', 'btnSendBackward'];
        
        buttons.forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (btn) btn.disabled = false;
        });
        
        // Update properties panel
        this.updatePropertiesPanel();
        
        // Update layers panel
        this.updateLayersList();
        
        console.log('Object selected:', this.selectedObject.type);
    }
    
    onObjectDeselected() {
        this.selectedObject = null;
        
        // Disable action buttons
        const buttons = ['btnDelete', 'btnCopy', 'btnDuplicate',
                        'btnAlignLeft', 'btnAlignCenter', 'btnAlignRight',
                        'btnAlignTop', 'btnAlignMiddle', 'btnAlignBottom',
                        'btnBringForward', 'btnSendBackward'];
        
        buttons.forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (btn) btn.disabled = true;
        });
        
        // Clear properties panel
        this.clearPropertiesPanel();
        
        // Update layers panel
        this.updateLayersList();
        
        console.log('Object deselected');
    }
    
    onObjectModified() {
        // Update properties panel when object is modified
        if (this.selectedObject) {
            this.updatePropertiesPanel();
        }
    }
    
    updatePropertiesPanel() {
        const panel = document.getElementById('propertiesContent');
        if (!panel || !this.selectedObject) return;
        
        const obj = this.selectedObject;
        let html = '';
        
        if (obj.type === 'i-text' || obj.type === 'text') {
            html = `
                <div class="property-group">
                    <label class="property-label">Text</label>
                    <textarea class="property-input" id="propText" rows="3">${obj.text}</textarea>
                </div>
                <div class="property-group">
                    <label class="property-label">Font Size</label>
                    <input type="number" class="property-input" id="propFontSize" value="${obj.fontSize}" min="8" max="200">
                </div>
                <div class="property-group">
                    <label class="property-label">Color</label>
                    <input type="color" class="property-input" id="propColor" value="${obj.fill}">
                </div>
                <div class="property-group">
                    <label class="property-label">Font Family</label>
                    <select class="property-input" id="propFontFamily">
                        <option value="Arial" ${obj.fontFamily === 'Arial' ? 'selected' : ''}>Arial</option>
                        <option value="Times New Roman" ${obj.fontFamily === 'Times New Roman' ? 'selected' : ''}>Times New Roman</option>
                        <option value="Courier New" ${obj.fontFamily === 'Courier New' ? 'selected' : ''}>Courier New</option>
                        <option value="Georgia" ${obj.fontFamily === 'Georgia' ? 'selected' : ''}>Georgia</option>
                        <option value="Verdana" ${obj.fontFamily === 'Verdana' ? 'selected' : ''}>Verdana</option>
                    </select>
                </div>
            `;
        } else if (obj.type === 'image') {
            html = `
                <div class="property-group">
                    <label class="property-label">Width</label>
                    <input type="number" class="property-input" id="propWidth" value="${Math.round(obj.getScaledWidth())}" min="10">
                </div>
                <div class="property-group">
                    <label class="property-label">Height</label>
                    <input type="number" class="property-input" id="propHeight" value="${Math.round(obj.getScaledHeight())}" min="10">
                </div>
                <div class="property-group">
                    <label class="property-label">Opacity</label>
                    <input type="range" class="property-input" id="propOpacity" value="${obj.opacity}" min="0" max="1" step="0.1">
                </div>
            `;
        }
        
        panel.innerHTML = html;
        
        // Add event listeners for property inputs
        this.setupPropertyListeners();
    }
    
    setupPropertyListeners() {
        // Text properties
        const propText = document.getElementById('propText');
        if (propText) {
            propText.addEventListener('input', (e) => {
                this.selectedObject.set('text', e.target.value);
                this.canvas.renderAll();
            });
        }
        
        const propFontSize = document.getElementById('propFontSize');
        if (propFontSize) {
            propFontSize.addEventListener('input', (e) => {
                this.selectedObject.set('fontSize', parseInt(e.target.value));
                this.canvas.renderAll();
            });
        }
        
        const propColor = document.getElementById('propColor');
        if (propColor) {
            propColor.addEventListener('input', (e) => {
                this.selectedObject.set('fill', e.target.value);
                this.canvas.renderAll();
            });
        }
        
        const propFontFamily = document.getElementById('propFontFamily');
        if (propFontFamily) {
            propFontFamily.addEventListener('change', (e) => {
                this.selectedObject.set('fontFamily', e.target.value);
                this.canvas.renderAll();
            });
        }
        
        // Image properties
        const propWidth = document.getElementById('propWidth');
        if (propWidth) {
            propWidth.addEventListener('input', (e) => {
                this.selectedObject.scaleToWidth(parseInt(e.target.value));
                this.canvas.renderAll();
            });
        }
        
        const propHeight = document.getElementById('propHeight');
        if (propHeight) {
            propHeight.addEventListener('input', (e) => {
                this.selectedObject.scaleToHeight(parseInt(e.target.value));
                this.canvas.renderAll();
            });
        }
        
        const propOpacity = document.getElementById('propOpacity');
        if (propOpacity) {
            propOpacity.addEventListener('input', (e) => {
                this.selectedObject.set('opacity', parseFloat(e.target.value));
                this.canvas.renderAll();
            });
        }
    }
    
    clearPropertiesPanel() {
        const panel = document.getElementById('propertiesContent');
        if (!panel) return;
        
        panel.innerHTML = `
            <div class="empty-state">
                <i class="bi bi-cursor"></i>
                <p>Pilih elemen untuk edit properties</p>
            </div>
        `;
    }
    
    handleKeyboard(e) {
        // Skip if typing in input/textarea
        if (e.target.matches('input, textarea')) return;
        
        // Delete key
        if (e.key === 'Delete' || e.key === 'Backspace') {
            if (this.selectedObject) {
                e.preventDefault();
                this.deleteSelected();
            }
        }
        
        // Ctrl/Cmd shortcuts
        if (e.ctrlKey || e.metaKey) {
            switch(e.key.toLowerCase()) {
                case 'c':
                    e.preventDefault();
                    this.copySelected();
                    break;
                case 'v':
                    e.preventDefault();
                    this.pasteObject();
                    break;
                case 'd':
                    e.preventDefault();
                    this.duplicateSelected();
                    break;
                case 'z':
                    // Undo (Fabric.js built-in)
                    break;
                case 'y':
                    // Redo (Fabric.js built-in)
                    break;
            }
        }
        
        // Arrow keys to move selected object
        if (this.selectedObject && ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
            e.preventDefault();
            const step = e.shiftKey ? 10 : 1;
            
            switch(e.key) {
                case 'ArrowUp':
                    this.selectedObject.set({ top: this.selectedObject.top - step });
                    break;
                case 'ArrowDown':
                    this.selectedObject.set({ top: this.selectedObject.top + step });
                    break;
                case 'ArrowLeft':
                    this.selectedObject.set({ left: this.selectedObject.left - step });
                    break;
                case 'ArrowRight':
                    this.selectedObject.set({ left: this.selectedObject.left + step });
                    break;
            }
            
            this.canvas.renderAll();
        }
    }
    
    updateLayersList() {
        const layersList = document.getElementById('layersList');
        if (!layersList) return;
        
        const objects = this.canvas.getObjects();
        
        if (objects.length === 0) {
            layersList.innerHTML = `
                <div class="empty-state-small">
                    <p>No layers yet</p>
                </div>
            `;
            return;
        }
        
        let html = '';
        objects.reverse().forEach((obj, index) => {
            const realIndex = objects.length - 1 - index;
            const isActive = obj === this.selectedObject;
            const icon = this.getLayerIcon(obj.type);
            const name = this.getLayerName(obj, realIndex);
            
            html += `
                <div class="layer-item ${isActive ? 'active' : ''}" data-index="${realIndex}">
                    <i class="bi ${icon} layer-icon"></i>
                    <span class="layer-name">${name}</span>
                    <div class="layer-actions">
                        <button class="layer-action-btn" title="Delete" data-action="delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        layersList.innerHTML = html;
        
        // Add click handlers
        layersList.querySelectorAll('.layer-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (!e.target.closest('.layer-action-btn')) {
                    const index = parseInt(item.dataset.index);
                    const obj = this.canvas.getObjects()[index];
                    this.canvas.setActiveObject(obj);
                    this.canvas.renderAll();
                }
            });
            
            const deleteBtn = item.querySelector('[data-action="delete"]');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const index = parseInt(item.dataset.index);
                    const obj = this.canvas.getObjects()[index];
                    this.canvas.remove(obj);
                    this.canvas.renderAll();
                    this.updateLayersList();
                });
            }
        });
    }
    
    getLayerIcon(type) {
        const icons = {
            'i-text': 'bi-fonts',
            'text': 'bi-fonts',
            'image': 'bi-image',
            'rect': 'bi-square',
            'circle': 'bi-circle',
            'triangle': 'bi-triangle',
            'line': 'bi-dash-lg'
        };
        return icons[type] || 'bi-square';
    }
    
    getLayerName(obj, index) {
        if (obj.type === 'i-text' || obj.type === 'text') {
            return obj.text.substring(0, 20) + (obj.text.length > 20 ? '...' : '');
        }
        return `${obj.type.charAt(0).toUpperCase() + obj.type.slice(1)} ${index + 1}`;
    }
    
    // Export canvas to JSON
    toJSON() {
        if (!this.canvas) return null;
        
        return {
            canvas: {
                width: this.canvasWidth,
                height: this.canvasHeight,
                backgroundColor: this.canvas.backgroundColor
            },
            objects: this.canvas.toJSON().objects
        };
    }
    
    // Load canvas from JSON
    fromJSON(data) {
        if (!this.canvas || !data) return;
        
        // Set canvas properties
        if (data.canvas) {
            this.canvas.setBackgroundColor(data.canvas.backgroundColor || '#ffffff', () => {
                this.canvas.renderAll();
            });
        }
        
        // Load objects
        if (data.objects && Array.isArray(data.objects)) {
            this.canvas.clear();
            this.canvas.loadFromJSON({ objects: data.objects }, () => {
                this.canvas.renderAll();
                console.log('Canvas loaded from JSON');
            });
        }
    }
    
    // Clear canvas
    clear() {
        if (this.canvas) {
            this.canvas.clear();
            this.canvas.setBackgroundColor('#ffffff', () => {
                this.canvas.renderAll();
            });
        }
    }
}

// Initialize builder
window.freeFormBuilder = new FreeFormBuilder();
