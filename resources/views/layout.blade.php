<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Layout Manager Tambodia - Redesigned</title>
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
    align-items: flex-start;
  }

  .layout-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    max-width: calc(100% - 370px);
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

  /* ===== LAYOUT GRID SYSTEM ===== */
  .layout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 140px 140px 140px 100px;
    gap: 8px;
    margin-bottom: 1.5rem;
    height: auto;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px solid #e9ecef;
  }

  /* Drag and Drop Styles */
  .layout-box.drag-over {
    border-color: var(--primary);
    background: rgba(31, 158, 118, 0.1);
    transform: scale(1.02);
  }

  .layout-box.dragging {
    opacity: 0.5;
    transform: rotate(2deg);
  }

  .drag-placeholder {
    border: 3px dashed var(--primary);
    background: rgba(31, 158, 118, 0.05);
    border-radius: 12px;
  }

  /* ===== GRID POSITIONING ===== */
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

  /* ===== LAYOUT BOX STYLING ===== */
  .layout-box {
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
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

  .layout-box-current-media {
    transition: all 0.3s ease;
  }

  .layout-box-current-media:hover {
    transform: scale(1.02);
    filter: brightness(1.05);
  }

  /* ===== MEDIA CONTENT STYLING ===== */
  .layout-box-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .layout-box-image.youtube-video {
    border: none;
    border-radius: 8px;
  }

  /* ===== MEDIA CONTENT ===== */
  .layout-box:nth-child(1) .layout-box-image, .layout-box:nth-child(1) video, .layout-box:nth-child(1) .youtube-video,
  .layout-box:nth-child(4) .layout-box-image, .layout-box:nth-child(4) video, .layout-box:nth-child(4) .youtube-video {
    aspect-ratio: 1/1; 
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 8px;
  }
  .layout-box:nth-child(2) .layout-box-image, .layout-box:nth-child(2) video, .layout-box:nth-child(2) .youtube-video,
  .layout-box:nth-child(3) .layout-box-image, .layout-box:nth-child(3) video, .layout-box:nth-child(3) .youtube-video {
    aspect-ratio: 9/16; 
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 8px;
  }
  .layout-box:nth-child(5) .layout-box-image, .layout-box:nth-child(5) video, .layout-box:nth-child(5) .youtube-video,
  .layout-box:nth-child(6) .layout-box-image, .layout-box:nth-child(6) video, .layout-box:nth-child(6) .youtube-video {
    aspect-ratio: 16/9; 
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 8px;
  }

  .layout-box-current-media {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .layout-box-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px;
    font-size: 0.75rem;
  }

  .layout-box-name {
    font-weight: 600;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .layout-box-user {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.7rem;
    opacity: 0.9;
  }

  .layout-box-user.own-media {
    color: #28a745;
  }

  .layout-box-user.other-admin-media {
    color: #ffc107;
  }

  .layout-box-user i {
    font-size: 0.8rem;
  }

  .video-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    gap: 4px;
    z-index: 2;
  }

  .layout-box .video-overlay {
    background: rgba(0, 0, 0, 0.9);
    font-size: 0.65rem;
    padding: 4px 10px;
  }

  .layout-box-placeholder {
    color: #6c757d;
    font-size: 0.8rem;
    text-align: center;
    padding: 0.5rem;
    line-height: 1.2;
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
    top: 6px;
    left: 6px;
    background: var(--primary);
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 600;
    z-index: 2;
  }

  .layout-box-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 24px;
    height: 24px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    z-index: 10;
    transition: all 0.2s ease;
  }

  .schedule-overlay {
    position: absolute;
    top: 8px;
    left: 8px;
    background: rgba(40, 167, 69, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    display: flex;
    align-items: center;
    gap: 4px;
    z-index: 10;
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
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.2rem;
    padding: 1.5rem;
    max-height: 450px;
    overflow-y: auto;
  }

  .image-card {
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }

  .image-card:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 25px rgba(31, 158, 118, 0.3);
    transform: translateY(-4px);
  }

  .image-card-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  
  .image-card:hover .image-card-img {
    transform: scale(1.05);
  }

  .image-card-body {
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  }

  .image-card-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--brand-blue);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
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

  /* ===== RESPONSIVE DESIGN ===== */
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

    /* Maintain aspect ratios on mobile */
    .layout-box:nth-child(1),
    .layout-box:nth-child(4) {
      aspect-ratio: 1/1;
      height: auto;
    }
    
    .layout-box:nth-child(2),
    .layout-box:nth-child(3) {
      aspect-ratio: 9/16;
      height: auto;
    }
    
    .layout-box:nth-child(5),
    .layout-box:nth-child(6) {
      aspect-ratio: 16/9;
      height: auto;
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="content-header">
            <h1 class="content-title">Layout Manager</h1>
            <p class="content-subtitle">Kelola tata letak media untuk tampilan landing page</p>
            @if(isset($activeSchedule) && $activeSchedule)
              <div class="alert alert-warning mt-3">
                <i class="bi bi-calendar-check"></i>
                <strong>Jadwal Aktif:</strong> Saat ini ada {{ $activeSchedule->count() }} media yang sedang dijadwalkan. 
                Layout manager dalam mode read-only.
              </div>
            @endif
          </div>
        </div>
      </div>
      
      <div class="layout-container">
        <div class="layout-left">
          <div class="background-section">
            <div class="background-header">
              <i class="bi bi-image"></i> Background Media
            </div>
            <div class="background-upload" onclick="openBackgroundModal()">
              <div id="backgroundUploadText">
                <strong>Klik area lalu pilih media yang ingin ditampilkan</strong>
              </div>
              <div class="upload-subtitle" id="backgroundUploadSubtitle">
                <small>Untuk menambahkan gambar/video background</small>
              </div>
              <div class="background-preview" id="backgroundPreview" style="display: none; margin-top: 1rem; position: relative;">
                <div class="position-relative">
                  <img id="backgroundPreviewImg" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover; display: none;">
                  <video id="backgroundPreviewVideo" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover; display: none;" controls muted>
                    <source id="backgroundVideoSource" type="video/mp4">
                  </video>
                  <button class="btn btn-sm btn-danger position-absolute" style="top: 8px; right: 8px;" onclick="removeBackgroundMedia(event)" title="Hapus Background">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
                <div style="margin-top: 0.5rem; font-size: 0.9rem; color: var(--primary); font-weight: 500;" id="backgroundPreviewName"></div>
              </div>
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
            <div class="layout-grid">
              @for ($i = 1; $i <= 6; $i++)
                <div class="layout-box" data-position="{{ $i }}" onclick="selectLayoutBox({{ $i }})">
                  @if(isset($positionMap[$i]) && $positionMap[$i])
                    @php
                      $media = $positionMap[$i];
                      $isVideo = in_array(strtolower(pathinfo($media->file_path, PATHINFO_EXTENSION)), ['mp4', 'webm', 'ogg', 'avi', 'mov']);
                      $isYouTube = strpos($media->file_path, 'youtube.com') !== false || strpos($media->file_path, 'youtu.be') !== false;
                    @endphp
                    
                    <div class="layout-box-number">{{ $i }}</div>
                    <div class="layout-box-remove" onclick="removeImageFromBox({{ $i }}, event)">
                      <i class="bi bi-x"></i>
                    </div>
                    
                    @if($isYouTube)
                      @php
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $media->file_path, $matches);
                        $videoId = $matches[1] ?? '';
                        $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                      @endphp
                      <img src="{{ $thumbnailUrl }}" alt="{{ $media->name }}" class="layout-box-image">
                    @elseif($isVideo)
                      <video class="layout-box-video" muted>
                        <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                      </video>
                    @else
                      <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->name }}" class="layout-box-image">
                    @endif
                    
                    @if(isset($activeSchedule) && $activeSchedule)
                      <div class="schedule-overlay">
                        <i class="bi bi-calendar-check"></i>
                        <small>Terjadwal</small>
                      </div>
                    @endif
                  @else
                    <div class="layout-box-placeholder">
                      <i class="bi bi-plus-circle"></i>
                      <span>{{ isset($activeSchedule) && $activeSchedule ? 'Kosong' : 'Tambah Media' }}</span>
                    </div>
                  @endif
                </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
      
      <div class="layout-controls">
        <div class="layout-info">
          <i class="bi bi-info-circle"></i>
          <div>
            <div><strong>Media akan ditampilkan di gallery landing page.</strong></div>
            <div style="font-size: 0.9rem; margin-top: 4px;">
              <span class="text-success"><i class="bi bi-person-check-fill"></i> Media Anda</span> | 
              <span class="text-warning"><i class="bi bi-person-x-fill"></i> Admin Lain</span>
            </div>
            <div style="font-size: 0.85rem; margin-top: 4px; color: #6c757d;">
              Foto yang ditambahkan akan menggantikan foto yang sudah ada di posisi yang sama.
            </div>
          </div>
        </div>
        <div class="action-buttons">
          <button type="button" class="btn btn-success" onclick="saveLayoutChanges()">
            <i class="bi bi-check-circle"></i> Simpan Layout
          </button>
          <button type="button" class="btn btn-secondary" onclick="resetLayout()">
            <i class="bi bi-arrow-clockwise"></i> Reset
          </button>
          <button type="button" class="btn btn-primary" onclick="previewLayout()">
            <i class="bi bi-eye"></i> Preview
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
      <div class="modal-footer" id="backgroundModalFooter" style="display: none; padding: 1rem; border-top: 1px solid var(--border-soft); background: var(--bg-soft);">
        <button class="btn btn-outline-danger" onclick="clearBackground()">
          <i class="bi bi-trash"></i> Hapus Background
        </button>
        <button class="btn btn-secondary" onclick="closeImageSelector()">
          <i class="bi bi-x"></i> Batal
        </button>
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

    // Function to refresh media data via API
    function refreshMediaData() {
      return fetch('/api/media/user')
        .then(response => response.json())
        .then(data => {
          if (data.success && data.media) {
            layoutState.images = data.media;
            
            // Re-render the image selector if modal is open
            const modal = document.getElementById('imageSelectorModal');
            if (modal && modal.classList.contains('show')) {
              renderImageSelector();
            }
            return data.media;
          }
          return [];
        })
        .catch(error => {
          console.error('Error refreshing media:', error);
          return [];
        });
    }

    // Initialize layout on page load
    document.addEventListener('DOMContentLoaded', function() {
      loadExistingLayout();
      loadExistingBackground();
      
      // Refresh media data every 5 seconds to catch new uploads
      setInterval(refreshMediaData, 5000);
    });

    function loadExistingBackground() {
      // Check if there's an existing background image
      fetch('/api/layout/background')
        .then(response => response.json())
        .then(data => {
          if (data.success && data.background) {
            updateBackgroundPreview(data.background);
          }
        })
        .catch(error => {
          console.log('No existing background or error loading:', error);
        });
    }

    function loadExistingLayout() {
      // Load existing layout images into boxes
      layoutImages.forEach(img => {
        if (img.layout_order && img.layout_order >= 1 && img.layout_order <= 6) {
          layoutState.layoutBoxes[img.layout_order] = img;
          // Update the visual box to show the image
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
      const modalTitle = document.querySelector('#imageSelectorModal .layout-title');
      if (modalTitle) {
        modalTitle.innerHTML = '<i class="bi bi-image-fill"></i> Pilih Media Background';
      }
      
      // Show background modal footer
      const footer = document.getElementById('backgroundModalFooter');
      if (footer) {
        footer.style.display = 'flex';
        footer.style.justifyContent = 'space-between';
        footer.style.alignItems = 'center';
      }
      
      // Refresh media data before showing modal
      refreshMediaData();
      
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
      const modalTitle = document.querySelector('#imageSelectorModal .layout-title');
      if (modalTitle) {
        modalTitle.innerHTML = '<i class="bi bi-images"></i> Pilih Gambar untuk Layout';
      }
      
      // Hide background modal footer
      const footer = document.getElementById('backgroundModalFooter');
      if (footer) {
        footer.style.display = 'none';
      }
    }

    function renderImageSelector() {
      const grid = document.getElementById('imageGrid');
      
      // Filter media based on background mode
      let filteredMedia = layoutState.images;
      if (layoutState.isBackgroundMode) {
        // For background, show both images and videos
        filteredMedia = layoutState.images.filter(media => 
          media.type === 'Gambar' || media.type === 'Video'
        );
      } else {
        // For layout boxes, show both images and videos
        filteredMedia = layoutState.images.filter(media => 
          media.type === 'Gambar' || media.type === 'Video'
        );
      }

      if (filteredMedia.length === 0) {
        grid.innerHTML = `
          <div class="empty-state">
            <i class="bi bi-images"></i>
            <h5>Tidak ada media yang tersedia</h5>
            <p>Silakan tambahkan media terlebih dahulu di halaman Input Media</p>
          </div>
        `;
        return;
      }

      grid.innerHTML = filteredMedia.map(media => {
        const isVideo = String(media.type).toLowerCase()==='video';
        const src = fileUrl(media.file_path);
        if(!isVideo){
          return `
            <div class="image-card" onclick="selectImage(${media.id})">
              <div class="position-relative">
                <img src="${src}" alt="${escapeHtml(media.name)}" class="image-card-img"/>
                <button class="btn btn-sm btn-danger position-absolute" style="top:8px; right:8px; opacity:0.9;" onclick="deleteMediaFromLayout(event, ${media.id})" title="Hapus Media">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
              <div class="image-card-body">
                <h6 class="image-card-title">${escapeHtml(media.name)}</h6>
              </div>
            </div>`;
        }
        const thumb = videoThumb(src);
        const content = thumb
          ? `<img src="${thumb}" alt="${escapeHtml(media.name)}" class="image-card-img"/>`
          : `<div class="image-card-img d-flex align-items-center justify-content-center" style="background:#f5f5f5;color:#666;"></div>`;
        return `
          <div class="image-card" onclick="selectImage(${media.id})">
            <div class="position-relative">
              ${content}
              <span class="badge bg-dark position-absolute" style="top:8px; left:8px; opacity:0.85;">Video</span>
              <div class="position-absolute" style="top:8px; right:8px;">
                <button class="btn btn-sm btn-light me-1" onclick="previewMedia(event, ${media.id})" title="Preview">
                  <i class="bi bi-play-circle"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteMediaFromLayout(event, ${media.id})" title="Hapus Media">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
            <div class="image-card-body">
              <h6 class="image-card-title">${escapeHtml(media.name)}</h6>
            </div>
          </div>`;
      }).join('');
    }

    // Function to delete media permanently from layout
    function deleteMediaFromLayout(event, mediaId) {
      event.stopPropagation(); // Prevent selectImage from being called
      
      if (confirm('Apakah Anda yakin ingin menghapus media ini secara permanen?')) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/media/${mediaId}`, {
          method: 'DELETE',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
          },
          credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Show success message
            toast(data.message || 'Media berhasil dihapus', 'success');
            
            // Reload the entire page to refresh all data
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          } else {
            toast(data.message || 'Gagal menghapus media', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          toast('Terjadi kesalahan saat menghapus media', 'error');
        });
      }
    }

    // Function to remove media from specific layout position
    function removeMediaFromPosition(event, position) {
      event.stopPropagation();
      
      if (confirm('Hapus media dari posisi ini?')) {
        // Remove from layout state
        delete layoutState.layoutBoxes[position];
        
        // Update the layout box display
        const layoutBox = document.querySelector(`[data-position="${position}"]`);
        if (layoutBox) {
          layoutBox.innerHTML = `<div class="layout-box-number">${position}</div>`;
          layoutBox.classList.remove('has-image');
          layoutBox.removeAttribute('data-media-type');
          layoutBox.removeAttribute('data-media-path');
          layoutBox.removeAttribute('data-media-name');
          layoutBox.removeAttribute('data-youtube-id');
        }
        
        Toastify({
          text: `Media berhasil dihapus dari posisi ${position}`,
          backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
          duration: 2000
        }).showToast();
      }
    }

    // Function to remove background media
    function removeBackgroundMedia(event) {
      event.stopPropagation();
      
      if (confirm('Hapus background media?')) {
        clearBackground();
      }
    }

    function selectImage(imageId) {
      const image = layoutState.images.find(img => img.id === imageId);
      if (!image) return;
      
      // Check if this is background mode (from upload area)
      if (layoutState.isBackgroundMode) {
        // Update the landing page background
        updateLandingBackground(image);
        layoutState.isBackgroundMode = false;
        layoutState.backgroundMedia = image;
      } else if (layoutState.selectedBox) {
        // Normal layout box selection
        layoutState.layoutBoxes[layoutState.selectedBox] = image;
        updateLayoutBox(layoutState.selectedBox, image);
      }
      
      closeImageSelector();
    }

    function updateLandingBackground(image) {
      // Update preview first
      updateBackgroundPreview(image);
      
      // Send AJAX request to save background
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

    function clearBackground() {
      // Clear preview immediately for better UX
      clearBackgroundPreview();
      
      // Send AJAX request to clear background image
      fetch('/api/layout/background', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({
          background_image_id: null
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          toast('Background berhasil dihapus', 'success');
          closeImageSelector();
        } else {
          toast(data.message || 'Gagal menghapus background', 'error');
          // If API fails, we might want to restore the preview
          // But for now, keep it cleared since user wanted to delete
        }
      })
      .catch(error => {
        console.error('Error:', error);
        toast('Terjadi kesalahan saat menghapus background', 'error');
      });
    }

    function updateBackgroundPreview(image) {
      const preview = document.getElementById('backgroundPreview');
      const previewImg = document.getElementById('backgroundPreviewImg');
      const previewName = document.getElementById('backgroundPreviewName');
      const uploadIcon = document.getElementById('backgroundUploadIcon');
      const uploadText = document.getElementById('backgroundUploadText');
      const uploadSubtitle = document.getElementById('backgroundUploadSubtitle');
      
      if (preview && previewImg && previewName) {
        previewImg.src = fileUrl(image.file_path);
        previewName.textContent = image.name;
        preview.style.display = 'block';
        
        // Hide upload elements
        if (uploadIcon) uploadIcon.style.display = 'none';
        if (uploadText) uploadText.style.display = 'none';
        if (uploadSubtitle) uploadSubtitle.style.display = 'none';
      }
    }

    function clearBackgroundPreview() {
      const preview = document.getElementById('backgroundPreview');
      const uploadIcon = document.getElementById('backgroundUploadIcon');
      const uploadText = document.getElementById('backgroundUploadText');
      const uploadSubtitle = document.getElementById('backgroundUploadSubtitle');
      
      if (preview) preview.style.display = 'none';
      
      // Show upload elements
      if (uploadIcon) uploadIcon.style.display = 'block';
      if (uploadText) uploadText.style.display = 'block';
      if (uploadSubtitle) uploadSubtitle.style.display = 'block';
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
      const isYouTube = src.includes('youtube.com') || src.includes('youtu.be');
      
      let content;
      if (isYouTube) {
        // Extract YouTube video ID
        const videoId = src.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/)?.[1];
        if (videoId) {
          const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
          content = `<img src="${thumbnailUrl}" alt="${escapeHtml(image.name)}" class="layout-box-image">`;
        } else {
          content = `<div class="layout-box-image d-flex align-items-center justify-content-center" style="background:#000;color:#fff;"></div>`;
        }
      } else {
        // Local video - show thumbnail or video preview
        content = `<video autoplay muted loop class="layout-box-image"><source src="${src}" type="video/mp4"></video>`;
      }
      
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
      
      // Remove from layout state
      delete layoutState.layoutBoxes[position];
      
      // Update the visual box to show placeholder
      updateLayoutBox(position, null);
    }

    function previewLayout() {
      const description = document.getElementById('layoutDescription')?.value || '';
      const layoutImages = Object.values(layoutState.layoutBoxes);
      
      // Allow preview even without images
      toast('Membuka preview landing page...', 'success');
      
      // Open landing page in new tab for preview
      window.open('{{ url("/") }}', '_blank');
    }

    async function saveLayoutChanges() {
      try {
        const description = document.getElementById('layoutDescription')?.value || '';
        // Create layout object with position as key and media_id as value
        const layout = {};
        Object.entries(layoutState.layoutBoxes).forEach(([position, image]) => {
          layout[position] = image.id;
        });
        
        const layoutData = {
          description: description,
          layout: layout
        };
        
        // Allow saving even without images
        if (Object.keys(layout).length === 0) {
          toast('Menyimpan layout tanpa media...', 'info');
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
          const message = Object.keys(layout).length === 0 
            ? 'Layout berhasil disimpan (tanpa media)!' 
            : 'Layout berhasil disimpan dan diterapkan ke landing page!';
          toast(message);
          // Stay in layout manager instead of redirecting to dashboard
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

    const isYouTube = url => /(?:youtube\.com\/watch\?v=|youtu\.be\/)/i.test(String(url||''));
    const youtubeId = url => String(url||'').match(/(?:youtube\.com\/.*[?&]v=|youtu\.be\/)([\w-]{11})/i)?.[1];
    const videoThumb = url => isYouTube(url) ? `https://img.youtube.com/vi/${youtubeId(url)}/hqdefault.jpg` : null;

    const escapeHtml = text => { const div = document.createElement('div'); div.textContent = text; return div.innerHTML; };

    function toast(message, type = 'success') {
      const colors = {
        'success': '#1f9e76',
        'error': '#dc3545',
        'info': '#0071BC',
        'warning': '#F7931E'
      };
      
      Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: 'top',
        position: 'right',
        backgroundColor: colors[type] || colors.success,
      }).showToast();
    }

    // Simplified media preview
    const lmPreview = {
      modalEl: null, container: null, bsModal: null,
      init() {
        this.modalEl = document.getElementById('lmMediaPreviewModal');
        this.container = document.getElementById('lmMediaPreviewContainer');
        if (this.modalEl) {
          this.bsModal = new bootstrap.Modal(this.modalEl);
          this.modalEl.addEventListener('hidden.bs.modal', () => {
            if (this.container) this.container.innerHTML = '';
          });
        }
      },
      open(media) {
        if (!this.bsModal || !this.container) return;
        const src = fileUrl(media.file_path);
        const name = escapeHtml(media.name || '');
        const isVideo = String(media.type).toLowerCase() === 'video';
        
        let html = isVideo 
          ? (isYouTube(src) 
              ? `<div class="ratio ratio-16x9" style="width:100%; max-width:1000px;"><iframe src="https://www.youtube.com/embed/${youtubeId(src)}?autoplay=1" title="${name}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`
              : `<video controls autoplay playsinline style="width:100%; max-width:1000px; max-height:85vh;"><source src="${src}">Browser tidak mendukung video.</video>`)
          : `<img src="${src}" alt="${name}" style="max-width:100%; max-height:85vh; object-fit:contain;"/>`;
        
        this.container.innerHTML = html;
        this.bsModal.show();
      }
    };

    const previewMedia = (e, id) => {
      e.stopPropagation();
      const media = layoutState.images.find(x => x.id === id);
      if (media) {
        if (!lmPreview.bsModal) lmPreview.init();
        lmPreview.open(media);
      }
    };

    const previewLayoutMedia = (e, position) => {
      e.stopPropagation();
      const box = document.querySelector(`[data-position="${position}"]`);
      if (box) {
        const media = {
          type: box.getAttribute('data-media-type'),
          file_path: box.getAttribute('data-media-path'),
          name: box.getAttribute('data-media-name')
        };
        if (media.type && media.file_path) {
          if (!lmPreview.bsModal) lmPreview.init();
          lmPreview.open(media);
        }
      }
    };



    document.getElementById('imageSelectorModal').addEventListener('click', e => {
      if (e.target.id === 'imageSelectorModal') closeImageSelector();
    });
  </script>
</body>
</html>
