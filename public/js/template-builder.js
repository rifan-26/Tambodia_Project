/**
 * Template Builder JavaScript
 * Handles all template builder functionality
 */

class TemplateBuilder {
    constructor() {
        this.canvas = document.getElementById('canvas');
        this.gridConfig = null;
        this.elements = [];
        this.selectedElement = null;
        this.selectedGridArea = null;
        this.history = [];
        this.historyIndex = -1;
        this.currentMode = null; // 'text', 'color', 'image'
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadDefaultGrid();
    }

    setupEventListeners() {
        // Grid selector
        document.querySelectorAll('.grid-option').forEach(option => {
            option.addEventListener('click', (e) => {
                const gridType = e.currentTarget.dataset.gridType;
                this.selectGrid(gridType);
            });
        });

        // Toolbar buttons
        document.getElementById('btnAddText').addEventListener('click', () => this.setMode('text'));
        document.getElementById('btnAddColor').addEventListener('click', () => this.setMode('color'));
        document.getElementById('btnAddImage').addEventListener('click', () => this.setMode('image'));
        document.getElementById('btnUndo').addEventListener('click', () => this.undo());
        document.getElementById('btnRedo').addEventListener('click', () => this.redo());
        
        // Zoom
        document.getElementById('zoomLevel').addEventListener('change', (e) => {
            this.setZoom(e.target.value);
        });

        // Save button
        document.getElementById('btnSave').addEventListener('click', () => this.save());

        // Image upload
        document.getElementById('imageUpload').addEventListener('change', (e) => {
            this.handleImageUpload(e);
        });
    }

    loadDefaultGrid() {
        this.selectGrid('2x2');
    }

    selectGrid(gridType) {
        // Update active state
        document.querySelectorAll('.grid-option').forEach(opt => opt.classList.remove('active'));
        document.querySelector(`[data-grid-type="${gridType}"]`).classList.add('active');

        // Generate grid config
        this.gridConfig = this.generateGridConfig(gridType);
        
        // Render grid
        this.renderGrid();
        
        // Add to history
        this.addToHistory();
    }

    generateGridConfig(gridType) {
        const configs = {
            '1-col': {
                type: '1-col',
                rows: 1,
                columns: 1,
                areas: [
                    { id: 1, row: 1, col: 1, rowSpan: 1, colSpan: 1 }
                ],
                gap: '20px',
                padding: '30px'
            },
            '2-col': {
                type: '2-col',
                rows: 1,
                columns: 2,
                areas: [
                    { id: 1, row: 1, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 2, row: 1, col: 2, rowSpan: 1, colSpan: 1 }
                ],
                gap: '20px',
                padding: '30px'
            },
            '3-col': {
                type: '3-col',
                rows: 1,
                columns: 3,
                areas: [
                    { id: 1, row: 1, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 2, row: 1, col: 2, rowSpan: 1, colSpan: 1 },
                    { id: 3, row: 1, col: 3, rowSpan: 1, colSpan: 1 }
                ],
                gap: '20px',
                padding: '30px'
            },
            '2x2': {
                type: '2x2',
                rows: 2,
                columns: 2,
                areas: [
                    { id: 1, row: 1, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 2, row: 1, col: 2, rowSpan: 1, colSpan: 1 },
                    { id: 3, row: 2, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 4, row: 2, col: 2, rowSpan: 1, colSpan: 1 }
                ],
                gap: '20px',
                padding: '30px'
            },
            '3x3': {
                type: '3x3',
                rows: 3,
                columns: 3,
                areas: [
                    { id: 1, row: 1, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 2, row: 1, col: 2, rowSpan: 1, colSpan: 1 },
                    { id: 3, row: 1, col: 3, rowSpan: 1, colSpan: 1 },
                    { id: 4, row: 2, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 5, row: 2, col: 2, rowSpan: 1, colSpan: 1 },
                    { id: 6, row: 2, col: 3, rowSpan: 1, colSpan: 1 },
                    { id: 7, row: 3, col: 1, rowSpan: 1, colSpan: 1 },
                    { id: 8, row: 3, col: 2, rowSpan: 1, colSpan: 1 },
                    { id: 9, row: 3, col: 3, rowSpan: 1, colSpan: 1 }
                ],
                gap: '15px',
                padding: '30px'
            }
        };

        return configs[gridType] || configs['2x2'];
    }

