<div class="builder-interface">
    <!-- Grid Selector Panel -->
    <div class="grid-selector-panel">
        <div class="panel-title">PILIH GRID LAYOUT</div>
        
        <div class="grid-option" data-grid-type="1-col">
            <div class="grid-preview grid-1col">
                <div class="grid-cell"></div>
            </div>
            <div class="grid-label">1 Kolom</div>
        </div>

        <div class="grid-option" data-grid-type="2-col">
            <div class="grid-preview grid-2col">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
            <div class="grid-label">2 Kolom</div>
        </div>

        <div class="grid-option active" data-grid-type="2x2">
            <div class="grid-preview grid-2x2">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
            <div class="grid-label">Grid 2x2</div>
        </div>

        <div class="grid-option" data-grid-type="3x3">
            <div class="grid-preview grid-3x3">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
            <div class="grid-label">Grid 3x3</div>
        </div>
    </div>

    <!-- Canvas Area -->
    <div class="canvas-area">
        <div class="canvas-toolbar">
            <button class="btn-toolbar" id="btnAddText">
                <i class="bi bi-fonts"></i> Teks
            </button>
            <button class="btn-toolbar" id="btnAddColor">
                <i class="bi bi-palette"></i> Warna
            </button>
            <button class="btn-toolbar" id="btnAddImage">
                <i class="bi bi-image"></i> Gambar
            </button>
            
            <div class="toolbar-divider"></div>
            
            <button class="btn-toolbar" id="btnUndo">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
            <button class="btn-toolbar" id="btnRedo">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>

        <div class="canvas-wrapper">
            <div class="canvas zoom-100" id="canvas">
                <div class="empty-canvas">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <h4>Pilih Grid Layout</h4>
                    <p>Pilih grid layout dari panel kiri untuk memulai</p>
                </div>
            </div>
        </div>
    </div>

</div>

<input type="file" id="imageUpload" accept="image/*" style="display: none;">

<style>
/* Builder Interface Styles */
.builder-interface {
    display: flex;
    height: 100%;
    background: #e8eaf0;
}

.grid-selector-panel {
    width: 250px;
    background: white;
    border-right: 1px solid #e0e0e0;
    overflow-y: auto;
    padding: 1.5rem;
    flex-shrink: 0;
}

.panel-title {
    font-size: 0.75rem;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    margin-bottom: 1rem;
    letter-spacing: 0.5px;
}

.grid-option {
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.grid-option:hover {
    border-color: var(--primary);
    background: #f0f4ff;
}

.grid-option.active {
    border-color: var(--primary);
    background: #e8f0ff;
}

.grid-preview {
    width: 100%;
    height: 80px;
    background: white;
    border-radius: 4px;
    margin-bottom: 0.5rem;
    display: grid;
    gap: 4px;
    padding: 8px;
}

.grid-preview.grid-1col {
    grid-template-columns: 1fr;
}

.grid-preview.grid-2col {
    grid-template-columns: 1fr 1fr;
}

.grid-preview.grid-3col {
    grid-template-columns: 1fr 1fr 1fr;
}

.grid-preview.grid-2x2 {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
}

.grid-preview.grid-3x3 {
    grid-template-columns: 1fr 1fr 1fr;
    grid-template-rows: 1fr 1fr 1fr;
}

.grid-cell {
    background: #e0e0e0;
    border-radius: 2px;
}

.grid-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #333;
    text-align: center;
}

.canvas-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #e8eaf0;
    overflow: hidden;
}

.canvas-toolbar {
    background: white;
    border-bottom: 1px solid #e0e0e0;
    padding: 0.75rem 1.5rem;
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-shrink: 0;
}

.toolbar-divider {
    width: 1px;
    height: 24px;
    background: #e0e0e0;
    margin: 0 0.5rem;
}

.btn-toolbar {
    background: white;
    border: 1px solid #d0d0d0;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-toolbar:hover {
    background: #f8f9fa;
    border-color: var(--primary);
}

.btn-toolbar.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.canvas-wrapper {
    flex: 1;
    overflow: auto;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.canvas {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    min-width: 800px;
    min-height: 600px;
    position: relative;
    display: grid;
    gap: 12px;
    padding: 20px;
}

.canvas-grid-area {
    background: #f8f9fa;
    border: 2px dashed #d0d0d0;
    border-radius: 6px;
    position: relative;
    min-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.canvas-grid-area:hover {
    border-color: var(--primary);
    background: #f0f4ff;
}

.canvas-grid-area.selected {
    border-color: var(--primary);
    border-style: solid;
    background: #e8f0ff;
}

.area-label {
    color: #999;
    font-size: 0.875rem;
    font-weight: 500;
}

.empty-canvas {
    text-align: center;
    color: #999;
    padding: 3rem;
}

.empty-canvas i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* Properties panel removed */
</style>
