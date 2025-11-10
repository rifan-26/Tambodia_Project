{{-- Free-Form Template Builder Component --}}
{{-- Canvas-based builder with drag & drop functionality --}}

<div class="builder-main-content">
    <!-- Toolbar -->
    <div class="builder-toolbar">
        <!-- Add Elements -->
        <div class="toolbar-section">
            <button class="btn-tool" id="btnAddText" title="Tambah Teks">
                <i class="bi bi-fonts"></i>
                <span>Text</span>
            </button>
            <button class="btn-tool" id="btnAddImage" title="Tambah Gambar">
                <i class="bi bi-image"></i>
                <span>Image</span>
            </button>
            <div class="btn-tool-dropdown">
                <button class="btn-tool" id="btnAddShape" title="Tambah Shape">
                    <i class="bi bi-square"></i>
                    <span>Shape</span>
                    <i class="bi bi-chevron-down" style="font-size: 0.7rem; margin-left: 0.25rem;"></i>
                </button>
                <div class="dropdown-menu" id="shapeMenu">
                    <button class="dropdown-item" data-shape="rect">
                        <i class="bi bi-square"></i> Rectangle
                    </button>
                    <button class="dropdown-item" data-shape="circle">
                        <i class="bi bi-circle"></i> Circle
                    </button>
                    <button class="dropdown-item" data-shape="triangle">
                        <i class="bi bi-triangle"></i> Triangle
                    </button>
                    <button class="dropdown-item" data-shape="line">
                        <i class="bi bi-dash-lg"></i> Line
                    </button>
                </div>
            </div>
        </div>
        
        <div class="toolbar-divider"></div>
        
        <!-- Edit Actions -->
        <div class="toolbar-section">
            <button class="btn-tool" id="btnCopy" title="Copy (Ctrl+C)" disabled>
                <i class="bi bi-files"></i>
            </button>
            <button class="btn-tool" id="btnPaste" title="Paste (Ctrl+V)" disabled>
                <i class="bi bi-clipboard"></i>
            </button>
            <button class="btn-tool" id="btnDuplicate" title="Duplicate (Ctrl+D)" disabled>
                <i class="bi bi-back"></i>
            </button>
            <button class="btn-tool" id="btnDelete" title="Delete (Del)" disabled>
                <i class="bi bi-trash"></i>
            </button>
        </div>
        
        <div class="toolbar-divider"></div>
        
        <!-- Alignment -->
        <div class="toolbar-section">
            <button class="btn-tool btn-tool-sm" id="btnAlignLeft" title="Align Left" disabled>
                <i class="bi bi-align-start"></i>
            </button>
            <button class="btn-tool btn-tool-sm" id="btnAlignCenter" title="Align Center" disabled>
                <i class="bi bi-align-center"></i>
            </button>
            <button class="btn-tool btn-tool-sm" id="btnAlignRight" title="Align Right" disabled>
                <i class="bi bi-align-end"></i>
            </button>
            <button class="btn-tool btn-tool-sm" id="btnAlignTop" title="Align Top" disabled>
                <i class="bi bi-align-top"></i>
            </button>
            <button class="btn-tool btn-tool-sm" id="btnAlignMiddle" title="Align Middle" disabled>
                <i class="bi bi-align-middle"></i>
            </button>
            <button class="btn-tool btn-tool-sm" id="btnAlignBottom" title="Align Bottom" disabled>
                <i class="bi bi-align-bottom"></i>
            </button>
        </div>
        
        <div class="toolbar-divider"></div>
        
        <!-- Layer Order -->
        <div class="toolbar-section">
            <button class="btn-tool btn-tool-sm" id="btnBringForward" title="Bring Forward" disabled>
                <i class="bi bi-arrow-up"></i>
            </button>
            <button class="btn-tool btn-tool-sm" id="btnSendBackward" title="Send Backward" disabled>
                <i class="bi bi-arrow-down"></i>
            </button>
        </div>
        
        <div class="toolbar-divider"></div>
        
        <!-- Canvas Settings -->
        <div class="toolbar-section">
            <label class="toolbar-label">BG:</label>
            <input type="color" id="canvasBackground" value="#ffffff" class="color-input" title="Background Color">
            <label class="toolbar-checkbox">
                <input type="checkbox" id="showGrid">
                <span>Grid</span>
            </label>
        </div>
        
        <div class="toolbar-divider"></div>
        
        <!-- Zoom -->
        <div class="toolbar-section">
            <select id="zoomLevel" class="zoom-select">
                <option value="0.25">25%</option>
                <option value="0.5">50%</option>
                <option value="0.75">75%</option>
                <option value="1" selected>100%</option>
                <option value="1.25">125%</option>
                <option value="1.5">150%</option>
            </select>
        </div>
    </div>

    <!-- Canvas Area -->
    <div class="canvas-container">
        <!-- Layers Panel -->
        <div class="layers-panel">
            <div class="panel-title">Layers</div>
            <div class="layers-list" id="layersList">
                <div class="empty-state-small">
                    <p>No layers yet</p>
                </div>
            </div>
        </div>
        
        <!-- Canvas -->
        <div class="canvas-wrapper-scroll">
            <canvas id="fabricCanvas"></canvas>
        </div>
    </div>

    <!-- Properties Panel -->
    <div class="properties-panel">
        <div class="panel-title">Properties</div>
        
        <div id="propertiesContent" class="properties-content">
            <div class="empty-state">
                <i class="bi bi-cursor"></i>
                <p>Pilih elemen untuk edit properties</p>
            </div>
        </div>
    </div>
