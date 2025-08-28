<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Layout Manager - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
  :root {
    --brand-blue: #2c3a67;
    --primary: #1f9e76;
    --primary-2: #58cbaa;
    --accent-blue: #0071BC;
    --accent-lime: #8CC63F;
    --accent-orange: #F7931E;
    --bg-soft: #f8f9fa;
    --border-soft: #e9ecef;
  }

  

  body {
    background-color: #405672;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #2f3a55;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }

  .sidebar {
    background: linear-gradient( 180deg,#E7FFEA 0%,#ffffff 50%,#dcedff 100%);
    border-right: none;
    min-height: 100vh;
    width: 250px;
    display: flex;
    flex-direction: column;
    position: fixed;
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

  .title-text {
      display: inline-block;
  }

  .tam { color: #0084d6; }
  .bo { color: #a0d5d2; }
  .dia { color: #1f9e76; }

  .sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 0;
  }

  .nav-link.active {
    background-color: #1f9e76;
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

  /* Main Content */
  .main-content {
    margin-left: 250px;
    padding: 1.75rem 2rem 2rem 2rem;
    min-height: 100vh;
    background: #f8f9fa;
    position: relative;
  }

  .layout-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    overflow: hidden;
    max-width: 1200px;
  }

  .layout-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .layout-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .layout-body {
    padding: 2rem;
  }

  .layout-container {
    display: flex;
    gap: 2rem;
    min-height: 600px;
  }

  .layout-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .upload-area {
    border: 3px dashed var(--primary);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(31, 158, 118, 0.05) 0%, rgba(88, 203, 170, 0.05) 100%);
    margin-bottom: 2rem;
  }

  .upload-area:hover {
    border-color: var(--primary-2);
    background: linear-gradient(135deg, rgba(31, 158, 118, 0.1) 0%, rgba(88, 203, 170, 0.1) 100%);
    transform: translateY(-2px);
  }

  .upload-subtitle {
    margin-top: 0.5rem;
    color: var(--primary);
    font-weight: 500;
  }

  .upload-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.8;
  }

  .preview-section {
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 12px;
    padding: 1.5rem;
    flex: 1;
  }

  .preview-title {
    font-size: 2rem;
    font-weight: bold;
    color: var(--brand-blue);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 0.5rem;
  }

  .preview-bps {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .preview-subtitle {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--brand-blue);
    margin-bottom: 1rem;
  }

  .description-area {
    margin-top: 1rem;
  }

  .description-input {
    width: 100%;
    height: 120px;
    border: 2px solid var(--border-soft);
    border-radius: 8px;
    padding: 1rem;
    resize: vertical;
    font-family: inherit;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
  }

  .description-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1);
  }

  .layout-right {
    width: 350px;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .grid-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--brand-blue);
    margin-bottom: 1rem;
    text-align: center;
  }

  .layout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
    height: 600px;
  }

  .layout-box:nth-child(1) {
    grid-column: 1;
    grid-row: 1;
  }

  .layout-box:nth-child(2) {
    grid-column: 2;
    grid-row: 1 / 3;
  }

  .layout-box:nth-child(3) {
    grid-column: 1;
    grid-row: 2 / 4;
  }

  .layout-box:nth-child(4) {
    grid-column: 2;
    grid-row: 3;
  }

  .layout-box:nth-child(5) {
    grid-column: 1;
    grid-row: 4;
  }

  .layout-box:nth-child(6) {
    grid-column: 2;
    grid-row: 4;
  }

  .section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: linear-gradient(135deg, var(--bg-soft) 0%, #ffffff 100%);
    border-radius: 8px;
    border-left: 4px solid var(--primary);
  }

  .background-section .section-header {
    border-left: 4px solid var(--accent-orange);
  }

  .gallery-section .section-header {
    border-left: 4px solid var(--accent-blue);
  }

  .section-title {
    font-weight: 600;
    color: var(--brand-blue);
    font-size: 1rem;
  }

  .section-subtitle {
    color: #6c757d;
    font-size: 0.85rem;
    margin-left: auto;
  }

  .layout-box {
    background: white;
    border: 3px solid var(--border-soft);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 120px;
  }

  .layout-box:hover {
    border-color: var(--primary);
    box-shadow: 0 6px 20px rgba(31, 158, 118, 0.2);
    transform: translateY(-2px);
  }

  .layout-box.has-image {
    border-color: var(--primary);
    padding: 0;
  }

  .layout-box-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .layout-box-placeholder {
    color: #6c757d;
    font-size: 0.85rem;
    text-align: center;
    padding: 1rem;
    font-weight: 500;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
  }

  .layout-box-placeholder i {
    font-size: 1.5rem;
    opacity: 0.7;
  }

  .background-box {
    border-left: 4px solid var(--accent-orange);
  }

  .background-box:hover {
    border-color: var(--accent-orange);
    box-shadow: 0 6px 20px rgba(247, 147, 30, 0.2);
  }

  .background-box .layout-box-number {
    background: var(--accent-orange);
  }

  .gallery-box {
    border-left: 4px solid var(--accent-blue);
  }

  .gallery-box:hover {
    border-color: var(--accent-blue);
    box-shadow: 0 6px 20px rgba(0, 113, 188, 0.2);
  }

  .gallery-box .layout-box-number {
    background: var(--accent-blue);
  }

  .layout-box-number {
    position: absolute;
    top: 8px;
    left: 8px;
    background: var(--primary);
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
  }

  .layout-box-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #dc3545;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    cursor: pointer;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
  }

  .layout-box-remove:hover {
    background: #c82333;
    transform: scale(1.1);
  }

  .layout-box.has-image:hover .layout-box-remove {
    display: flex;
  }

  .layout-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: var(--bg-soft);
    border-top: 1px solid var(--border-soft);
  }

  .layout-info {
    color: #6c757d;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .layout-actions {
    display: flex;
    gap: 1rem;
  }

  .btn-layout {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .btn-layout-save {
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: white;
  }

  .btn-layout-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(31, 158, 118, 0.3);
  }

  .btn-layout-preview {
    background: linear-gradient(135deg, var(--accent-blue), #0056b3);
    color: white;
  }

  .btn-layout-preview:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 113, 188, 0.3);
  }

  .btn-layout-back {
    background: #6c757d;
    color: white;
  }

  .btn-layout-back:hover {
    background: #5a6268;
    transform: translateY(-2px);
  }

  /* Image Selector Modal */
  .image-selector-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1060;
  }

  .image-selector-modal.show {
    display: flex;
  }

  .image-selector-content {
    background: white;
    border-radius: 16px;
    max-width: 90vw;
    max-height: 90vh;
    width: 800px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
  }

  .image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    padding: 1rem;
    max-height: 400px;
    overflow-y: auto;
  }

  .image-card {
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .image-card:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(31, 158, 118, 0.2);
    transform: translateY(-2px);
  }

  .image-card-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .image-card-body {
    padding: 0.75rem;
  }

  .image-card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--brand-blue);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    color: #6c757d;
    text-align: center;
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
  }

  @media (max-width: 768px) {
    .layout-container {
      flex-direction: column;
    }
    
    .layout-right {
      width: 100%;
    }
    
    .layout-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }
