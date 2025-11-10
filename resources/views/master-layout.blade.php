<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Master Layout - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('components.sweetalert2')
</head>

<style>
    :root {
      --primary: #1f9e76;
      --primary-light: #58cbaa;
      --text-dark: #2c3a67;
      --text-muted: #6c757d;
      --bg-light: #f8f9fa;
      --border-light: #e9ecef;
    }
    
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    /* Sidebar */
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
      -webkit-overflow-scrolling: touch;
      height: calc(100vh - 120px);
      overflow-x: hidden;
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
      background-color: #f5f5f5;
      position: relative;
      z-index: 1;
      overflow-x: hidden;
      overflow-y: auto;
      height: 100vh;
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
      user-select: none;
    }
    
    .user-badge .status-indicator {
      width: 16px;
      height: 16px;
      background-color: #44d69e;
      border-radius: 50%;
      box-shadow: 0 0 6px #44d69eaa;
    }

    /* Template Grid */
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .template-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .template-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .template-thumbnail {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .template-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .template-thumbnail .placeholder-icon {
        font-size: 4rem;
        color: rgba(255,255,255,0.5);
    }

    .active-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #28a745;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        z-index: 10;
    }

    .template-body {
        padding: 1.25rem;
    }

    .template-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .template-meta {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .template-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.5rem;
        font-size: 0.875rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-activate {
        background: #28a745;
        color: white;
    }

    .btn-activate:hover {
        background: #218838;
    }

    .btn-edit {
        background: #007bff;
        color: white;
    }

    .btn-edit:hover {
        background: #0056b3;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .add-template-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 300px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white;
        text-decoration: none;
    }

    .add-template-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(31, 158, 118, 0.4);
    }

    .add-template-card i {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .add-template-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
    }

    .loading-state {
        text-align: center;
        padding: 3rem;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Builder Modal Styles */
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

    .builder-modal {
        position: fixed;
        top: 0;
        right: -100%;
        width: calc(100% - 250px);
        height: 100%;
        background: white;
        z-index: 2001;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
        box-shadow: -4px 0 20px rgba(0,0,0,0.2);
    }

    .builder-modal.active {
        right: 0;
    }

    .builder-header {
        background: white;
        border-bottom: 2px solid #e0e0e0;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .builder-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .builder-header-actions {
        display: flex;
        gap: 0.5rem;
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
        border-color: var(--primary);
    }

    .btn-close-builder {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #d0d0d0;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .btn-close-builder:hover {
        background: #e8eaf0;
        border-color: var(--primary);
    }

    .btn-secondary-builder {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #d0d0d0;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .btn-secondary-builder:hover {
        background: #e8eaf0;
    }

    .btn-primary-builder {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .btn-primary-builder:hover {
        background: var(--primary-light);
    }

    .builder-content {
        flex: 1;
        overflow: auto;
        background: #f5f5f5;
    }

    .builder-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #666;
    }

    @media (max-width: 768px) {
        .builder-modal {
            width: 100%;
        }
    }
</style>

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
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('media.input') }}">
            <i class="bi bi-pencil-square"></i> Input Media
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar3"></i> Penjadwalan
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ route('layout') }}">
            <i class="bi bi-grid-3x3"></i> Master Layout
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('staff.index') }}">
            <i class="bi bi-people"></i> Master Profil
          </a>
        </li>
        <li class="nav-item mt-auto">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">
            @csrf
          </form>
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Log Out
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="content-area">
    <div class="header-top">
        <h2>Master Layout</h2>
        <div class="user-badge" title="Logged in">
            <span class="status-indicator" aria-label="online status"></span>
            <span>{{ Auth::user()->name ?? 'User' }}</span>
        </div>
    </div>
    
    <p class="text-muted">Pilih atau buat template untuk landing page</p>

    <!-- Template Grid -->
    <div class="templates-grid" id="templatesGrid">
        <!-- Loading state -->
        <div class="loading-state">
            <div class="loading-spinner"></div>
            <p class="text-muted">Memuat template...</p>
        </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
  <script src="{{ asset('js/template-builder-freeform.js') }}"></script>
  <script src="{{ asset('js/template-builder-modal.js') }}"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        loadTemplates();
    });

    function loadTemplates() {
        fetch('/api/layout/templates')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Templates loaded:', data);
                if (data.success) {
                    renderTemplates(data.templates || []);
                } else {
                    throw new Error(data.message || 'Failed to load templates');
                }
            })
            .catch(error => {
                console.error('Error loading templates:', error);
                // Still show "Add Template" card even if API fails
                document.getElementById('templatesGrid').innerHTML = `
                    <a href="/admin/templates/create" class="add-template-card">
                        <i class="bi bi-plus-circle"></i>
                        <h3>Tambah Template</h3>
                        <p class="mb-0">Buat template layout baru</p>
                    </a>
                    <div class="col-12 text-center py-5" style="grid-column: 1 / -1;">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-1">Tidak dapat memuat template yang ada</p>
                        <p class="text-muted small">${error.message}</p>
                        <button class="btn btn-sm btn-primary mt-2" onclick="loadTemplates()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                        </button>
                    </div>
                `;
            });
    }

    function renderTemplates(templates) {
        const grid = document.getElementById('templatesGrid');
        
        // Always show "Add Template" card first
        let html = `
            <a href="/admin/templates/create" class="add-template-card">
                <i class="bi bi-plus-circle"></i>
                <h3>Tambah Template</h3>
                <p class="mb-0">Buat template layout baru</p>
            </a>
        `;
        
        if (!templates || templates.length === 0) {
            grid.innerHTML = html;
            return;
        }
        
        // Add template cards
        templates.forEach(template => {
            html += `
                <div class="template-card">
                    <div class="template-thumbnail">
                        ${template.thumbnail_path 
                            ? `<img src="/storage/${template.thumbnail_path}" alt="${template.name}">`
                            : '<i class="bi bi-grid-3x3-gap placeholder-icon"></i>'
                        }
                        ${template.is_active 
                            ? '<span class="active-badge"><i class="bi bi-check-circle me-1"></i>Active</span>'
                            : ''
                        }
                    </div>
                    <div class="template-body">
                        <h3 class="template-title">${template.name}</h3>
                        <div class="template-meta">
                            <i class="bi bi-calendar3 me-1"></i>
                            ${new Date(template.updated_at).toLocaleDateString('id-ID')}
                            <br>
                            <i class="bi bi-grid me-1"></i>
                            Grid: ${template.grid_type.toUpperCase()}
                        </div>
                        <div class="template-actions">
                            ${!template.is_active 
                                ? `<button class="btn-action btn-activate" onclick="activateTemplate(${template.id})">
                                    <i class="bi bi-check-circle me-1"></i>Pilih
                                </button>`
                                : ''
                            }
                            <a href="/admin/templates/${template.id}/edit" class="btn-action btn-edit">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            ${!template.is_active 
                                ? `<button class="btn-action btn-delete" onclick="deleteTemplate(${template.id})">
                                    <i class="bi bi-trash"></i>
                                </button>`
                                : ''
                            }
                        </div>
                    </div>
                </div>
            `;
        });

        grid.innerHTML = html;
    }

    function activateTemplate(id) {
        Swal.fire({
            title: 'Aktifkan Template?',
            text: 'Template ini akan ditampilkan di halaman landing',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Aktifkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/templates/${id}/activate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
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
                    Swal.fire('Error!', 'Gagal mengaktifkan template', 'error');
                });
            }
        });
    }

    function deleteTemplate(id) {
        Swal.fire({
            title: 'Hapus Template?',
            text: 'Template yang dihapus tidak dapat dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/templates/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
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
                    Swal.fire('Error!', 'Gagal menghapus template', 'error');
                });
            }
        });
    }

    // ===== Builder Modal Functions =====
    // These functions now use the TemplateBuilderModal class
    function openBuilderModal(mode, templateId = null) {
        if (window.builderModal) {
            window.builderModal.open(mode, templateId);
        }
    }

    function closeBuilderModal() {
        if (window.builderModal) {
            window.builderModal.close();
        }
    }

    // Intercept template card clicks
    document.addEventListener('DOMContentLoaded', function() {
        // Intercept template card clicks
        document.addEventListener('click', function(e) {
            // Intercept "+ Tambah Template" clicks
            const addCard = e.target.closest('a[href*="/admin/templates/create"]');
            if (addCard) {
                e.preventDefault();
                openBuilderModal('create');
                return;
            }
            
            // Intercept "Edit" button clicks
            const editBtn = e.target.closest('a[href*="/admin/templates/"][href*="/edit"]');
            if (editBtn) {
                e.preventDefault();
                const href = editBtn.getAttribute('href');
                const match = href.match(/\/admin\/templates\/(\d+)\/edit/);
                if (match) {
                    const templateId = match[1];
                    openBuilderModal('edit', templateId);
                }
                return;
            }
        });
    });
  </script>

  <!-- Template Builder Modal -->
  <div id="builderOverlay" class="builder-overlay"></div>
  
  <div id="builderModal" class="builder-modal">
    <div class="builder-header">
      <div class="builder-header-left">
        <button class="btn-close-builder" onclick="closeBuilderModal()">
          <i class="bi bi-arrow-left me-2"></i>Kembali
        </button>
        <input 
          type="text" 
          class="template-name-input" 
          id="builderTemplateName" 
          placeholder="Nama Template..."
        >
      </div>
      <div class="builder-header-actions">
        <button class="btn-secondary-builder" id="btnBuilderPreview">
          <i class="bi bi-eye me-2"></i>Preview
        </button>
        <button class="btn-primary-builder" id="btnBuilderSave">
          <i class="bi bi-save me-2"></i>Simpan Template
        </button>
      </div>
    </div>
    
    <div class="builder-content" id="builderContent">
      <!-- Builder interface included directly -->
      @include('components.template-builder-content')
    </div>
  </div>
</body>
</html>