</div>

<!-- Hidden file input for image upload -->
<input type="file" id="imageUpload" accept="image/*" style="display: none;">

<style>
/* Builder Main Content */
.builder-main-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: hidden;
    height: 100%;
    background: #f5f5f5;
}

/* Toolbar */
.builder-toolbar {
    background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
    border-bottom: 1px solid #e8e8e8;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.toolbar-section {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-tool {
    background: white;
    border: 1px solid #e0e0e0;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.btn-tool::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(111, 66, 193, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-tool:hover::before {
    width: 300px;
    height: 300px;
}

.btn-tool:hover:not(:disabled) {
    background: white;
    border-color: #6f42c1;
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.15);
    transform: translateY(-1px);
}

.btn-tool:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(111, 66, 193, 0.2);
}

.btn-tool:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    box-shadow: none;
}

.btn-tool i {
    font-size: 1rem;
}

.toolbar-label {
    font-size: 0.875rem;
    color: #666;
    margin: 0;
}

.color-input {
    width: 40px;
    height: 32px;
    border: 1px solid #d0d0d0;
    border-radius: 4px;
    cursor: pointer;
}

.zoom-select {
    padding: 0.4rem 0.75rem;
    border: 1px solid #d0d0d0;
    border-radius: 6px;
    font-size: 0.875rem;
    background: white;
    cursor: pointer;
}

/* Canvas Container */
.canvas-container {
    flex: 1;
    display: flex;
    overflow: hidden;
    background: linear-gradient(135deg, #e8eaf0 0%, #f0f2f5 50%, #e8eaf0 100%);
    position: relative;
}

.canvas-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(111, 66, 193, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 50%, rgba(111, 66, 193, 0.03) 0%, transparent 50%);
    pointer-events: none;
}

.canvas-wrapper-scroll {
    flex: 1;
    overflow: auto;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    scroll-behavior: smooth;
}

.canvas-wrapper-scroll::-webkit-scrollbar {
    width: 12px;
    height: 12px;
}

.canvas-wrapper-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 6px;
}

.canvas-wrapper-scroll::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #6f42c1, #8b5cf6);
    border-radius: 6px;
    border: 2px solid #f1f1f1;
}

.canvas-wrapper-scroll::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #5a2d9f, #7c3aed);
}

#fabricCanvas {
    box-shadow: 0 10px 40px rgba(111, 66, 193, 0.15), 
                0 0 0 1px rgba(111, 66, 193, 0.1);
    border-radius: 12px;
    transition: box-shadow 0.3s ease;
}

#fabricCanvas:hover {
    box-shadow: 0 15px 50px rgba(111, 66, 193, 0.2), 
                0 0 0 1px rgba(111, 66, 193, 0.15);
}

.toolbar-divider {
    width: 1px;
    height: 24px;
    background: #e0e0e0;
}

/* Properties Panel */
.properties-panel {
    width: 300px;
    background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
    border-left: 1px solid #e8e8e8;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    box-shadow: -2px 0 8px rgba(0,0,0,0.03);
}