</style>

<body>
  <!-- Sidebar Navigation -->
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
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard.pegawai') }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('media.input') }}">
            <i class="bi bi-pencil-square"></i> <span>Input Media</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('layout.index') }}">
            <i class="bi bi-grid-3x3-gap"></i> <span>Layout Manager</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar3"></i> <span>Penjadwalan</span>
          </a>
        </li>
        <li class="nav-item">
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

  <!-- Main Content -->
  <div class="main-content">
    <div class="layout-card">
      <div class="layout-header">
        <h3 class="layout-title">
          <i class="bi bi-palette"></i>
          Atur Tata Letak Gambar Landing Page
        </h3>
      </div>
      
      <div class="layout-body">
        <div class="layout-container">
          <div class="layout-left">
            <div class="upload-area" onclick="showBackgroundSelector()">
              <div class="upload-icon">
                <i class="bi bi-cloud-upload"></i>
              </div>
              <div>
                <strong>Klik area lalu pilih media yang ingin ditampilkan</strong>
              </div>
              <div class="upload-subtitle">
                <small>Untuk menambahkan gambar background</small>
              </div>
            </div>
            
            <div class="preview-section">
              <div class="preview-title">Selamat Datang Di</div>
              <div class="preview-bps">
                <span style="color: var(--accent-blue);">B</span><span style="color: var(--accent-lime);">P</span><span style="color: var(--accent-orange);">S</span>
                <span style="color: var(--brand-blue);">Provinsi</span>
              </div>
              <div class="preview-subtitle">Sumatera Utara</div>
              
              <div class="description-area">
                <label class="form-label fw-semibold mb-2">
                  <i class="bi bi-text-paragraph"></i> Deskripsi Landing Page
                </label>
                <textarea class="description-input" id="layoutDescription" placeholder="Masukkan deskripsi yang akan ditampilkan di landing page...">{{ $description }}</textarea>
              </div>
            </div>
          </div>
          
          <div class="layout-right">
            <div class="grid-title">
              <i class="bi bi-grid-3x2"></i> Layout Grid (6 Posisi)
            </div>
            <div class="layout-grid" id="layoutGrid">
              @for($i = 1; $i <= 6; $i++)
                <div class="layout-box" data-position="{{ $i }}" onclick="selectLayoutBox({{ $i }})">
                  <div class="layout-box-number">{{ $i }}</div>
                  <div class="layout-box-placeholder">Klik untuk pilih media</div>
                </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
      
      <div class="layout-controls">
        <div class="layout-info">
          <i class="bi bi-info-circle"></i>
          Gambar akan ditampilkan secara berurutan pada landing page sebagai background yang berganti-ganti
        </div>
        <div class="layout-actions">
          <button class="btn-layout btn-layout-preview" onclick="previewLayout()">
            <i class="bi bi-eye"></i> Preview
          </button>
          <button class="btn-layout btn-layout-save" onclick="saveLayoutChanges()">
            <i class="bi bi-check-circle"></i> Simpan & Terapkan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Selector Modal -->
  <div class="image-selector-modal" id="imageSelectorModal">
    <div class="image-selector-content">
      <div class="layout-header">
        <h3 class="layout-title">
          <i class="bi bi-images"></i>
          Pilih Gambar untuk Layout
        </h3>
        <button class="btn btn-outline-light btn-sm" onclick="closeImageSelector()">
          <i class="bi bi-x"></i>
        </button>
      </div>
      <div id="imageGrid" class="image-grid">
        <!-- Images will be populated here -->
      </div>
    </div>
  </div>

  <!-- Media Preview Modal (Layout Manager) -->
  <div class="modal fade" id="lmMediaPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-transparent border-0">
        <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0 d-flex justify-content-center align-items-center">
          <div id="lmMediaPreviewContainer" style="width:100%; max-width: 90vw; max-height: 85vh; display:flex; align-items:center; justify-content:center;"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const media = @json($media);
    const layoutImages = @json($layoutImages);
    
    const layoutState = {
      images: @json($media),
      layoutBoxes: {},
      selectedBox: null,
      description: @json($description),
      isBackgroundMode: false
    };

    // Initialize layout on page load
    document.addEventListener('DOMContentLoaded', function() {
      loadExistingLayout();
    });

    function loadExistingLayout() {
      // Load existing layout images into boxes
      layoutImages.forEach(img => {
        if (img.layout_order && img.layout_order >= 1 && img.layout_order <= 6) {
          layoutState.layoutBoxes[img.layout_order] = img;
          updateLayoutBox(img.layout_order, img);
        }
      });
    }

    function selectLayoutBox(position) {
      layoutState.selectedBox = position;
      showImageSelector();
    }

    function showImageSelector() {
      renderImageSelector();
      document.getElementById('imageSelectorModal').classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    function showBackgroundSelector() {
      // Set a special flag to indicate this is for background
      layoutState.isBackgroundMode = true;
      
      // Update modal title for background selection
      const modalTitle = document.querySelector('#imageSelectorModal .modal-title');
      if (modalTitle) {
        modalTitle.innerHTML = '<i class="bi bi-image-fill"></i> Pilih Gambar Background';
      }
      
      renderImageSelector();
      document.getElementById('imageSelectorModal').classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    function closeImageSelector() {
      document.getElementById('imageSelectorModal').classList.remove('show');
      document.body.style.overflow = '';
      layoutState.selectedBox = null;
      layoutState.isBackgroundMode = false;
      
      // Reset modal title
      const modalTitle = document.querySelector('#imageSelectorModal .modal-title');
      if (modalTitle) {
        modalTitle.innerHTML = '<i class="bi bi-palette"></i> Pilih Gambar untuk Layout';
      }
    }

    function renderImageSelector() {
      const grid = document.getElementById('imageGrid');
      
      if (layoutState.images.length === 0) {
        grid.innerHTML = '<div class="no-images">Tidak ada media yang tersedia</div>';
        return;
      }
      
      grid.innerHTML = layoutState.images.map(media => {
        const isVideo = String(media.type).toLowerCase()==='video';
        const src = fileUrl(media.file_path);
        if(!isVideo){
          return `
            <div class="image-card" onclick="selectImage(${media.id})">
              <img src="${src}" alt="${escapeHtml(media.name)}" class="image-card-img"/>
              <div class="image-card-body">
                <h6 class="image-card-title">${escapeHtml(media.name)}</h6>
              </div>
            </div>`;
        }
        const thumb = videoThumb(src);
        const content = thumb
          ? `<img src="${thumb}" alt="${escapeHtml(media.name)}" class="image-card-img"/>`
          : `<div class="image-card-img d-flex align-items-center justify-content-center" style="background:#f5f5f5;color:#666;font-size:48px;"><i class=\"bi bi-play-btn\"></i></div>`;
        return `
          <div class="image-card" onclick="selectImage(${media.id})">
            <div class="position-relative">
              ${content}
              <span class="badge bg-dark position-absolute" style="top:8px; left:8px; opacity:0.85;">Video</span>
              <button class="btn btn-sm btn-light position-absolute" style="top:8px; right:8px;" onclick="previewMedia(event, ${media.id})" title="Preview">
                <i class="bi bi-play-circle"></i>
              </button>
            </div>
            <div class="image-card-body">
              <h6 class="image-card-title">${escapeHtml(media.name)}</h6>
            </div>
          </div>`;
      }).join('');
    }

    function selectImage(imageId) {
      const image = layoutState.images.find(img => img.id === imageId);
      if (!image) return;
      
      // Check if this is background mode (from upload area)
      if (layoutState.isBackgroundMode) {
        // Update the landing page background
        updateLandingBackground(image);
        layoutState.isBackgroundMode = false;
      } else if (layoutState.selectedBox) {
        // Normal layout box selection
        layoutState.layoutBoxes[layoutState.selectedBox] = image;
        updateLayoutBox(layoutState.selectedBox, image);
      }
      
      closeImageSelector();
    }

    function updateLandingBackground(image) {
      // Send AJAX request to save background image
      fetch('/api/layout/background', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({
          background_image_id: image.id
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          toast(`Background "${image.name}" berhasil disimpan`, 'success');
        } else {
          toast(data.message || 'Gagal menyimpan background', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        toast('Terjadi kesalahan saat menyimpan background', 'error');
      });
    }

    function updateLayoutBox(position, image) {
      const box = document.querySelector(`[data-position="${position}"]`);
      if (!box) return;
      
      box.classList.add('has-image');
      const isVideo = String(image.type).toLowerCase()==='video';
      if(!isVideo){
        box.innerHTML = `
          <div class="layout-box-number">${position}</div>
          <div class="layout-box-remove" onclick="removeImageFromBox(${position}, event)">
            <i class="bi bi-x"></i>
          </div>
          <img src="${fileUrl(image.file_path)}" alt="${escapeHtml(image.name)}" class="layout-box-image">
        `;
        return;
      }
      const src = fileUrl(image.file_path);
      const thumb = videoThumb(src);
      const content = thumb
        ? `<img src="${thumb}" alt="${escapeHtml(image.name)}" class="layout-box-image">`
        : `<div class="layout-box-image d-flex align-items-center justify-content-center" style="background:#000;color:#fff;"><i class=\"bi bi-play-btn\" style=\"font-size:48px;\"></i></div>`;
      box.innerHTML = `
        <div class="layout-box-number">${position}</div>
        <div class="layout-box-remove" onclick="removeImageFromBox(${position}, event)">
          <i class="bi bi-x"></i>
        </div>
        ${content}
      `;
    }

    function removeImageFromBox(position, event) {
      event.stopPropagation();
      
      delete layoutState.layoutBoxes[position];
      
      const box = document.querySelector(`[data-position="${position}"]`);
      if (box) {
        box.classList.remove('has-image');
        box.innerHTML = `
          <div class="layout-box-number">${position}</div>
          <div class="layout-box-placeholder">Klik untuk pilih media</div>
        `;
      }
    }

    function previewLayout() {
      const description = document.getElementById('layoutDescription')?.value || '';
      const layoutImages = Object.values(layoutState.layoutBoxes);
      
      if (layoutImages.length === 0) {
        toast('Pilih minimal satu gambar untuk preview', 'error');
        return;
      }
      
      // Open landing page in new tab for preview
      window.open('{{ url("/") }}', '_blank');
    }

    async function saveLayoutChanges() {
      try {
        const description = document.getElementById('layoutDescription')?.value || '';
        const layoutData = {
          description: description,
          images: Object.entries(layoutState.layoutBoxes).map(([position, image]) => ({
            position: parseInt(position),
            image_id: image.id,
            order: parseInt(position)
          }))
        };
        
        if (layoutData.images.length === 0) {
          toast('Pilih minimal satu gambar untuk layout', 'error');
          return;
        }
        
        const response = await fetch('/api/layout/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(layoutData)
        });
        
        const result = await response.json();
        
        if (result.success) {
          toast('Layout berhasil disimpan dan diterapkan ke landing page!');
          setTimeout(() => {
            window.location.href = '{{ route("dashboard.pegawai") }}';
          }, 2000);
        } else {
          throw new Error(result.message || 'Gagal menyimpan layout');
        }
      } catch (error) {
        console.error('Error saving layout:', error);
        toast('Terjadi kesalahan saat menyimpan layout', 'error');
      }
    }

    function fileUrl(path) {
      let p = String(path || '');
      if (/^(?:https?:)?\/\//i.test(p)) return p; // keep absolute URL (YouTube/CDN)
      p = p.replace(/^\/+/, '');
      p = p.replace(/^public\//, '');
      return `${window.location.origin}/storage/${p}`;
    }

    function isYouTube(url){
      return /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)/i.test(String(url||''));
    }
    function youtubeId(url){
      const m = String(url||'').match(/(?:youtube\.com\/.*[?&]v=|youtu\.be\/)([\w-]{11})/i); return m?m[1]:null;
    }
    function videoThumb(url){
      if(isYouTube(url)){
        const id = youtubeId(url); if(id) return `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
      }
      return null; // fallback handled by caller
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    function toast(message, type = 'success') {
      Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: 'top',
        position: 'right',
        backgroundColor: type === 'success' ? '#1f9e76' : '#dc3545',
      }).showToast();
    }

    // Media Preview for Layout Manager (image + video)
    const lmPreview = {
      modalEl: null,
      container: null,
      bsModal: null,
      init(){
        this.modalEl = document.getElementById('lmMediaPreviewModal');
        this.container = document.getElementById('lmMediaPreviewContainer');
        if(this.modalEl){ this.bsModal = new bootstrap.Modal(this.modalEl); }
        if(this.modalEl){
          this.modalEl.addEventListener('hidden.bs.modal', ()=>{
            if(this.container) this.container.innerHTML = '';
          });
        }
      },
      open(media){
        if(!this.bsModal || !this.container) return;
        const src = fileUrl(media.file_path);
        const name = escapeHtml(media.name || '');
        let html = '';
        const isVid = String(media.type).toLowerCase()==='video';
        if(!isVid){
          html = `<img src="${src}" alt="${name}" style="max-width:100%; max-height:85vh; object-fit:contain;"/>`;
        } else {
          const yt = isYouTube(src) ? youtubeId(src) : null;
          if(yt){
            html = `<div class=\"ratio ratio-16x9\" style=\"width:100%; max-width:1000px;\"><iframe src=\"https://www.youtube.com/embed/${'${yt}'}?autoplay=1\" title=\"${'${name}'}\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></div>`;
          } else {
            html = `<video controls autoplay playsinline style=\"width:100%; max-width:1000px; max-height:85vh;\"><source src=\"${'${src}'}\">Browser Anda tidak mendukung pemutar video.</video>`;
          }
        }
        this.container.innerHTML = html;
        this.bsModal.show();
      }
    };

    function previewMedia(e, id){
      e.stopPropagation();
      const m = layoutState.images.find(x=>x.id===id);
      if(!m){ return; }
      if(!lmPreview.bsModal){ lmPreview.init(); }
      lmPreview.open(m);
    }

    // Close modal when clicking outside
    document.getElementById('imageSelectorModal').addEventListener('click', (e) => {
      if (e.target.id === 'imageSelectorModal') {
        closeImageSelector();
      }
    });
  </script>
</body>
</html>
