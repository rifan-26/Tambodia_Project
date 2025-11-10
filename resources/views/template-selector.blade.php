<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Master Layout - Template Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('components.sweetalert2')
    <style>
        :root {
            --primary: #1f9e76;
            --primary-light: #58cbaa;
            --text-dark: #2c3a67;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --border-light: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(180deg, #E7FFEA 0%, #ffffff 50%, #dcedff 100%);
            border-right: none;
            height: 100vh;
            width: 250px;
            display: flex;
            flex-direction: column;
            position: fixed !important;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1000;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #f1f3f4;
            flex-shrink: 0;
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .sidebar-header img {
            width: 50px;
            height: 50px;
        }

        .sidebar-title {
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .tam { color: #0084d6; }
        .bo { color: #a0d5d2; }
        .dia { color: #1f9e76; }

        .nav-link.active {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            border-radius: 0.375rem;
        }
        
        .nav-link {
            color: #4b596a;
            padding: 0.5rem 1rem;
            margin: 0.25rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .nav-link:hover:not(.active) {
            background-color: #bcddc9;
            color: #1f9e76;
            cursor: pointer;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(31, 158, 118, 0.2);
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Content Area */
        .content-area {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
        }
        
        .header-top h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.75rem;
            color: var(--text-dark);
        }
        
        .user-badge {
            background: linear-gradient(90deg, #58cbaa, #7cb8f4);
            padding: 0.35rem 1rem;
            border-radius: 2rem;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
        }

        .user-badge .status-indicator {
            width: 16px;
            height: 16px;
            background-color: #44d69e;
            border-radius: 50%;
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .template-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .template-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .template-preview {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eaf0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .template-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .template-preview .placeholder {
            font-size: 4rem;
            color: #cbd5e0;
        }

        .template-info {
            padding: 1.5rem;
        }

        .template-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .template-meta {
            font-size: 0.875rem;
            color: #718096;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .template-actions {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            gap: 0.5rem;
        }

        .btn-template {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-select {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-select:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-edit {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .btn-edit:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .btn-delete {
            background: #fff5f5;
            color: #e53e3e;
            border: 2px solid #feb2b2;
            padding: 0.75rem;
            width: 45px;
        }

        .btn-delete:hover {
            background: #fed7d7;
        }

        .add-template-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .add-template-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.3);
        }

        .add-template-card i {
            font-size: 5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .add-template-card .text {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .active-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #48bb78;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
            z-index: 10;
        }

        .back-button {
            background: white;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-title,
            .nav-link span {
                display: none;
            }
            
            .content-area {
                margin-left: 70px;
                padding: 1rem;
            }
            
            .nav-link {
                justify-content: center;
                padding: 0.75rem 0.5rem;
                margin: 0 0.25rem;
            }

            .templates-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-2">
            <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" />
            <h1 class="sidebar-title">
                <span class="title-text">
                    <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
                </span>
            </h1>
        </div>
        
        <div class="sidebar-content">
            <ul class="nav flex-column px-1">
                <li class="nav-item mb-1">
                    <a class="nav-link" href="{{ route('dashboard.pegawai') }}">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="{{ route('media.input') }}">
                        <i class="bi bi-pencil-square"></i> <span>Input Media</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="{{ route('schedule.index') }}">
                        <i class="bi bi-calendar3"></i> <span>Penjadwalan</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link active" href="{{ route('layout') }}">
                        <i class="bi bi-grid-3x3"></i> <span>Master Layout</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="{{ route('staff.index') }}">
                        <i class="bi bi-people"></i> <span>Master Profil</span>
                    </a>
                </li>
                <li class="nav-item mt-auto">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i> <span>Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="content-area">
        <!-- Header -->
        <div class="header-top">
            <h2>Master Layout - Template Manager</h2>
            <div class="user-badge" title="Logged in">
                <span class="status-indicator" aria-label="online status"></span>
                <span>{{ Auth::user()->name ?? 'User' }}</span>
            </div>
        </div>

        <!-- Templates Grid -->
        <div class="templates-grid" id="templatesGrid">
            <!-- Templates will be loaded here -->
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Memuat template...</p>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Load templates on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTemplates();
        });

        /**
         * Load all templates
         */
        function loadTemplates() {
            fetch('/api/layout/templates')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderTemplates(data.templates);
                    }
                })
                .catch(error => {
                    console.error('Error loading templates:', error);
                    document.getElementById('templatesGrid').innerHTML = `
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                            <p class="mt-3 text-danger">Gagal memuat template</p>
                        </div>
                    `;
                });
        }

        /**
         * Render templates to grid
         */
        function renderTemplates(templates) {
            const grid = document.getElementById('templatesGrid');
            
            if (templates.length === 0) {
                grid.innerHTML = `
                    <div class="add-template-card" onclick="createNewTemplate()">
                        <i class="bi bi-plus-circle"></i>
                        <div class="text">Tambah Template</div>
                    </div>
                `;
                return;
            }

            let html = '';
            
            // Render existing templates
            templates.forEach(template => {
                html += `
                    <div class="template-card">
                        ${template.is_active ? '<div class="active-badge"><i class="bi bi-check-circle me-1"></i>Active</div>' : ''}
                        <div class="template-preview">
                            ${template.thumbnail_path ? 
                                `<img src="${template.thumbnail_path}" alt="${template.name}">` : 
                                '<i class="bi bi-grid-3x3-gap placeholder"></i>'
                            }
                        </div>
                        <div class="template-info">
                            <div class="template-name">${template.name}</div>
                            <div class="template-meta">
                                <i class="bi bi-calendar3"></i>
                                ${new Date(template.created_at).toLocaleDateString('id-ID')}
                            </div>
                        </div>
                        <div class="template-actions">
                            ${!template.is_active ? 
                                `<button class="btn-template btn-select" onclick="selectTemplate(${template.id})">
                                    <i class="bi bi-check-circle"></i> Pilih
                                </button>` : 
                                '<button class="btn-template btn-select" disabled style="opacity: 0.6;">Template Aktif</button>'
                            }
                            <button class="btn-template btn-edit" onclick="editTemplate(${template.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            ${!template.is_active ? 
                                `<button class="btn-template btn-delete" onclick="deleteTemplate(${template.id})">
                                    <i class="bi bi-trash"></i>
                                </button>` : ''
                            }
                        </div>
                    </div>
                `;
            });

            // Add "Tambah Template" card
            html += `
                <div class="add-template-card" onclick="createNewTemplate()">
                    <i class="bi bi-plus-circle"></i>
                    <div class="text">Tambah Template</div>
                </div>
            `;

            grid.innerHTML = html;
        }

        /**
         * Select template (activate)
         */
        function selectTemplate(id) {
            Swal.fire({
                title: 'Aktifkan Template?',
                text: 'Template ini akan diterapkan ke landing page',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Aktifkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#667eea'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/templates/${id}/activate`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Template telah diaktifkan',
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                loadTemplates();
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Gagal mengaktifkan template', 'error');
                    });
                }
            });
        }

        /**
         * Edit template - redirect to builder
         */
        function editTemplate(id) {
            window.location.href = `/admin/templates/${id}/edit`;
        }

        /**
         * Delete template
         */
        function deleteTemplate(id) {
            Swal.fire({
                title: 'Hapus Template?',
                text: 'Template yang dihapus tidak dapat dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e53e3e'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/templates/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Template telah dihapus',
                                icon: 'success',
                                timer: 2000
                            }).then(() => {
                                loadTemplates();
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Gagal menghapus template', 'error');
                    });
                }
            });
        }

        /**
         * Create new template - redirect to builder
         */
        function createNewTemplate() {
            window.location.href = '/admin/templates/create';
        }
    </script>
</body>
</html>