.panel-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: #6f42c1;
    text-transform: uppercase;
    padding: 1.25rem 1.5rem;
    border-bottom: 2px solid #f0f0f0;
    letter-spacing: 1px;
    margin: 0;
    background: linear-gradient(135deg, rgba(111, 66, 193, 0.05) 0%, transparent 100%);
}

.properties-content {
    flex: 1;
    padding: 1.5rem;
}

.empty-state {
    text-align: center;
    color: #999;
    padding: 2rem 1rem;
}

.empty-state i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
}

.property-group {
    margin-bottom: 1.5rem;
}

.property-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    display: block;
}

.property-input {
    width: 100%;
    padding: 0.6rem;
    border: 2px solid #e8e8e8;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    background: white;
}

.property-input:hover {
    border-color: #d0d0d0;
}

.property-input:focus {
    outline: none;
    border-color: #6f42c1;
    box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1);
    transform: translateY(-1px);
}



/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c0c0c0;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a0a0a0;
}

/* Responsive */
@media (max-width: 1024px) {
    .properties-panel {
        width: 250px;
    }
    
    .btn-tool span {
        display: none;
    }
}

@media (max-width: 768px) {
    .builder-main-content {
        flex-direction: column;
    }
    
    .canvas-container {
        flex-direction: column;
    }
    
    .properties-panel {
        width: 100%;
        max-height: 200px;
        border-left: none;
        border-top: 1px solid #e0e0e0;
    }
    
    .builder-toolbar {
        flex-wrap: wrap;
    }
    
    .layers-panel {
        display: none;
    }
}

/* Additional Styles for New Features */

/* Layers Panel */
.layers-panel {
    width: 240px;
    background: linear-gradient(to bottom, #ffffff 0%, #fafbfc 100%);
    border-right: 1px solid #e8e8e8;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 8px rgba(0,0,0,0.03);
}

.layers-list {
    flex: 1;
    overflow-y: auto;
    padding: 0.5rem;
}

.layer-item {
    padding: 0.65rem;
    margin-bottom: 0.4rem;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.layer-item:hover {
    background: #f8f9ff;
    border-color: #6f42c1;
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.1);
}

.layer-item.active {
    background: linear-gradient(135deg, #e8f0ff 0%, #f0e8ff 100%);
    border-color: #6f42c1;
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.15);
    transform: translateX(4px);
}

.layer-icon {
    font-size: 1rem;
    color: #666;
}

.layer-name {
    flex: 1;
    font-size: 0.875rem;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.layer-actions {
    display: flex;
    gap: 0.25rem;
}

.layer-action-btn {
    background: none;
    border: none;
    padding: 0.25rem;
    cursor: pointer;
    color: #666;
    font-size: 0.875rem;
}

.layer-action-btn:hover {
    color: #6f42c1;
}

.empty-state-small {
    text-align: center;
    padding: 2rem 1rem;
    color: #999;
}

.empty-state-small p {
    font-size: 0.875rem;
    margin: 0;
}

/* Dropdown Menu */
.btn-tool-dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.05);
    min-width: 180px;
    z-index: 1000;
    display: none;
    margin-top: 0.5rem;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.dropdown-menu.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.dropdown-item {
    width: 100%;
    padding: 0.65rem 1.25rem;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    color: #333;
    transition: all 0.2s ease;
    position: relative;
}

.dropdown-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #6f42c1;
    transform: scaleY(0);
    transition: transform 0.2s ease;
}

.dropdown-item:hover {
    background: linear-gradient(90deg, rgba(111, 66, 193, 0.08) 0%, transparent 100%);
    padding-left: 1.5rem;
}

.dropdown-item:hover::before {
    transform: scaleY(1);
}

.dropdown-item i {
    font-size: 1rem;
}

/* Small Tool Buttons */
.btn-tool-sm {
    padding: 0.4rem 0.6rem;
}

.btn-tool-sm span {
    display: none;
}

/* Toolbar Checkbox */
.toolbar-checkbox {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #666;
    cursor: pointer;
    margin: 0;
}

.toolbar-checkbox input[type="checkbox"] {
    cursor: pointer;
}

.toolbar-checkbox span {
    user-select: none;
}
</style>