    renderGrid() {
        if (!this.gridConfig) return;

        // Clear canvas
        this.canvas.innerHTML = '';

        // Set grid styles
        this.canvas.style.display = 'grid';
        this.canvas.style.gridTemplateColumns = `repeat(${this.gridConfig.columns}, 1fr)`;
        this.canvas.style.gridTemplateRows = `repeat(${this.gridConfig.rows}, 1fr)`;
        this.canvas.style.gap = this.gridConfig.gap;
        this.canvas.style.padding = this.gridConfig.padding;

        // Create grid areas
        this.gridConfig.areas.forEach(area => {
            const gridArea = document.createElement('div');
            gridArea.className = 'canvas-grid-area';
            gridArea.dataset.areaId = area.id;
            gridArea.style.gridColumn = `${area.col} / span ${area.colSpan}`;
            gridArea.style.gridRow = `${area.row} / span ${area.rowSpan}`;
            
            const label = document.createElement('div');
            label.className = 'area-label';
            label.textContent = `Area ${area.id}`;
            gridArea.appendChild(label);

            // Click handler
            gridArea.addEventListener('click', (e) => {
                if (e.target === gridArea || e.target === label) {
                    this.selectGridArea(area.id);
                }
            });

            this.canvas.appendChild(gridArea);
        });

        // Render existing elements
        this.renderElements();
    }

    selectGridArea(areaId) {
        // Deselect all areas
        document.querySelectorAll('.canvas-grid-area').forEach(area => {
            area.classList.remove('selected');
        });

        // Select this area
        const area = document.querySelector(`[data-area-id="${areaId}"]`);
        if (area) {
            area.classList.add('selected');
            this.selectedGridArea = areaId;

            // If mode is active, add element
            if (this.currentMode) {
                this.addElementToArea(areaId);
            }
        }
    }

    setMode(mode) {
        this.currentMode = mode;
        
        // Update toolbar buttons
        document.querySelectorAll('.btn-toolbar').forEach(btn => btn.classList.remove('active'));
        
        if (mode === 'text') {
            document.getElementById('btnAddText').classList.add('active');
        } else if (mode === 'color') {
            document.getElementById('btnAddColor').classList.add('active');
        } else if (mode === 'image') {
            document.getElementById('btnAddImage').classList.add('active');
        }

        // Show instruction
        Swal.fire({
            title: `Mode: ${mode.toUpperCase()}`,
            text: 'Klik pada area grid untuk menambahkan elemen',
            icon: 'info',
            timer: 2000,
            showConfirmButton: false
        });
    }

    addElementToArea(areaId) {
        if (!this.currentMode) return;

        if (this.currentMode === 'text') {
            this.addTextElement(areaId);
        } else if (this.currentMode === 'color') {
            this.addColorElement(areaId);
        } else if (this.currentMode === 'image') {
            document.getElementById('imageUpload').click();
            this.pendingImageArea = areaId;
        }

        // Reset mode
        this.currentMode = null;
        document.querySelectorAll('.btn-toolbar').forEach(btn => btn.classList.remove('active'));
    }

    addTextElement(areaId) {
        const element = {
            id: `elem-${Date.now()}`,
            type: 'text',
            gridArea: areaId,
            content: 'Teks Baru',
            styles: {
                fontSize: '18px',
                color: '#333333',
                fontWeight: 'normal',
                textAlign: 'center',
                padding: '20px'
            }
        };

        this.elements.push(element);
        this.renderElements();
        this.addToHistory();
    }

    addColorElement(areaId) {
        const element = {
            id: `elem-${Date.now()}`,
            type: 'color',
            gridArea: areaId,
            styles: {
                backgroundColor: '#1345BE',
                opacity: 1
            }
        };

        this.elements.push(element);
        this.renderElements();
        this.addToHistory();
    }

    handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file
        if (!file.type.startsWith('image/')) {
            Swal.fire('Error', 'File harus berupa gambar', 'error');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            Swal.fire('Error', 'Ukuran file maksimal 5MB', 'error');
            return;
        }

        // Upload image
        const formData = new FormData();
        formData.append('image', file);

