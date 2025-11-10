<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Master Layout - BPS Sumatera Utara</title>
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
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
        }
        .page-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }
        
        /* Builder Overlay */
        .builder-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .builder-overlay.active {
            display: block;
            opacity: 1;
        }
        
        /* Builder Panel */
        .builder-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: calc(100% - 280px);
            height: 100%;
            background: white;
            z-index: 2001;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .builder-panel.active {
            right: 0;
        }
        
        /* Builder Header */
        .builder-header {
            background: white;
            border-bottom: 2px solid #e0e0e0;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .builder-header-left {
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
        
        /* Builder Content */
        .builder-content {
            flex: 1;
            display: flex;
            overflow: hidden;
        }
        
        /* Buttons */
        .btn-close-builder {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #d0d0d0;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-close-builder:hover {
            background: #e8eaf0;
            border-color: #1345BE;
        }
        .btn-save-template {
            background: #1345BE;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-save-template:hover {
            background: #092058;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .builder-panel {
                width: 100%;
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Master Layout</h1>
            <p class="text-muted mb-0">Pilih atau buat template untuk landing page</p>
        </div>

        <!-- Template Selector Content -->
        @include('components.template-selector-content')
    </div>

    <!-- Builder Overlay -->
    <div class="builder-overlay" id="builderOverlay" onclick="closeBuilder()"></div>

    <!-- Builder Panel -->
    <div class="builder-panel" id="builderPanel">
        <div class="builder-header">
            <div class="builder-header-left">
                <button class="btn-close-builder" onclick="closeBuilder()">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </button>
                <input 
                    type="text" 
                    class="template-name-input" 
                    id="templateName" 
                    placeholder="Nama Template..."
                >
            </div>
            <div class="d-flex gap-2">
                <button class="btn-close-builder" id="btnPreview">
                    <i class="bi bi-eye me-2"></i>Preview
                </button>
                <button class="btn-save-template" id="btnSave">
                    <i class="bi bi-save me-2"></i>Simpan Template
                </button>
            </div>
        </div>
        <div class="builder-content" id="builderContent">
            <!-- Builder iframe will be loaded here -->
            <iframe id="builderIframe" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Override template selector links to open builder in panel
        document.addEventListener('DOMContentLoaded', function() {
            // Intercept "Tambah Template" clicks
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a[href*="/admin/templates/create"]');
                if (target) {
                    e.preventDefault();
                    openBuilder('create');
                }
            });
            
            // Intercept "Edit" clicks
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a[href*="/admin/templates/"][href*="/edit"]');
                if (target) {
                    e.preventDefault();
                    const url = target.getAttribute('href');
                    const id = url.match(/\/admin\/templates\/(\d+)\/edit/)[1];
                    openBuilder('edit', id);
                }
            });
        });
        
        function openBuilder(mode, id = null) {
            const overlay = document.getElementById('builderOverlay');
            const panel = document.getElementById('builderPanel');
            const iframe = document.getElementById('builderIframe');
            
            // Set iframe source
            if (mode === 'create') {
                iframe.src = '/admin/templates/create?embedded=1';
            } else {
                iframe.src = `/admin/templates/${id}/edit?embedded=1`;
            }
            
            // Show overlay and panel
            overlay.classList.add('active');
            panel.classList.add('active');
            
            // Disable body scroll
            document.body.style.overflow = 'hidden';
        }
        
        function closeBuilder() {
            const overlay = document.getElementById('builderOverlay');
            const panel = document.getElementById('builderPanel');
            const iframe = document.getElementById('builderIframe');
            
            // Hide overlay and panel
            overlay.classList.remove('active');
            panel.classList.remove('active');
            
            // Enable body scroll
            document.body.style.overflow = '';
            
            // Clear iframe after animation
            setTimeout(() => {
                iframe.src = '';
            }, 300);
            
            // Reload templates
            if (typeof loadTemplates === 'function') {
                loadTemplates();
            }
        }
        
        // Listen for save events from iframe
        window.addEventListener('message', function(e) {
            if (e.data.type === 'template-saved') {
                closeBuilder();
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Template berhasil disimpan',
                    icon: 'success',
                    timer: 2000
                });
            }
        });
    </script>
</body>
</html>
