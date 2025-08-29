<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      opacity: 0;
      animation: pageLoad 0.6s ease-out forwards;
    }

    @keyframes pageLoad {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Smooth transitions for all interactive elements */
    * {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Page transition overlay */
    .page-transition {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, #1f9e76, #58cbaa);
      z-index: 9999;
      opacity: 0;
      visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.4s ease;
    }

    .page-transition.active {
      opacity: 1;
      visibility: visible;
    }

    .transition-content {
      text-align: center;
      color: white;
    }

    .transition-spinner {
      width: 40px;
      height: 40px;
      border: 3px solid rgba(255,255,255,0.3);
      border-top: 3px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto 1rem;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .sidebar {
      background: linear-gradient(180deg, #E7FFEA 0%, #ffffff 50%, #dcedff 100%);
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

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stats-card {
      background: white;
      border-radius: 8px;
      padding: 1.5rem;
      border: 1px solid var(--border-light);
      text-align: center;
    }

    .stats-icon {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin: 0 auto 1rem;
      color: white;
    }

    .stats-card.total .stats-icon { background: var(--text-dark); }
    .stats-card.audio .stats-icon { background: #3b82f6; }
    .stats-card.video .stats-icon { background: #ef4444; }
    .stats-card.image .stats-icon { background: #10b981; }

    .stats-number {
      font-size: 2rem;
      font-weight: 700;
      color: var(--text-dark);
      margin: 0;
      line-height: 1;
    }

    .stats-label {
      color: var(--text-muted);
      font-size: 0.9rem;
      font-weight: 500;
      margin-top: 0.5rem;
    }

    /* Media Section */
    .dashboard-section {
      background: white;
      border-radius: 8px;
      border: 1px solid var(--border-light);
      margin-bottom: 2rem;
    }

    .section-header {
      background: var(--bg-light);
      padding: 1.5rem;
      border-bottom: 1px solid var(--border-light);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--text-dark);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Media Grid */
    .media-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      padding: 1.5rem;
    }

    /* Responsive columns: 2 on md, 1 on sm */
    @media (max-width: 992px) {
      .media-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
      .media-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
        gap: 1rem;
      }
    }

    .media-card {
      background: white;
      border: 1px solid var(--border-light);
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.2s ease;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .media-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-color: var(--primary);
    }

    .media-card-header {
      padding: 1rem;
      background: var(--bg-light);
      border-bottom: 1px solid var(--border-light);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .media-title {
      font-weight: 500;
      color: var(--text-dark);
      margin: 0;
      font-size: 1rem;
    }

    .media-badge {
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 500;
      text-transform: uppercase;
    }

    .media-badge.image { background-color: #dbeafe; color: #1d4ed8; }
    .media-badge.video { background-color: #fecaca; color: #dc2626; }
    .media-badge.audio { background-color: #dcfce7; color: #16a34a; }

    .media-card-body {
      padding: 1rem;
      display: flex;
      flex-direction: column;
      flex: 1 1 auto;
    }

    .media-date {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin-bottom: 1rem;
    }

    .media-preview {
      position: relative;
      background: var(--bg-light);
      border-radius: 4px;
      overflow: hidden;
      min-height: 160px;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .media-preview img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      display: block;
    }

    .media-preview video {
      width: 100%;
      max-height: 160px;
      object-fit: cover;
      display: block;
    }

    .media-preview audio {
      width: 100%;
      display: block;
    }

    .media-preview .ratio {
      height: 160px;
    }

    .audio-player-container {
      width: 100%;
      padding: 1rem;
      background: var(--bg-light);
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .media-actions {
      display: flex;
      gap: 0.5rem;
      justify-content: flex-end;
      margin-top: auto;
      flex-wrap: wrap;
    }

    .btn-enhanced {
      border-radius: 4px;
      font-weight: 500;
      transition: all 0.2s ease;
      border: none;
      padding: 0.4rem 0.6rem;
      font-size: 0.75rem;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      white-space: nowrap;
    }

    .btn-preview {
      background: var(--primary);
      color: white;
    }

    .btn-preview:hover {
      background: var(--primary-light);
    }

    .btn-delete {
      background: #dc3545;
      color: white;
    }

    .btn-delete:hover {
      background: #c82333;
    }

    .btn-play {
      background: #3b82f6;
      color: white;
    }

    .btn-play:hover {
      background: #2563eb;
    }

    /* Bulk Actions */
    .bulk-actions {
      padding: 1rem 1.5rem;
      background: var(--bg-light);
      border-bottom: 1px solid var(--border-light);
      display: none;
    }

    .bulk-actions.show {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    @media (max-width: 768px) {
      .bulk-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
      }
      
      .bulk-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
      }
    }

    .bulk-select {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .bulk-buttons {
      display: flex;
      gap: 0.5rem;
    }

    .btn-bulk {
      padding: 0.5rem 1rem;
      border-radius: 4px;
      font-size: 0.85rem;
      font-weight: 500;
      border: none;
      transition: all 0.2s ease;
    }

    .btn-bulk-toggle {
      background: var(--text-dark);
      color: white;
    }

    .btn-bulk-show {
      background: var(--primary);
      color: white;
    }

    .btn-bulk-hide {
      background: #dc3545;
      color: white;
    }

    .btn-bulk-info {
      background: #6b7280;
      color: white;
    }

    /* Audio Player */
    .audio-player-container {
      background: var(--bg-light);
      border-radius: 4px;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .checkbox-enhanced {
      width: 16px;
      height: 16px;
      accent-color: var(--primary);
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
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .spinner-text {
      margin-top: 1rem;
      color: var(--primary);
      font-weight: 500;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 3rem 2rem;
      color: var(--text-muted);
    }

    .empty-state i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      .sidebar-header {
        padding: 1rem 0.5rem 0;
        margin-bottom: 1rem;
      }
      .sidebar-header img {
        width: 40px;
        height: 40px;
      }
      .sidebar-title {
        display: none;
      }
      .sidebar-content {
        padding: 0;
      }
      .sidebar-footer {
        padding: 0.5rem;
      }
      .user-info {
        flex-direction: column;
        gap: 0.25rem;
        padding: 0.5rem;
      }
      .user-details {
        display: none;
      }
      main.content-area {
        margin-left: 70px;
        padding: 1rem;
      }
      .nav-link {
        justify-content: center;
        padding: 0.75rem 0.5rem;
        margin: 0 0.25rem;
        flex-direction: column;
        gap: 0.25rem;
        font-size: 0.7rem;
      }
      .nav-link i {
        font-size: 1.2rem;
      }
      .nav-link span {
        display: none;
      }
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
      }
      .media-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
      }
      .bulk-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
      }
      .header-top {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
    }

    @media (max-width: 576px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
      .media-card-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
      }
      .media-actions {
        justify-content: center;
      }
    }

    /* Filter Section Styling */
    .filter-section {
      background: white;
      border: 1px solid var(--border-light);
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .filter-section .filter-btn {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      color: #495057;
      padding: 0.5rem 1rem;
      margin-right: 0.5rem;
      margin-bottom: 0.5rem;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.2s ease;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .filter-section .filter-btn:hover {
      background: #e9ecef;
      border-color: #adb5bd;
      transform: translateY(-1px);
    }

    .filter-section .filter-btn.active {
      background: var(--primary);
      border-color: var(--primary);
      color: white;
      box-shadow: 0 2px 8px rgba(31, 158, 118, 0.3);
    }

    .filter-section #resetFilter {
      background: #6c757d;
      border-color: #6c757d;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .filter-section #resetFilter:hover {
      background: #5a6268;
      border-color: #545b62;
      transform: translateY(-1px);
    }
  </style>

<body>
  <!-- Page Transition Overlay -->
  <div class="page-transition" id="pageTransition">
    <div class="transition-content">
      <div class="transition-spinner"></div>
      <div>Memuat halaman...</div>
    </div>
  </div>

  <!-- Loading Overlay -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-container">
      <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="spinner-text">Loading...</div>
    </div>
  </div>

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
          <a class="nav-link active" href="{{ route('dashboard.pegawai') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('media.input') }}">
            <i class="bi bi-pencil-square"></i> Input Media
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('layout.index') }}">
            <i class="bi bi-grid-3x3-gap"></i> Layout Manager
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
        <h2>Dashboard</h2>
        <div class="user-badge" title="Logged in">
            <span class="status-indicator" aria-label="online status"></span>
            <span>{{ Auth::user()->name ?? 'User' }}</span>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stats-card total">
        <div class="stats-icon">
          <i class="bi bi-collection"></i>
        </div>
        <div class="stats-number" id="totalMedia">0</div>
        <div class="stats-label">Total Media</div>
      </div>
      
      <div class="stats-card audio">
        <div class="stats-icon">
          <i class="bi bi-music-note"></i>
        </div>
        <div class="stats-number" id="totalAudio">0</div>
        <div class="stats-label">Audio Files</div>
      </div>
      
      <div class="stats-card video">
        <div class="stats-icon">
          <i class="bi bi-play-circle"></i>
        </div>
        <div class="stats-number" id="totalVideo">0</div>
        <div class="stats-label">Video Files</div>
      </div>
      
      <div class="stats-card image">
        <div class="stats-icon">
          <i class="bi bi-image"></i>
        </div>
        <div class="stats-number" id="totalImage">0</div>
        <div class="stats-label">Image Files</div>
      </div>
    </div>

    <!-- Media Management Section -->
    <div class="dashboard-section">
      <div class="section-header">
        <h3 class="section-title">
          <i class="bi bi-folder2-open"></i>
          Media Management
        </h3>
      </div>

      <!-- Filter Section -->
      <div class="filter-section">
        <div class="d-flex align-items-center mb-3">
          <h6 class="mb-0 me-3"><i class="bi bi-funnel me-2"></i>Filter Media:</h6>
          <button id="resetFilter" class="btn btn-sm">
            <i class="bi bi-arrow-clockwise me-1"></i>Reset
          </button>
        </div>
        <div class="filter-buttons">
          <button class="filter-btn active" data-type="all">
            <i class="bi bi-grid-3x3-gap me-1"></i>Semua
          </button>
          <button class="filter-btn" data-type="image">
            <i class="bi bi-image me-1"></i>Gambar
          </button>
          <button class="filter-btn" data-type="video">
            <i class="bi bi-play-circle me-1"></i>Video
          </button>
          <button class="filter-btn" data-type="audio">
            <i class="bi bi-music-note me-1"></i>Audio
          </button>
        </div>
      </div>

      <!-- Bulk Actions -->
      <div class="bulk-actions">
        <div class="bulk-select">
          <div class="form-check">
            <input class="form-check-input checkbox-enhanced" type="checkbox" value="" id="selectAll">
            <label class="form-check-label" for="selectAll">
              Select All
            </label>
          </div>
          <span class="text-muted" id="selectedCount">0 selected</span>
        </div>
        <div class="bulk-buttons">
          <button type="button" id="btnBulkShow" class="btn-bulk btn-bulk-show" title="Show selected media on landing page">
            <i class="bi bi-eye"></i> Show
          </button>
          <button type="button" id="btnBulkHide" class="btn-bulk btn-bulk-hide" title="Hide selected media from landing page">
            <i class="bi bi-eye-slash"></i> Hide
          </button>
        </div>
      </div>

      <!-- Media Grid -->
      <div class="section-content">
        <div class="media-grid" id="mediaContainer">
            <!-- Media cards will be rendered here -->
        </div>
      </div>
    </div>

    
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    // ===== Dashboard JS: Fetch from backend and wire interactions =====
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const API = {
      filter: `${window.location.origin}/api/media/filter`,
      search: `${window.location.origin}/api/media/search`,
      toggle: `${window.location.origin}/media/toggle-landing`,
      destroy: (id) => `${window.location.origin}/media/${id}`,
    };

    const state = {
      media: [],
    };

    function toast(message, type = 'success') {
      Toastify({
        text: message,
        duration: 2500,
        close: true,
        gravity: 'top',
        position: 'right',
        backgroundColor: type === 'success' ? '#1f9e76' : '#dc3545',
      }).showToast();
    }

    function fileUrl(path) {
      // Normalize path coming from backend. If absolute URL, keep as-is.
      let p = String(path || '');
      if (/^(?:https?:)?\/\//i.test(p)) return p; // external URL (e.g., YouTube, CDN)
      p = p.replace(/^\/+/, '');
      p = p.replace(/^public\//, '');
      return `${window.location.origin}/media/${p}`;
    }

    function guessMimeFromPath(path, fallback) {
      const ext = (String(path).split('.').pop() || '').toLowerCase();
      const map = {
        mp3: 'audio/mpeg', mpeg: 'video/mpeg', mp4: 'video/mp4', m4a: 'audio/mp4',
        wav: 'audio/wav', ogg: 'audio/ogg', oga: 'audio/ogg', webm: 'video/webm',
        mov: 'video/quicktime', qt: 'video/quicktime', mkv: 'video/x-matroska',
        avi: 'video/x-msvideo'
      };
      return map[ext] || fallback || '';
    }

    function showLoading(show = true) {
      const overlay = document.getElementById('loadingOverlay');
      if (!overlay) return;
      overlay.classList.toggle('show', !!show);
    }

    async function fetchMedia(params = {}) {
      try {
        showLoading(true);
        const rawVal = String(params.type ?? 'all').trim();
        const mapToApi = (v) => {
          const t = (v || '').toLowerCase();
          if (!t || t === 'all') return 'all';
          if (t === 'image') return 'image';
          if (t === 'video') return 'video';
          if (t === 'audio') return 'audio';
          return 'all'; // fallback to all
        };
        const apiType = mapToApi(rawVal);
        const q = new URLSearchParams();
        q.set('type', apiType);
        const url = API.filter + '?' + q.toString();
        try { console.debug('[fetchMedia] GET', url); } catch (_) {}
        const res = await fetch(url, {
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest',
          },
          credentials: 'same-origin',
        });
        let json;
        try {
          json = await res.clone().json();
        } catch (e) {
          // Likely redirected to login or HTML error; surface a toast
          const text = await res.text();
          console.error('Non-JSON response from', url, res.status, text.slice(0, 300));
          throw new Error('Gagal memuat data (non-JSON response)');
        }
        if (json.success === false) throw new Error(json.message || 'Failed to load media');
        // Support array or paginated structure { data: [...] }
        let items = [];
        if (Array.isArray(json)) {
          items = json;
        } else if (Array.isArray(json.data)) {
          items = json.data;
        } else if (json.data && Array.isArray(json.data.data)) {
          items = json.data.data; // paginated
        } else if (json.items && Array.isArray(json.items)) {
          items = json.items;
        }
        try { console.debug('[fetchMedia] items parsed:', Array.isArray(items) ? items.length : 'non-array'); } catch (_) {}
        state.media = Array.isArray(items) ? items : [];
        renderAll();
      } catch (e) {
        console.error(e);
        toast('Error loading media data', 'error');
      } finally {
        showLoading(false);
      }
    }

    function renderAll() {
      updateStats(state.media);
      renderMediaGrid(state.media);
      updateSelectedCount();
      initPlyrPlayers();
      wireMediaErrorHandlers();
    }

    function initFilterButtons() {
      const filterBtns = document.querySelectorAll('.filter-btn');
      const resetBtn = document.getElementById('resetFilter');
      
      filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          // Update active state
          filterBtns.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          
          // Get filter type
          const filterType = btn.dataset.type;
          
          // Clear selections when filtering
          document.querySelectorAll('.media-checkbox').forEach(cb => cb.checked = false);
          updateSelectedCount();
          
          // Fetch filtered media
          fetchMedia({ type: filterType });
        });
      });
      
      if (resetBtn) {
        resetBtn.addEventListener('click', () => {
          // Reset to "Semua" filter
          filterBtns.forEach(b => b.classList.remove('active'));
          document.querySelector('.filter-btn[data-type="all"]').classList.add('active');
          
          // Clear selections
          document.querySelectorAll('.media-checkbox').forEach(cb => cb.checked = false);
          updateSelectedCount();
          
          // Fetch all media
          fetchMedia({ type: 'all' });
        });
      }
    }

    function updateStats(items) {
      const total = items.length;
      const byType = items.reduce((acc, m) => {
        const t = m.type;
        acc[t] = (acc[t] || 0) + 1;
        return acc;
      }, {});
      setText('totalMedia', total);
      setText('totalAudio', byType['Audio'] || 0);
      setText('totalVideo', byType['Video'] || 0);
      setText('totalImage', byType['Gambar'] || 0);
    }

    function setText(id, val) {
      const el = document.getElementById(id);
      if (el) el.textContent = val;
    }

    function renderMediaGrid(items) {
      const container = document.getElementById('mediaContainer');
      if (!container) return;
      try { console.debug('[renderMediaGrid] items:', Array.isArray(items) ? items.length : 'non-array'); } catch (_) {}
      if (!items.length) {
        container.innerHTML = `
          <div class="empty-state w-100">
            <i class="bi bi-folder-x"></i>
            <div>No media found.</div>
          </div>`;
        // Ensure container is visible even when empty
        container.style.display = 'grid';
        return;
      }
      container.innerHTML = items.map(m => mediaCardTemplate(m)).join('');
      // Ensure the grid is visible after re-render
      container.style.display = 'grid';
      try { console.debug('[renderMediaGrid] rendered cards:', container.children.length); } catch (_) {}
      // Make sure cards are visible (animation CSS sets opacity:0 by default)
      container.querySelectorAll('.media-card').forEach(card => { card.style.opacity = '1'; });
      // Trigger entrance animation for newly inserted cards
      try { requestAnimationFrame(() => animateCards()); } catch (_) {}
      // Bind card controls
      container.querySelectorAll('.media-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
      });
      container.querySelectorAll('[data-action="preview"]').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const button = e.currentTarget;
          const type = button.dataset.type;
          const src = button.dataset.src;
          const name = button.dataset.name;
          openMediaPreview(type, src, name);
        });
      });
      container.querySelectorAll('[data-action="delete"]').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          const id = e.currentTarget.dataset.id;
          if (!confirm('Delete this media?')) return;
          await deleteMedia(id);
          await refreshMedia();
        });
      });
    }

    function mediaCardTemplate(m) {
      const typeClass = m.type === 'Audio' ? 'audio' : (m.type === 'Video' ? 'video' : 'image');
      const created = (m.created_at || m.date || '').toString().split('T')[0];
      let preview = '';
      if (m.type === 'Gambar') {
        preview = `<img src="${fileUrl(m.file_path)}" alt="${escapeHtml(m.name)}" class="img-fluid rounded"/>`;
      } else if (m.type === 'Video') {
        const src = fileUrl(m.file_path);
        // If YouTube URL, render iframe embed instead of <video>
        const yt = String(src).match(/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]{11})/i);
        if (yt) {
          const vid = yt[1];
          preview = `<div class="ratio ratio-16x9"><iframe src="https://www.youtube.com/embed/${vid}?autoplay=1&mute=1&playsinline=1" title="${escapeHtml(m.name)}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded"></iframe></div>`;
        } else {
          const mime = guessMimeFromPath(m.file_path, 'video/mp4');
          preview = `<video class="w-100 rounded" controls preload="metadata" autoplay muted playsinline>
            <source src="${src}" type="${mime}">
            Browser Anda tidak mendukung pemutar video.
          </video>`;
        }
      } else if (m.type === 'Audio') {
        const src = fileUrl(m.file_path);
        const mime = guessMimeFromPath(m.file_path, 'audio/mpeg');
        preview = `<div class="audio-player-container"><audio class="js-player" controls preload="metadata" playsinline>
          <source src="${src}" type="${mime}">
          Your browser does not support audio playback.
        </audio></div>`;
      } else {
        // Fallback: unknown type from API (e.g., 'image', 'video', 'audio')
        const src = fileUrl(m.file_path || '');
        const niceType = (m.type || 'Media');
        const name = escapeHtml(m.name || 'Untitled');
        const link = src ? `<a href="${src}" target="_blank" rel="noopener">Open file</a>` : '';
        preview = `<div class="p-3 text-center text-muted">
          <div class="mb-2"><i class="bi bi-file-earmark"></i></div>
          <div class="small">${niceType} preview not available</div>
          <div class="small">${name}</div>
          <div>${link}</div>
        </div>`;
      }
      return `
        <div class="media-card">
          <div class="media-card-header">
            <h5 class="media-title mb-0">${escapeHtml(m.name)}</h5>
            <span class="media-badge ${typeClass}">${m.type}</span>
          </div>
          <div class="media-card-body">
            <div class="media-date"><i class="bi bi-calendar3 me-1"></i>${created || '-'}</div>
            <div class="media-preview">${preview}</div>
            <div class="d-flex align-items-center justify-content-between">
              <div class="form-check">
                <input class="form-check-input checkbox-enhanced media-checkbox" type="checkbox" value="${m.id}" data-id="${m.id}">
                <label class="form-check-label">Select</label>
              </div>
              <div class="media-actions">
                <button class="btn-enhanced btn-preview" data-action="preview" data-id="${m.id}" data-type="${m.type}" data-src="${fileUrl(m.file_path)}" data-name="${escapeHtml(m.name)}">
                  <i class="bi bi-eye"></i> Preview
                </button>
                <button class="btn-enhanced btn-delete" data-action="delete" data-id="${m.id}">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </div>
            </div>
          </div>
        </div>`;
    }

    function getSelectedIds() {
      const boxes = document.querySelectorAll('.media-checkbox:checked');
      return Array.from(boxes).map(b => b.value);
    }

    function updateSelectedCount() {
      const count = getSelectedIds().length;
      const el = document.getElementById('selectedCount');
      if (el) el.textContent = `${count} selected`;
      
      // Show/hide bulk actions based on selection
      const bulkActions = document.querySelector('.bulk-actions');
      if (bulkActions) {
        if (count > 0) {
          bulkActions.classList.add('show');
        } else {
          bulkActions.classList.remove('show');
        }
      }
    }

    async function refreshMedia() { return fetchMedia({}); }
    function applyAdvancedFilters() { fetchMedia({}); }

    async function toggleLanding(mediaIds, desiredStatus = null) {
      if (!mediaIds || !mediaIds.length) return toast('Please select media first', 'error');
      try {
        showLoading(true);
        let ids = [...mediaIds];
        if (desiredStatus !== null) {
          // Ensure the first ID has opposite status to force desired outcome using toggle endpoint
          const map = new Map(state.media.map(m => [String(m.id), !!m.show_on_landing]));
          const existsOpposite = ids.find(id => map.get(String(id)) !== !!desiredStatus);
          if (existsOpposite) {
            // Put an opposite-status item first
            ids = [existsOpposite, ...ids.filter(x => x !== existsOpposite)];
          } else {
            // All already in desired state; nothing to do
            toast('All media already in desired status');
            return;
          }
        }
        const res = await fetch(API.toggle, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: JSON.stringify({ media_ids: ids }),
        });
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Failed to change status');
        toast(json.message || 'Status changed successfully');
      } catch (e) {
        console.error(e);
        toast('Error changing status', 'error');
      } finally {
        showLoading(false);
      }
    }

    async function deleteMedia(id) {
      try {
        showLoading(true);
        const res = await fetch(API.destroy(id), {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest',
          },
        });
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Failed to delete media');
        toast(json.message || 'Media deleted');
      } catch (e) {
        console.error(e);
        toast('Error deleting media', 'error');
      } finally {
        showLoading(false);
      }
    }

    function initSelectAllHandlers() {
      const selAll = document.getElementById('selectAll');
      const selAllTable = document.getElementById('selectAllTable');
      if (selAll) {
        selAll.addEventListener('change', () => {
          document.querySelectorAll('.media-checkbox').forEach(cb => cb.checked = selAll.checked);
          updateSelectedCount();
        });
      }
      if (selAllTable) {
        selAllTable.addEventListener('change', () => {
          document.querySelectorAll('.media-checkbox').forEach(cb => cb.checked = selAllTable.checked);
          updateSelectedCount();
        });
      }
    }

    function initBulkButtons() {
      const btnToggle = document.getElementById('btnBulkToggle');
      const btnShow = document.getElementById('btnBulkShow');
      const btnHide = document.getElementById('btnBulkHide');
      const btnShowSelected = document.getElementById('btnShowSelected');
      if (btnToggle) btnToggle.addEventListener('click', async () => { const ids = getSelectedIds(); await toggleLanding(ids); await refreshMedia(); });
      if (btnShow) btnShow.addEventListener('click', async () => { const ids = getSelectedIds(); await toggleLanding(ids, true); await refreshMedia(); });
      if (btnHide) btnHide.addEventListener('click', async () => { const ids = getSelectedIds(); await toggleLanding(ids, false); await refreshMedia(); });
      if (btnShowSelected) btnShowSelected.addEventListener('click', async () => { const ids = getSelectedIds(); await toggleLanding(ids, true); await refreshMedia(); });
    }

    function initPlyrPlayers() {
      // Initialize Plyr for any audio elements
      const players = document.querySelectorAll('audio.js-player');
      if (!players.length || typeof Plyr === 'undefined') return;
      players.forEach(el => {
        try {
          const instance = new Plyr(el, {
            controls: ['play', 'progress', 'current-time', 'mute', 'volume'],
            volume: 1,
            muted: false,
            storage: { enabled: false }
          });
          // also ensure underlying element isn't muted and has volume
          el.muted = false;
          el.volume = 1.0;
          el.addEventListener('play', () => {
            // force unmute on user interaction
            el.muted = false;
            if (el.volume === 0) el.volume = 1.0;
            try { if (instance) { instance.muted = false; instance.volume = 1; } } catch (e) {}
            console.debug('Audio play -> muted:', el.muted, 'volume:', el.volume);
          });
        } catch (e) { console.warn('Plyr init failed', e); }
      });
    }

    function wireMediaErrorHandlers() {
      document.querySelectorAll('audio, video').forEach(m => {
        m.addEventListener('error', () => {
          const src = (m.currentSrc || (m.querySelector('source')?.src) || '');
          console.error('Media load error:', src, m.error);
          toast('Failed to load media: ' + (src || 'unknown'), 'error');
        }, { once: true });
      });
    }

    

    function escapeHtml(str) {
      return String(str || '').replace(/[&<>"]+/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;'}[s] || s));
    }

    function openMediaPreview(type, src, name) {
      // Create modal if it doesn't exist
      let modal = document.getElementById('mediaPreviewModal');
      if (!modal) {
        modal = document.createElement('div');
        modal.id = 'mediaPreviewModal';
        modal.className = 'modal fade';
        modal.setAttribute('tabindex', '-1');
        modal.innerHTML = `
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="previewModalTitle">Preview Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body" id="previewModalBody" style="min-height: 300px;">
                <!-- Content will be inserted here -->
              </div>
            </div>
          </div>
        `;
        document.body.appendChild(modal);
      }

      const modalTitle = modal.querySelector('#previewModalTitle');
      const modalBody = modal.querySelector('#previewModalBody');
      
      modalTitle.textContent = `Preview: ${name}`;
      modalBody.innerHTML = '';

      if (type === 'Gambar') {
        const img = document.createElement('img');
        img.src = src;
        img.className = 'img-fluid rounded';
        img.style.maxHeight = '500px';
        img.style.width = '100%';
        img.style.objectFit = 'contain';
        modalBody.appendChild(img);
      } else if (type === 'Video') {
        // Check if it's a YouTube URL
        const ytMatch = src.match(/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]{11})/);
        if (ytMatch) {
          const iframe = document.createElement('iframe');
          iframe.width = '100%';
          iframe.height = '400';
          iframe.src = `https://www.youtube.com/embed/${ytMatch[1]}`;
          iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
          iframe.allowFullscreen = true;
          iframe.className = 'rounded';
          modalBody.appendChild(iframe);
        } else {
          const video = document.createElement('video');
          video.src = src;
          video.controls = true;
          video.className = 'w-100 rounded';
          video.style.maxHeight = '500px';
          modalBody.appendChild(video);
        }
      } else if (type === 'Audio') {
        const audio = document.createElement('audio');
        audio.src = src;
        audio.controls = true;
        audio.className = 'w-100';
        modalBody.appendChild(audio);
      }

      // Show modal using Bootstrap
      const bsModal = new bootstrap.Modal(modal);
      bsModal.show();
    }

    document.addEventListener('DOMContentLoaded', async () => {
      initSelectAllHandlers();
      initBulkButtons();
      initFilterButtons();
      await fetchMedia({});
    });

    // ====== Simple Audio Modal ======
    // Modal markup
    (function ensureAudioModal() {
      if (document.getElementById('playAudioModal')) return;
      const modal = document.createElement('div');
      modal.id = 'playAudioModal';
      modal.style.cssText = 'position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:rgba(0,0,0,0.6);z-index:1055;';
      modal.innerHTML = `
        <div style="background:#fff;border-radius:12px;max-width:520px;width:92%;box-shadow:0 10px 30px rgba(0,0,0,0.2);">
          <div style="padding:12px 16px;border-bottom:1px solid #eee;display:flex;align-items:center;justify-content:space-between;">
            <div class="fw-semibold" id="playAudioTitle">Play Audio</div>
            <button type="button" id="closePlayAudio" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x"></i></button>
          </div>
          <div style="padding:16px;">
            <audio id="playAudioElement" controls preload="metadata" style="width:100%" playsinline></audio>
          </div>
        </div>`;
      document.body.appendChild(modal);
      // close handlers
      modal.addEventListener('click', (e) => { if (e.target === modal) hidePlayModal(); });
      document.getElementById('closePlayAudio').addEventListener('click', hidePlayModal);
    })();

    function showPlayModal(src, title) {
      const modal = document.getElementById('playAudioModal');
      const audio = document.getElementById('playAudioElement');
      const ttl = document.getElementById('playAudioTitle');
      if (!modal || !audio) return;
      ttl && (ttl.textContent = title || 'Play Audio');
      // set source fresh each time
      audio.src = src;
      audio.muted = false; audio.volume = 1.0;
      modal.style.display = 'flex';
      // try play on user gesture
      audio.play().catch(() => {/* user can press play */});
    }

    function hidePlayModal() {
      const modal = document.getElementById('playAudioModal');
      const audio = document.getElementById('playAudioElement');
      if (!modal || !audio) return;
      audio.pause();
      audio.removeAttribute('src');
      audio.load();
      modal.style.display = 'none';
    }

    // Delegate click for Play button
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.btn-play');
      if (!btn) return;
      const src = btn.getAttribute('data-src');
      const name = btn.getAttribute('data-name') || 'Audio';
      if (src) showPlayModal(src, name);
    });

    // Page transition functionality
    function showPageTransition() {
      const transition = document.getElementById('pageTransition');
      if (transition) {
        transition.classList.add('active');
      }
    }

    function hidePageTransition() {
      const transition = document.getElementById('pageTransition');
      if (transition) {
        transition.classList.remove('active');
      }
    }

    // Add smooth page transitions to navigation links
    document.addEventListener('DOMContentLoaded', function() {
      const navLinks = document.querySelectorAll('.nav-link[href]');
      
      navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          
          // Skip if it's the current page or a form submission
          if (href === '#' || this.closest('form')) return;
          
          e.preventDefault();
          showPageTransition();
          
          // Navigate after transition starts
          setTimeout(() => {
            window.location.href = href;
          }, 200);
        });
      });

      // Hide transition on page load
      setTimeout(hidePageTransition, 100);
    });

    // Add staggered animation to cards
    function animateCards() {
      const cards = document.querySelectorAll('.stats-card, .media-card');
      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.style.animation = 'slideInUp 0.6s ease-out forwards';
      });
    }

    // Call animation when page loads
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(animateCards, 300);
    });

    // Add CSS for card animations
    const style = document.createElement('style');
    style.textContent = `
      @keyframes slideInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      .stats-card, .media-card {
        opacity: 0;
      }
      
      .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      }
      
      .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>