<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Template Builder - BPS Sumatera Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #092058 0%, #1345BE 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h4 {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
        }

        .builder-container {
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Header */
        .builder-header {
            background: white;
            border-bottom: 2px solid #e0e0e0;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .template-name-input {
            background: white;
            border: 2px solid #e0e0e0;
            color: #333;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 1rem;
            width: 300px;
        }

        .template-name-input:focus {
            outline: none;
            border-color: #1345BE;
        }

        .template-name-input::placeholder {
            color: #999;
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Main Content */
        .builder-main {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* Grid Selector Panel */
        .grid-selector-panel {
            width: 250px;
            background: white;
            border-right: 1px solid #e0e0e0;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .panel-title {
            font-size: 0.875rem;
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
            border-color: #1345BE;
            background: #f0f4ff;
        }

        .grid-option.active {
            border-color: #1345BE;
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

        /* Canvas Area */
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
        }

        .toolbar-divider {
            width: 1px;
            height: 24px;
            background: #e0e0e0;
            margin: 0 0.5rem;
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

        .canvas.zoom-50 { transform: scale(0.5); }
        .canvas.zoom-75 { transform: scale(0.75); }
        .canvas.zoom-100 { transform: scale(1); }
        .canvas.zoom-125 { transform: scale(1.25); }
        .canvas.zoom-150 { transform: scale(1.5); }

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
            border-color: #1345BE;
            background: #f0f4ff;
        }

        .canvas-grid-area.selected {
            border-color: #1345BE;
            border-style: solid;
            background: #e8f0ff;
        }

        .area-label {
            color: #999;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Properties Panel */
        .properties-panel {
            width: 300px;
            background: white;
            border-left: 1px solid #e0e0e0;
            overflow-y: auto;
            padding: 1.5rem;
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
            padding: 0.5rem;
            border: 1px solid #d0d0d0;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .color-picker-wrapper {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .color-picker {
            width: 50px;
            height: 40px;
            border: 1px solid #d0d0d0;
            border-radius: 6px;
            cursor: pointer;
        }

        /* Buttons */
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
            border-color: #1345BE;
        }

        .btn-toolbar.active {
            background: #1345BE;
            color: white;
            border-color: #1345BE;
        }

        .btn-primary-custom {
            background: #1345BE;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: #092058;
        }

        .btn-secondary-custom {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #d0d0d0;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary-custom:hover {
            background: #e8eaf0;
            border-color: #1345BE;
        }

        /* Empty State */
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

        /* Element Styles */
        .element-text {
            padding: 10px;
            cursor: move;
            position: relative;
        }

        .element-color {
            width: 100%;
            height: 100%;
            border-radius: 4px;
        }

        .element-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        .element-selected {
            outline: 2px solid #1345BE;
            outline-offset: 2px;
        }

        .delete-element-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.75rem;
        }

        .element-selected .delete-element-btn {
            display: flex;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .builder-container {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>BPS Sumatera Utara</h4>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard.pegawai') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('media.input') }}" class="nav-link">
                    <i class="bi bi-upload"></i>
                    Input Media
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('schedule.index') }}" class="nav-link">
                    <i class="bi bi-calendar3"></i>
                    Jadwal Media
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('layout') }}" class="nav-link active">
                    <i class="bi bi-grid-3x3-gap"></i>
                    Master Layout
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('staff.index') }}" class="nav-link">
                    <i class="bi bi-people"></i>
                    Staff Manager
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
    </div>

    <!-- Builder Container -->
    <div class="builder-container">
        <!-- Header -->
        <div class="builder-header">
            <div class="header-left">
                <a href="{{ route('templates.index') }}" class="btn-secondary-custom">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <input 
                    type="text" 
                    class="template-name-input" 
                    id="templateName" 
                    placeholder="Nama Template..."
                    value="{{ $template->name ?? '' }}"
                >
            </div>
            <div class="header-actions">
                <button class="btn-secondary-custom" id="btnPreview">
                    <i class="bi bi-eye"></i> Preview
                </button>
                <button class="btn-primary-custom" id="btnSave">
                    <i class="bi bi-save"></i> Simpan Template
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="builder-main">
            <!-- Grid Selector Panel -->
            <div class="grid-selector-panel">
                <div class="panel-title">Pilih Grid Layout</div>
                
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

                <div class="grid-option" data-grid-type="3-col">
                    <div class="grid-preview grid-3col">
                        <div class="grid-cell"></div>
                        <div class="grid-cell"></div>
                        <div class="grid-cell"></div>
                    </div>
                    <div class="grid-label">3 Kolom</div>
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
                    <button class="btn-toolbar" id="btnAddText" title="Tambah Teks">
                        <i class="bi bi-fonts"></i> Teks
                    </button>
                    <button class="btn-toolbar" id="btnAddColor" title="Tambah Warna">
                        <i class="bi bi-palette"></i> Warna
                    </button>
                    <button class="btn-toolbar" id="btnAddImage" title="Tambah Gambar">
                        <i class="bi bi-image"></i> Gambar
                    </button>
                    
                    <div class="toolbar-divider"></div>
                    
                    <button class="btn-toolbar" id="btnUndo" title="Undo">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                    <button class="btn-toolbar" id="btnRedo" title="Redo">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                    
                    <div class="toolbar-divider"></div>
                    
                    <select class="property-input" id="zoomLevel" style="width: auto;">
                        <option value="50">50%</option>
                        <option value="75">75%</option>
                        <option value="100" selected>100%</option>
                        <option value="125">125%</option>
                        <option value="150">150%</option>
                    </select>
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

            <!-- Properties Panel -->
            <div class="properties-panel">
                <div class="panel-title">Properties</div>
                
                <div id="propertiesContent">
                    <p class="text-muted" style="font-size: 0.875rem;">
                        Pilih elemen untuk mengedit properties
                    </p>
                </div>
            </div>
        </div>
    </div>

    <input type="file" id="imageUpload" accept="image/*" style="display: none;">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/template-builder.js') }}"></script>
</body>
</html>