        fetch('/api/templates/upload-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.addImageElement(this.pendingImageArea, data.path, data.mediaId);
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Gagal upload gambar', 'error');
        });
    }

    addImageElement(areaId, imagePath, mediaId) {
        const element = {
            id: `elem-${Date.now()}`,
            type: 'image',
            gridArea: areaId,
            mediaId: mediaId,
            imagePath: imagePath,
            styles: {
                objectFit: 'cover',
                objectPosition: 'center',
                opacity: 1
            }
        };

        this.elements.push(element);
        this.renderElements();
        this.addToHistory();
    }

    renderElements() {
        // Clear existing elements from grid areas
        document.querySelectorAll('.canvas-grid-area').forEach(area => {
            const areaId = parseInt(area.dataset.areaId);
            const areaElements = this.elements.filter(el => el.gridArea === areaId);
            
            // Clear area content except label
            const label = area.querySelector('.area-label');
            area.innerHTML = '';
            
            if (areaElements.length === 0) {
                area.appendChild(label);
            } else {
                // Render elements
                areaElements.forEach(element => {
                    const elementDiv = this.createElementDiv(element);
                    area.appendChild(elementDiv);
                });
            }
        });
    }

    createElementDiv(element) {
        const div = document.createElement('div');
        div.dataset.elementId = element.id;
        div.style.width = '100%';
        div.style.height = '100%';
        div.style.position = 'relative';

        if (element.type === 'text') {
            div.className = 'element-text';
            div.contentEditable = true;
            div.textContent = element.content;
            Object.assign(div.style, element.styles);
            
            div.addEventListener('blur', (e) => {
                element.content = e.target.textContent;
                this.addToHistory();
            });
        } else if (element.type === 'color') {
            div.className = 'element-color';
            Object.assign(div.style, element.styles);
        } else if (element.type === 'image') {
            const img = document.createElement('img');
            img.src = element.imagePath;
            img.className = 'element-image';
            Object.assign(img.style, element.styles);
            div.appendChild(img);
        }

        // Selection handler
        div.addEventListener('click', (e) => {
            e.stopPropagation();
            this.selectElement(element.id);
        });

        // Delete button
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'delete-element-btn';
        deleteBtn.innerHTML = '<i class="bi bi-x"></i>';
        deleteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.deleteElement(element.id);
        });
        div.appendChild(deleteBtn);

        return div;
    }

    selectElement(elementId) {
        this.selectedElement = elementId;
        
        // Update UI
        document.querySelectorAll('[data-element-id]').forEach(el => {
            el.classList.remove('element-selected');
        });
        
        const elementDiv = document.querySelector(`[data-element-id="${elementId}"]`);
        if (elementDiv) {
            elementDiv.classList.add('element-selected');
        }

        // Properties panel removed - no longer needed
        // this.showElementProperties(elementId);
    }

    showElementProperties(elementId) {
        // Properties panel removed - function disabled
        return;
    }

    deleteElement(elementId) {
        this.elements = this.elements.filter(el => el.id !== elementId);
        this.renderElements();
        this.addToHistory();
        
        // Properties panel removed - no longer needed
    }

    setZoom(level) {
        this.canvas.className = `canvas zoom-${level}`;
    }

    addToHistory() {
        const state = {
            gridConfig: JSON.parse(JSON.stringify(this.gridConfig)),
            elements: JSON.parse(JSON.stringify(this.elements))
        };

        // Remove future history if we're not at the end
        if (this.historyIndex < this.history.length - 1) {
            this.history = this.history.slice(0, this.historyIndex + 1);
        }

        this.history.push(state);
        this.historyIndex++;

        // Limit history to 50 states
        if (this.history.length > 50) {
            this.history.shift();
            this.historyIndex--;
        }
    }

    undo() {
        if (this.historyIndex > 0) {
            this.historyIndex--;
            this.restoreState(this.history[this.historyIndex]);
        }
    }

    redo() {
        if (this.historyIndex < this.history.length - 1) {
            this.historyIndex++;
            this.restoreState(this.history[this.historyIndex]);
        }
    }

    restoreState(state) {
        this.gridConfig = state.gridConfig;
        this.elements = state.elements;
        this.renderGrid();
    }

    save() {
        const templateName = document.getElementById('templateName').value.trim();
        
        if (!templateName) {
            Swal.fire('Error', 'Nama template harus diisi', 'error');
            return;
        }

        if (!this.gridConfig) {
            Swal.fire('Error', 'Pilih grid layout terlebih dahulu', 'error');
            return;
        }

        const data = {
            name: templateName,
            grid_type: this.gridConfig.type,
            grid_config: this.gridConfig,
            elements: this.elements
        };

        // Show loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Save to server
        const url = window.location.pathname.includes('/edit/') 
            ? window.location.pathname.replace('/edit', '')
            : '/admin/templates';
        
        const method = window.location.pathname.includes('/edit/') ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Template berhasil disimpan',
                    icon: 'success',
                    timer: 2000
                }).then(() => {
                    window.location.href = '/admin/templates';
                });
            } else {
                Swal.fire('Error', data.message || 'Gagal menyimpan template', 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Gagal menyimpan template', 'error');
        });
    }
}

// Initialize builder when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.builder = new TemplateBuilder();
});
