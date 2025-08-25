<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>InputMedia Tambodia - Redesigned</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
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
      width: 240px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding-top: 0.1rem;
      box-sizing: border-box;
      position: fixed;
      left: 0;
      top: 0;
    }
    
    .sidebar-header {
      padding: 0;
      margin-top: 20px;
      user-select: none;
      margin-bottom: 20px;
    }

    .sidebar-header img {
      width: 70px;
      margin-left: 20px;
    }

    .sidebar-title {
      font-weight: 700;
      font-size: 1.25rem;
      margin: 0;
      display: flex;
      align-items: center;
    }

    .title-text {
        display: inline-block;
    }

    .tam { color: #0084d6; }
    .bo { color: #a0d5d2; }
    .dia { color: #1f9e76; }

    .nav-link.active {
      background-color: #1f9e76 !important;
      color: #fffff1 !important;
      font-weight: 600;
      border-radius: 0.375rem;
    }
    
    .nav-link {
      color: #4b596a;
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, color 0.3s ease;
      user-select: none;
    }
    
    .nav-link:hover:not(.active) {
      background-color: #bcddc9;
      color: #1f9e76;
      cursor: pointer;
    }

    main.content-area {
      margin-left: 240px;
      padding: 1.75rem 2rem 2rem 2rem;
      min-height: 100vh;
      background: linear-gradient(90deg, #ffffff, #e9edfa);
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      position: relative;
    }
    
    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      user-select: none;
    }
    
    .header-top h2 {
      margin: 0;
      font-weight: 600;
      font-size: 1.5rem;
      color: #2c3a67;
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

    /* NEW REDESIGNED FORM STYLES */
    .input-wizard {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .wizard-header {
      background: linear-gradient(135deg, #1f9e76 0%, #58cbaa 100%);
      color: white;
      padding: 1.5rem 2rem;
      text-align: center;
    }

    .wizard-header h3 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 600;
    }

    .wizard-header p {
      margin: 0.5rem 0 0 0;
      opacity: 0.9;
      font-size: 0.95rem;
    }

    .wizard-steps {
      display: flex;
      background: #f8f9fa;
      padding: 0;
      margin: 0;
      list-style: none;
      border-bottom: 1px solid #e9ecef;
    }

    .wizard-step {
      flex: 1;
      text-align: center;
      padding: 1rem;
      position: relative;
      background: #f8f9fa;
      color: #6c757d;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .wizard-step.active {
      background: white;
      color: #1f9e76;
    }

    .wizard-step.completed {
      background: #e8f5e8;
      color: #1f9e76;
    }

    .wizard-step::after {
      content: '';
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 0;
      height: 0;
      border-top: 15px solid transparent;
      border-bottom: 15px solid transparent;
      border-left: 15px solid #f8f9fa;
      z-index: 1;
    }

    .wizard-step.active::after {
      border-left-color: white;
    }

    .wizard-step.completed::after {
      border-left-color: #e8f5e8;
    }

    .wizard-step:last-child::after {
      display: none;
    }

    .wizard-content {
      padding: 2rem;
    }

    .step-content {
      display: none;
    }

    .step-content.active {
      display: block;
      animation: fadeInUp 0.4s ease;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Media Type Selection */
    .media-type-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin: 1.5rem 0;
    }

    .media-type-card {
      border: 2px solid #e9ecef;
      border-radius: 12px;
      padding: 2rem 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: white;
      position: relative;
      overflow: hidden;
    }

    .media-type-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
      transition: left 0.5s;
    }

    .media-type-card:hover::before {
      left: 100%;
    }

    .media-type-card:hover {
      border-color: #1f9e76;
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(31, 158, 118, 0.15);
    }

    .media-type-card.selected {
      border-color: #1f9e76;
      background: linear-gradient(135deg, #f0f9f7, #e8f5e8);
      box-shadow: 0 4px 15px rgba(31, 158, 118, 0.2);
    }

    .media-type-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      color: #6c757d;
      transition: color 0.3s ease;
    }

    .media-type-card:hover .media-type-icon,
    .media-type-card.selected .media-type-icon {
      color: #1f9e76;
    }

    .media-type-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin: 0 0 0.5rem 0;
      color: #495057;
    }

    .media-type-desc {
      font-size: 0.9rem;
      color: #6c757d;
      margin: 0;
    }

    /* Enhanced Upload Area */
    .enhanced-upload-area {
      border: 3px dashed #cbd5e1;
      border-radius: 16px;
      padding: 3rem 2rem;
      text-align: center;
      transition: all 0.3s ease;
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      position: relative;
      overflow: hidden;
    }

    .enhanced-upload-area.dragover {
      border-color: #1f9e76;
      background: linear-gradient(135deg, #f0f9f7 0%, #e8f5e8 100%);
      transform: scale(1.02);
    }

    .upload-icon {
      font-size: 4rem;
      color: #94a3b8;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .enhanced-upload-area.dragover .upload-icon {
      color: #1f9e76;
      transform: scale(1.1);
    }

    .upload-text {
      font-size: 1.2rem;
      font-weight: 600;
      color: #475569;
      margin-bottom: 0.5rem;
    }

    .upload-subtext {
      color: #64748b;
      margin-bottom: 1.5rem;
    }

    .upload-btn {
      background: linear-gradient(135deg, #1f9e76, #58cbaa);
      border: none;
      color: white;
      padding: 0.75rem 2rem;
      border-radius: 25px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(31, 158, 118, 0.3);
    }

    .upload-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(31, 158, 118, 0.4);
    }

    /* File Preview Enhanced */
    .file-preview-enhanced {
      background: white;
      border: 1px solid #e9ecef;
      border-radius: 12px;
      padding: 1.5rem;
      margin-top: 1.5rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .file-info-row {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .file-type-icon {
      width: 48px;
      height: 48px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: white;
    }

    .file-type-icon.image { background: linear-gradient(135deg, #667eea, #764ba2); }
    .file-type-icon.video { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .file-type-icon.audio { background: linear-gradient(135deg, #4facfe, #00f2fe); }

    .file-details h6 {
      margin: 0 0 0.25rem 0;
      font-weight: 600;
      color: #495057;
    }

    .file-meta {
      font-size: 0.9rem;
      color: #6c757d;
    }

    .file-actions {
      margin-left: auto;
      display: flex;
      gap: 0.5rem;
    }

    /* Enhanced Form Input */
    .form-label-enhanced {
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .form-control-enhanced {
      border-radius: 8px;
      border: 2px solid #e5e7eb;
      padding: 0.75rem 1rem;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control-enhanced:focus {
      border-color: #1f9e76;
      box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1);
    }

    /* Progress Bar Enhanced */
    .progress-enhanced {
      height: 8px;
      border-radius: 4px;
      background: #f1f5f9;
      overflow: hidden;
      margin-top: 1rem;
    }

    .progress-bar-enhanced {
      background: linear-gradient(90deg, #1f9e76, #58cbaa);
      height: 100%;
      border-radius: 4px;
      transition: width 0.3s ease;
    }

    /* Navigation Buttons */
    .wizard-navigation {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid #e9ecef;
    }

    .btn-wizard {
      padding: 0.75rem 2rem;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
    }

    .btn-wizard-prev {
      background: #f8f9fa;
      color: #6c757d;
    }

    .btn-wizard-prev:hover {
      background: #e9ecef;
    }

    .btn-wizard-next {
      background: linear-gradient(135deg, #1f9e76, #58cbaa);
      color: white;
    }

    .btn-wizard-next:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.3);
    }

    .btn-wizard:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none !important;
    }

    /* Loading States */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      visibility: hidden;
      opacity: 0;
      transition: visibility 0s, opacity 0.3s linear;
    }
    
    .loading-overlay.show {
      visibility: visible;
      opacity: 1;
    }
    
    .spinner-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .spinner-text {
      margin-top: 1rem;
      color: #1f9e76;
      font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 60px;
        border-right: 3px solid #1f9e76;
        padding-top: 1rem;
      }
      .sidebar-header h1 {
          font-size: 0;
        }
      main.content-area {
          margin-left: 60px;
          padding: 1rem;
      }
      .nav-link {
          font-size: 0;
          justify-content: center;
          padding: 0.5rem 0;
      }
      .nav-link .bi {
          font-size: 1.6rem;
      }
      .wizard-content {
        padding: 1rem;
      }
      .media-type-grid {
        grid-template-columns: 1fr;
      }
    }
</style>

<body>
  <!-- Loading Overlay -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-container">
      <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-text">Memproses...</div>
    </div>
  </div>
  
  <nav class="sidebar d-flex flex-column justify-content-between">
    <div>
      <div class="sidebar-header d-flex align-items-center gap-2">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" style="width:70px; height:70px; margin-left:20px; object-fit:contain;"/>
        <h1 class="sidebar-title">
            <span class="title-text">
                <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
            </span>
        </h1>
      </div>
      <ul class="nav flex-column px-1">
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('dashboard.pegawai') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ route('media.input') }}">
            <i class="bi bi-pencil-square"></i> Input Media
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar3"></i> Penjadwalan
          </a>
        </li>
        <li class="nav-item mt-1">
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

  <main class="content-area">
    <div class="header-top">
      <h2>Input Media</h2>
      <div class="user-badge" title="Logged in as Admin">
        <span class="status-indicator" aria-label="online status"></span>
        <span>Admin</span>
      </div>
    </div>

    <!-- Enhanced Input Wizard -->
    <div class="input-wizard">
      <div class="wizard-header">
        <h3><i class="bi bi-cloud-upload me-2"></i>Upload Media Baru</h3>
        <p>Ikuti langkah-langkah berikut untuk mengunggah media Anda</p>
      </div>

      <ul class="wizard-steps">
        <li class="wizard-step active" data-step="1">
          <i class="bi bi-file-earmark-text me-2"></i>
          <span class="d-none d-md-inline">Pilih Jenis</span>
        </li>
        <li class="wizard-step" data-step="2">
          <i class="bi bi-cloud-upload me-2"></i>
          <span class="d-none d-md-inline">Upload File</span>
        </li>
        <li class="wizard-step" data-step="3">
          <i class="bi bi-card-text me-2"></i>
          <span class="d-none d-md-inline">Detail Media</span>
        </li>
        <li class="wizard-step" data-step="4">
          <i class="bi bi-check-circle me-2"></i>
          <span class="d-none d-md-inline">Selesai</span>
        </li>
      </ul>

      <form id="mediaForm" action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="jenisMedia" name="jenisMedia" value="">
        <div class="wizard-content">
          <!-- Step 1: Media Type Selection -->
          <div class="step-content active" id="step1">
            <h4 class="mb-4">Pilih Jenis Media</h4>
            <p class="text-muted mb-4">Pilih jenis media yang akan Anda unggah untuk menentukan format file yang didukung</p>
            
            <div class="media-type-grid">
              <div class="media-type-card" data-type="image">
                <div class="media-type-icon">
                  <i class="bi bi-image"></i>
                </div>
                <h5 class="media-type-title">Gambar</h5>
                <p class="media-type-desc">JPG, PNG, GIF, WEBP<br>Max 250MB</p>
              </div>
              
              <div class="media-type-card" data-type="video">
                <div class="media-type-icon">
                  <i class="bi bi-play-circle"></i>
                </div>
                <h5 class="media-type-title">Video</h5>
                <p class="media-type-desc">MP4, MPEG, MOV, WEBM<br>Max 250MB</p>
              </div>
              
              <div class="media-type-card" data-type="audio">
                <div class="media-type-icon">
                  <i class="bi bi-music-note"></i>
                </div>
                <h5 class="media-type-title">Audio</h5>
                <p class="media-type-desc">MP3, WAV, OGG<br>Max 250MB</p>
              </div>
            </div>
          </div>

          <!-- Step 2: File Upload -->
          <div class="step-content" id="step2">
            <h4 class="mb-4">Upload File</h4>
            <p class="text-muted mb-4">Pilih file dari komputer Anda atau drag & drop ke area di bawah</p>
            
            <div class="enhanced-upload-area" id="uploadArea">
              <div class="upload-icon">
                <i class="bi bi-cloud-upload"></i>
              </div>
              <div class="upload-text">Drag & Drop file di sini</div>
              <div class="upload-subtext">atau klik tombol di bawah untuk memilih file</div>
              <input type="file" id="fileUpload" name="file" style="display: none;" />
              <button type="button" class="upload-btn" id="uploadButton">
                <i class="bi bi-folder2-open me-2"></i>Pilih File
              </button>
            </div>
            <div id="uploadInlineError" class="alert alert-danger mt-3 d-none" role="alert"></div>

            <div id="filePreview" class="d-none">
              <div class="file-preview-enhanced">
                <div class="file-info-row">
                  <div class="file-type-icon" id="fileTypeIcon">
                    <i class="bi bi-file-earmark"></i>
                  </div>
                  <div class="file-details">
                    <h6 id="fileName">No file selected</h6>
                    <div class="file-meta" id="fileMeta"></div>
                  </div>
                  <div class="file-actions">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="previewBtn">
                      <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="removeFileBtn">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>
                <div id="previewContainer" class="mt-3"></div>
                <div id="uploadProgress" class="progress-enhanced d-none">
                  <div class="progress-bar-enhanced" style="width: 0%"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 3: Media Details -->
          <div class="step-content" id="step3">
            <h4 class="mb-4">Detail Media</h4>
            <p class="text-muted mb-4">Berikan nama dan deskripsi untuk file media Anda</p>
            
            <div class="row">
              <div class="col-md-6">
                <label class="form-label-enhanced">
                  <i class="bi bi-card-text"></i>
                  Nama Media
                </label>
                <input type="text" class="form-control form-control-enhanced" id="namaFile" name="namaFile" placeholder="Masukkan nama media...">
              </div>
              <div class="col-md-6">
                <label class="form-label-enhanced">
                  <i class="bi bi-tags"></i>
                  Kategori (Opsional)
                </label>
                <select class="form-control form-control-enhanced" id="kategori" name="kategori">
                  <option value="">Pilih kategori...</option>
                  <option value="promosi">Promosi</option>
                  <option value="edukasi">Edukasi</option>
                  <option value="hiburan">Hiburan</option>
                  <option value="berita">Berita</option>
                </select>
              </div>
            </div>
            
            <div class="row mt-3">
              <div class="col-12">
                <label class="form-label-enhanced">
                  <i class="bi bi-file-text"></i>
                  Deskripsi (Opsional)
                </label>
                <textarea class="form-control form-control-enhanced" id="deskripsi" name="deskripsi" rows="4" placeholder="Tambahkan deskripsi untuk media ini..."></textarea>
              </div>
            </div>
          </div>

          <!-- Step 4: Confirmation -->
          <div class="step-content" id="step4">
            <div class="text-center">
              <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
              </div>
              <h4 class="text-success">Media Berhasil Diunggah!</h4>
              <p class="text-muted">File media Anda telah berhasil diunggah dan siap digunakan.</p>
              
              <div class="mt-4">
                <button type="button" class="btn btn-primary me-3" id="uploadAnotherBtn">
                  <i class="bi bi-plus-circle me-2"></i>Upload Media Lain
                </button>
                <button type="button" class="btn btn-outline-secondary" id="viewMediaBtn">
                  <i class="bi bi-collection me-2"></i>Lihat Semua Media
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="wizard-navigation">
          <button type="button" class="btn-wizard btn-wizard-prev" id="prevBtn" disabled>
            <i class="bi bi-arrow-left me-2"></i>Sebelumnya
          </button>
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary" id="stepIndicator">Langkah 1 dari 4</span>
          </div>
          <button type="button" class="btn-wizard btn-wizard-next" id="nextBtn" disabled>
            Selanjutnya<i class="bi bi-arrow-right ms-2"></i>
          </button>
        </div>
      </form>
    </div>

    <!-- Media Grid (existing media display) -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Media Tersedia</h5>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" data-filter="all">Semua</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="image">Gambar</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="video">Video</button>
            <button class="btn btn-outline-primary btn-sm" data-filter="audio">Audio</button>
          </div>
        </div>
        <div class="row" id="mediaGrid">
          <!-- Media items will be rendered here -->
        </div>
      </div>
    </div>

    <!-- Loading Overlay duplicate removed to avoid duplicate IDs -->
  </main>

  <!-- Preview Modal -->
  <div class="modal fade" id="mediaPreviewModal" tabindex="-1" aria-labelledby="modalPreviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPreviewTitle">Preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-light">
          <div id="modalPreviewContent" class="w-100 d-flex justify-content-center align-items-center" style="min-height:280px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    (function() {
      // Helpers (avoid shadowing jQuery $)
      const qs = (sel, ctx=document) => ctx.querySelector(sel);
      const qsa = (sel, ctx=document) => Array.from(ctx.querySelectorAll(sel));

      const loadingOverlay = qs('#loadingOverlay');
      function showLoading(msg='Memproses...') {
        qs('.spinner-text').textContent = msg;
        loadingOverlay.classList.add('show');
      }
      function hideLoading() { loadingOverlay.classList.remove('show'); }
      function toast(msg, type='success') {
        const bg = type==='success' ? '#1f9e76' : type==='error' ? '#dc3545' : '#0d6efd';
        Toastify({ text: msg, duration: 3000, close: true, gravity: 'top', position: 'right', style: { background: bg } }).showToast();
      }
      // Inline error helpers
      const inlineErrorEl = qs('#uploadInlineError');
      function setInlineError(msg){ if(!inlineErrorEl) return; inlineErrorEl.textContent = msg || ''; inlineErrorEl.classList.toggle('d-none', !msg); }
      function clearInlineError(){ setInlineError(''); }
      function formatBytes(bytes){ if(bytes===0) return '0 B'; const k=1024, s=['B','KB','MB','GB']; const i=Math.floor(Math.log(bytes)/Math.log(k)); return (bytes/Math.pow(k,i)).toFixed(2)+' '+s[i]; }

      // Wizard state
      const steps = qsa('.wizard-step');
      const contents = qsa('.step-content');
      const prevBtn = qs('#prevBtn');
      const nextBtn = qs('#nextBtn');
      const stepIndicator = qs('#stepIndicator');
      const form = qs('#mediaForm');
      const jenisMediaInput = qs('#jenisMedia');
      let currentStep = 1; // 1..4

      function setStep(n){
        currentStep = Math.max(1, Math.min(4, n));
        steps.forEach(s => s.classList.toggle('active', Number(s.dataset.step)===currentStep));
        steps.forEach(s => s.classList.toggle('completed', Number(s.dataset.step)<currentStep));
        contents.forEach((c, idx) => c.classList.toggle('active', (idx+1)===currentStep));
        prevBtn.disabled = currentStep===1;
        nextBtn.textContent = currentStep===3 ? 'Unggah' : (currentStep===4 ? 'Selesai' : 'Selanjutnya');
        nextBtn.disabled = !canProceed();
        stepIndicator.textContent = `Langkah ${currentStep} dari 4`;
      }

      function canProceed(){
        if(currentStep===1){ return !!jenisMediaInput.value; }
        if(currentStep===2){ return (qs('#fileUpload').files||[]).length>0; }
        if(currentStep===3){ return (qs('#namaFile').value||'').trim().length>0; }
        return true;
      }

      prevBtn.addEventListener('click', ()=> setStep(currentStep-1));
      nextBtn.addEventListener('click', async ()=>{
        if(currentStep<3){ setStep(currentStep+1); return; }
        if(currentStep===3){
          // Submit via AJAX
          const fileInput = qs('#fileUpload');
          if(!fileInput.files.length){ toast('Pilih file terlebih dahulu', 'error'); return; }
          // Client-side size validation (<= 250MB)
          const maxBytes = 256000 * 1024; // ~250MB matching server rule
          if (fileInput.files[0].size > maxBytes) {
            const m='Ukuran file melebihi 250MB';
            toast(m, 'error'); setInlineError(m);
            return;
          }
          const fd = new FormData(form);
          showLoading('Mengunggah media...');
          clearInlineError();
          // progress UI
          const barWrap = qs('#uploadProgress');
          const bar = barWrap.querySelector('.progress-bar-enhanced');
          barWrap.classList.remove('d-none');
          bar.style.width = '0%';
          try {
            await new Promise((resolve, reject)=>{
              window.$.ajax({
                url: form.action,
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                xhr: function(){
                  const xhr = new window.XMLHttpRequest();
                  if(xhr.upload){ xhr.upload.addEventListener('progress', function(e){ if(e.lengthComputable){ const p = Math.round((e.loaded/e.total)*100); bar.style.width = p+'%'; } }); }
                  return xhr;
                },
                success: resolve,
                error: function(xhr){ reject(xhr); }
              });
            });
            hideLoading();
            toast('Media berhasil diunggah');
            form.reset();
            qs('#filePreview').classList.add('d-none');
            qs('#previewContainer').innerHTML='';
            bar.style.width = '0%';
            clearInlineError();
            setStep(4);
            // refresh media grid
            fetchMedia('all', '');
          } catch(err){
            hideLoading();
            let msg = 'Gagal mengunggah media';
            try {
              if (err && err.status === 413) {
                msg = 'Ukuran file terlalu besar (server menolak). Naikkan upload_max_filesize/post_max_size atau pilih file lebih kecil.';
              } else if (err && err.status === 422 && err.responseJSON) {
                const r = err.responseJSON;
                msg = r.message || 'Validasi gagal';
                // Log detail untuk debugging (mime/extension)
                console.warn('Upload 422 details:', r);
              } else if (err && err.responseJSON && err.responseJSON.message) {
                msg = err.responseJSON.message;
              }
            } catch(e){}
            toast(msg, 'error');
            setInlineError(msg);
          }
        } else if(currentStep===4){
          // back to start
          jenisMediaInput.value='';
          setStep(1);
        }
      });

      steps.forEach(s=> s.addEventListener('click', ()=>{ const t=Number(s.dataset.step); if(t<currentStep || canProceed()) setStep(t); }));

      // Media type selection
      qsa('.media-type-card').forEach(card => {
        card.addEventListener('click', ()=>{
          qsa('.media-type-card').forEach(c=> c.classList.remove('selected'));
          card.classList.add('selected');
          jenisMediaInput.value = card.dataset.type;
          // adjust accept
          const accept = card.dataset.type==='image' ? 'image/*' : card.dataset.type==='video' ? 'video/*' : 'audio/*';
          qs('#fileUpload').setAttribute('accept', accept);
          nextBtn.disabled = !canProceed();
        });
      });

      // Upload area interactions
      const uploadArea = qs('#uploadArea');
      const fileInput = qs('#fileUpload');
      const uploadBtn = qs('#uploadButton');
      const filePreview = qs('#filePreview');
      const previewContainer = qs('#previewContainer');
      const fileNameEl = qs('#fileName');
      const fileMetaEl = qs('#fileMeta');
      const previewBtn = qs('#previewBtn');
      const removeFileBtn = qs('#removeFileBtn');

      uploadBtn.addEventListener('click', ()=> fileInput.click());
      uploadArea.addEventListener('dragover', e=>{ e.preventDefault(); uploadArea.classList.add('dragover'); });
      uploadArea.addEventListener('dragleave', ()=> uploadArea.classList.remove('dragover'));
      uploadArea.addEventListener('drop', e=>{ e.preventDefault(); uploadArea.classList.remove('dragover'); if(e.dataTransfer.files.length){ fileInput.files = e.dataTransfer.files; handleFile(); } });
      fileInput.addEventListener('change', handleFile);

      function handleFile(){
        if(!fileInput.files.length){ filePreview.classList.add('d-none'); nextBtn.disabled = !canProceed(); return; }
        const f = fileInput.files[0];
        filePreview.classList.remove('d-none');
        fileNameEl.textContent = f.name;
        fileMetaEl.textContent = `${formatBytes(f.size)} • ${f.type || 'unknown'}`;
        // Client-side size cap consistent with server (~250MB)
        const maxBytes = 256000 * 1024; // ~250MB
        if (f.size > maxBytes) {
          const m='Ukuran file melebihi 250MB';
          toast(m, 'error'); setInlineError(m);
          // Keep preview visible but disable next
          nextBtn.disabled = true;
          return;
        }
        clearInlineError();
        // Set icon & preview
        const jm = jenisMediaInput.value;
        const typeRoot = (f.type||'').split('/')[0];
        const icon = jm==='image' || typeRoot==='image' ? 'image' : jm==='video' || typeRoot==='video' ? 'video' : 'audio';
        const iconEl = qs('#fileTypeIcon');
        iconEl.classList.remove('image','video','audio'); iconEl.classList.add(icon||'');
        if(jm==='image'){
          const img = document.createElement('img'); img.src=URL.createObjectURL(f); img.className='img-fluid rounded'; previewContainer.appendChild(img);
        } else if(jm==='video'){
          const v = document.createElement('video'); v.src=URL.createObjectURL(f); v.controls=true; v.style.width='100%'; previewContainer.appendChild(v);
        } else if(jm==='audio'){
          const a = document.createElement('audio'); a.src=URL.createObjectURL(f); a.controls=true; a.style.width='100%'; previewContainer.appendChild(a);
        }
        // autofill name if empty
        const nameField = qs('#namaFile');
        if(!nameField.value){ const base = f.name.replace(/\.[^/.]+$/, ''); nameField.value = base; }
        nextBtn.disabled = !canProceed();
      }

      previewBtn.addEventListener('click', ()=> openPreviewModal());
      removeFileBtn.addEventListener('click', ()=>{ fileInput.value=''; filePreview.classList.add('d-none'); previewContainer.innerHTML=''; nextBtn.disabled = !canProceed(); });

      function openPreviewModal(){
        if(!fileInput.files.length) return;
        const modalEl = document.getElementById('mediaPreviewModal');
        const modalBody = document.getElementById('modalPreviewContent');
        const modalTitle = document.getElementById('modalPreviewTitle');
        modalBody.innerHTML='';
        const f = fileInput.files[0]; const url = URL.createObjectURL(f); const type = jenisMediaInput.value;
        if(type==='image'){ const img=document.createElement('img'); img.src=url; img.className='img-fluid rounded shadow'; modalBody.appendChild(img); modalTitle.textContent='Preview Gambar'; }
        else if(type==='video'){ const v=document.createElement('video'); v.src=url; v.controls=true; v.autoplay=true; v.style.width='100%'; v.className='rounded shadow'; modalBody.appendChild(v); modalTitle.textContent='Preview Video'; }
        else { const a=document.createElement('audio'); a.src=url; a.controls=true; a.style.width='100%'; modalBody.appendChild(a); modalTitle.textContent='Preview Audio'; }
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl); modal.show();
      }

      // Enable/disable Next on name input
      qs('#namaFile').addEventListener('input', ()=> nextBtn.disabled = !canProceed());

      // Media grid filtering and fetch
      const mediaGrid = qs('#mediaGrid');
      qsa('.card .btn-outline-primary[data-filter]').forEach(btn => {
        btn.addEventListener('click', ()=>{
          qsa('.card .btn-outline-primary[data-filter]').forEach(b=> b.classList.remove('active'));
          btn.classList.add('active');
          fetchMedia(btn.dataset.filter, '');
        });
      });

      async function fetchMedia(type='all', search=''){
        mediaGrid.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        const params = new URLSearchParams();
        if(type && type!=='all'){ params.append('type', type); }
        if(search){ params.append('search', search); }
        const endpoint = search && search.trim().length>0 ? '{{ route('api.media.search') }}' : '{{ route('api.media.filter') }}';
        try{
          const res = await fetch(endpoint + '?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const json = await res.json();
          if(!json.success) throw new Error(json.message||'Failed');
          renderMedia(json.data||[]);
        }catch(e){ mediaGrid.innerHTML = '<div class="col-12 text-center py-4"><p>Error loading media.</p></div>'; toast('Gagal memuat data media', 'error'); }
      }

      function renderMedia(list){
        if(!list.length){ mediaGrid.innerHTML = '<div class="col-12 text-center py-4"><p>Tidak ada media.</p></div>'; return; }
        mediaGrid.innerHTML = '';
        list.forEach(item=>{
          const col = document.createElement('div'); col.className='col-md-4 col-lg-3 mb-4';
          col.innerHTML = `
            <div class="card h-100">
              <div class="card-body">
                <h6 class="card-title">${item.name}</h6>
                <p class="card-text"><span class="badge bg-info">${item.type}</span></p>
                <p class="card-text small">${item.created_at||item.date||''}</p>
              </div>
            </div>`;
          mediaGrid.appendChild(col);
        });
      }

      // Initial
      setStep(1);
      fetchMedia('all','');

      // Extra buttons handlers
      const uploadAnother = document.getElementById('uploadAnotherBtn');
      const viewMediaBtn = document.getElementById('viewMediaBtn');
      if(uploadAnother){ uploadAnother.addEventListener('click', ()=>{ form.reset(); qs('#filePreview').classList.add('d-none'); qs('#previewContainer').innerHTML=''; jenisMediaInput.value=''; qsa('.media-type-card').forEach(c=> c.classList.remove('selected')); setStep(1); }); }
      if(viewMediaBtn){ viewMediaBtn.addEventListener('click', ()=>{ document.querySelector('#mediaGrid')?.scrollIntoView({ behavior: 'smooth' }); }); }
    })();
  </script>
  </body>
  </html>