<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Tambodia - Redesigned</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    :root {
      --brand-blue: #2c3a67;        /* headings, strong text */
      --primary: #1f9e76;           /* primary green */
      --primary-2: #58cbaa;         /* lighter green */
      --accent-blue: #0071BC;       /* B of BPS */
      --accent-lime: #8CC63F;       /* P of BPS */
      --accent-orange: #F7931E;     /* S of BPS */
      --bg-soft: #f8f9fa;           /* soft surfaces */
      --border-soft: #e9ecef;       /* soft borders */
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

    /* Enhanced Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1rem;
      margin-bottom: 1.25rem;
    }

    .stats-card {
      background: white;
      border-radius: 12px;
      padding: 1rem 1.25rem;
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
      border: none;
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--card-color), var(--card-color-light));
    }

    .stats-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }

    /* Theme-aligned stats colors */
    .stats-card.total { --card-color: var(--brand-blue); --card-color-light: var(--accent-blue); }
    .stats-card.audio { --card-color: #1976d2; --card-color-light: #63a4ff; }
    .stats-card.video { --card-color: #c2185b; --card-color-light: #f48fb1; }
    .stats-card.image { --card-color: #388e3c; --card-color-light: #66bb6a; }

    .stats-card-header {
      display: flex;
      justify-content: between;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .stats-icon {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      color: white;
      background: linear-gradient(135deg, var(--card-color), var(--card-color-light));
      margin-bottom: 0.5rem;
    }

    .stats-number {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--card-color);
      margin: 0;
      line-height: 1;
    }

    .stats-label {
      color: #6c757d;
      font-size: 0.9rem;
      font-weight: 500;
      margin-top: 0.25rem;
    }

    .stats-change {
      font-size: 0.8rem;
      font-weight: 600;
      margin-top: 0.25rem;
    }

    .stats-change.positive { color: #28a745; }
    .stats-change.negative { color: #dc3545; }

    /* Enhanced Media Section */
    .dashboard-section {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .section-header {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #2c3a67;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .section-content {
      padding: 0;
    }

    /* Filter removed */

    /* Enhanced Media Grid */
    .media-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 1rem;
      padding: 1rem 1.25rem;
    }

    .media-card {
      background: white;
      border: 1px solid #e9ecef;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .media-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      border-color: #1f9e76;
    }

    .media-card-header {
      padding: 0.75rem 1rem;
      background: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .media-title {
      font-weight: 600;
      color: #2c3a67;
      margin: 0;
      font-size: 1rem;
    }

    .media-badge {
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Match landing page chips */
    .media-badge.image { background-color: #e3f2fd; color: #1976d2; }
    .media-badge.video { background-color: #fce4ec; color: #c2185b; }
    .media-badge.audio { background-color: #e8f5e9; color: #388e3c; }

    .media-card-body {
      padding: 0.75rem 1rem;
      display: flex;
      flex-direction: column;
      flex: 1 1 auto;
    }

    .media-date {
      font-size: 0.85rem;
      color: #6c757d;
      margin-bottom: 1rem;
    }

    .media-preview {
      margin-bottom: 1rem;
      border-radius: 8px;
      overflow: hidden;
    }

    .media-preview img,
    .media-preview video,
    .media-preview audio {
      width: 100%;
      max-height: 160px;
      object-fit: cover;
      display: block;
    }

    .media-actions {
      display: flex;
      gap: 0.5rem;
      justify-content: flex-end;
      margin-top: auto;
    }

    .btn-enhanced {
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.3s ease;
      border: none;
      padding: 0.5rem 1rem;
      font-size: 0.85rem;
    }

    .btn-toggle {
      background: linear-gradient(135deg, #1f9e76, #58cbaa);
      color: white;
    }

    .btn-toggle:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.3);
    }

    .btn-delete {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
    }

    .btn-delete:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Bulk Actions */
    .bulk-actions {
      padding: 1.5rem 2rem;
      background: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
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
      border-radius: 6px;
      font-size: 0.85rem;
      font-weight: 500;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-bulk-toggle {
      background: var(--brand-blue);
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
      background: var(--accent-blue);
      color: white;
    }

    .btn-bulk:hover {
      transform: translateY(-1px);
    }

    /* Audio Player Enhanced */
    .audio-player-container {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .plyr--audio .plyr__control.plyr__tab-focus,
    .plyr--audio .plyr__control:hover,
    .plyr--audio .plyr__control[aria-expanded=true] {
      background: #1f9e76;
    }

    .plyr--full-ui input[type=range] {
      color: #1f9e76;
    }

    .plyr__control--overlaid {
      background: #1f9e76;
    }

    /* Table removed */

    .checkbox-enhanced {
      width: 18px;
      height: 18px;
      accent-color: #1f9e76;
    }

    /* Button Actions */
    .action-buttons {
      display: flex;
      justify-content: flex-end;
      margin-top: 1.5rem;
      gap: 1rem;
    }

    .btn-action {
      padding: 0.75rem 2rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1rem;
      border: none;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .btn-action.primary {
      background: linear-gradient(135deg, #1f9e76, #58cbaa);
      color: white;
    }

    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
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

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 3rem 2rem;
      color: #6c757d;
    }

    .empty-state i {
      font-size: 4rem;
      margin-bottom: 1rem;
      opacity: 0.5;
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
      .stats-grid {
        grid-template-columns: 1fr;
      }
      .media-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
      }
      .filter-row {
        flex-direction: column;
        align-items: stretch;
      }
      .bulk-actions {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
      }
    }

    @media (max-width: 576px) {
      .media-card-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
      }
      .media-actions {
        flex-direction: column;
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
      <div class="sidebar-header d-flex align-items-center gap-2 mb-4">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" style="width:70px; height:70px; margin-left:20px; object-fit:contain;"/>
        <h1 class="sidebar-title">
            <span class="title-text">
                <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
            </span>
        </h1>
      </div>
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
        <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard Overview</h2>
        <div class="user-badge" title="Logged in as Admin">
            <span class="status-indicator" aria-label="online status"></span>
            <span>{{ Auth::user()->name ?? 'Username Admin' }}</span>
        </div>
    </div>
    
    <!-- Enhanced Stats Cards -->
    <div class="stats-grid">
      <div class="stats-card total">
        <div class="stats-icon">
          <i class="bi bi-collection"></i>
        </div>
        <div class="stats-number" id="totalMedia">0</div>
        <div class="stats-label">Total Media</div>
        <div class="stats-change positive">
        </div>
      </div>
      
      <div class="stats-card audio">
        <div class="stats-icon">
          <i class="bi bi-music-note"></i>
        </div>
        <div class="stats-number" id="totalAudio">0</div>
        <div class="stats-label">Audio Files</div>
        <div class="stats-change positive">
        </div>
      </div>
      
      <div class="stats-card video">
        <div class="stats-icon">
          <i class="bi bi-play-circle"></i>
        </div>
        <div class="stats-number" id="totalVideo">0</div>
        <div class="stats-label">Video Files</div>
        <div class="stats-change positive">
        </div>
      </div>
      
      <div class="stats-card image">
        <div class="stats-icon">
          <i class="bi bi-image"></i>
        </div>
        <div class="stats-number" id="totalImage">0</div>
        <div class="stats-label">Image Files</div>
        <div class="stats-change negative">
        </div>
      </div>
    </div>

    <!-- Enhanced Media Management Section -->
    <div class="dashboard-section">
      <div class="section-header">
        <h3 class="section-title">
          <i class="bi bi-folder2-open"></i>
          Manajemen Media
        </h3>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-primary btn-sm" onclick="refreshMedia()">
            <i class="bi bi-arrow-clockwise"></i> Refresh
          </button>
          <a href="{{ url('/input') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah Media
          </a>
        </div>
      </div>

      <!-- Enhanced Filter Section -->
      <div class="px-4 py-3 border-bottom" id="filterSection">
        <!-- Hidden select used by fetchMedia() -->
        <select id="jenisMedia" class="form-select form-select-sm d-none" aria-hidden="true">
          <option value="Semua Jenis" selected>Semua Jenis</option>
          <option value="Gambar">Gambar</option>
          <option value="Video">Video</option>
          <option value="Audio">Audio</option>
        </select>
        <div class="d-flex flex-wrap gap-2 align-items-center filter-row">
          <div class="me-2 text-muted fw-semibold">Filter:</div>
          <div class="btn-group" role="group" aria-label="Filter media">
            <button type="button" class="btn btn-outline-primary btn-sm filter-btn active" data-type="">
              <i class="bi bi-sliders me-1"></i> Semua
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-type="Gambar">
              <i class="bi bi-image me-1"></i> Gambar
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-type="Video">
              <i class="bi bi-play-circle me-1"></i> Video
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm filter-btn" data-type="Audio">
              <i class="bi bi-music-note me-1"></i> Audio
            </button>
          </div>
        </div>
      </div>

      <!-- Enhanced Bulk Actions -->
      <div class="bulk-actions">
        <div class="bulk-select">
          <div class="form-check">
            <input class="form-check-input checkbox-enhanced" type="checkbox" value="" id="selectAll">
            <label class="form-check-label fw-semibold" for="selectAll">
              Pilih Semua Media
            </label>
          </div>
          <span class="text-muted" id="selectedCount">0 dipilih</span>
        </div>
        <div class="bulk-buttons">
          <button type="button" id="btnBulkToggle" class="btn-bulk btn-bulk-toggle" data-bs-toggle="tooltip" title="Toggle tampil/sembunyi pada Landing untuk media yang dipilih">
            <i class="bi bi-shuffle"></i> Toggle
          </button>
          <button type="button" id="btnBulkShow" class="btn-bulk btn-bulk-show" data-bs-toggle="tooltip" title="Tampilkan semua media terpilih di Landing">
            <i class="bi bi-eye"></i> Tampilkan
          </button>
          <button type="button" id="btnBulkHide" class="btn-bulk btn-bulk-hide" data-bs-toggle="tooltip" title="Sembunyikan semua media terpilih dari Landing">
            <i class="bi bi-eye-slash"></i> Sembunyikan
          </button>
          <button type="button" class="btn-bulk btn-bulk-info" data-bs-toggle="tooltip" title="Media hanya akan tampil di Landing jika status 'Show on Landing' aktif dan (opsional) jadwalnya sedang aktif.">
            <i class="bi bi-info-circle"></i>
          </button>
        </div>
      </div>

      <!-- Enhanced Media Grid -->
      <div class="section-content">
        <div class="media-grid" id="mediaContainer">
            <!-- Sample media cards will be rendered here -->
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
      // Normalize path coming from backend:
      // - remove any leading '/'
      // - strip optional 'public/' prefix if present
      // - avoid duplicate 'storage/public/...'
      let p = String(path || '');
      p = p.replace(/^\/+/, '');
      p = p.replace(/^public\//, '');
      // Route through Laravel streaming endpoint to avoid symlink 403
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
        const jenisSelect = document.getElementById('jenisMedia');
        const typeVal = (params.type ?? (jenisSelect ? jenisSelect.value : '')).trim();
        const q = new URLSearchParams();
        if (typeVal && typeVal !== 'Semua Jenis') q.set('type', typeVal);
        const url = `${API.filter}?${q.toString()}`;
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const json = await res.json();
        if (!json.success) throw new Error(json.message || 'Gagal memuat media');
        state.media = Array.isArray(json.data) ? json.data : [];
        renderAll();
      } catch (e) {
        console.error(e);
        toast('Terjadi kesalahan saat memuat data media', 'error');
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
      const select = document.getElementById('jenisMedia');
      const buttons = document.querySelectorAll('.filter-btn');
      if (!select || !buttons.length) return;
      buttons.forEach(btn => {
        btn.addEventListener('click', () => {
          // toggle active state
          buttons.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          // set select value expected by backend and fetch
          const type = (btn.dataset.type || '').trim();
          select.value = type ? type : 'Semua Jenis';
          filterMedia();
        });
      });
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
      if (!items.length) {
        container.innerHTML = `
          <div class="empty-state w-100">
            <i class="bi bi-emoji-frown"></i>
            <div>Tidak ada media.</div>
          </div>`;
        return;
      }
      container.innerHTML = items.map(m => mediaCardTemplate(m)).join('');
      // Bind card controls
      container.querySelectorAll('.media-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
      });
      container.querySelectorAll('[data-action="toggle"]').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          const id = e.currentTarget.dataset.id;
          await toggleLanding([id]);
          await refreshMedia();
        });
      });
      container.querySelectorAll('[data-action="delete"]').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          const id = e.currentTarget.dataset.id;
          if (!confirm('Hapus media ini?')) return;
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
        const mime = guessMimeFromPath(m.file_path, 'video/mp4');
        preview = `<video class="w-100 rounded" controls preload="metadata" playsinline>
          <source src="${src}" type="${mime}">
          Browser Anda tidak mendukung pemutar video.
        </video>`;
      } else if (m.type === 'Audio') {
        const src = fileUrl(m.file_path);
        const mime = guessMimeFromPath(m.file_path, 'audio/mpeg');
        preview = `<div class="audio-player-container"><audio class="js-player" controls preload="metadata" playsinline>
          <source src="${src}" type="${mime}">
          Browser Anda tidak mendukung pemutar audio.
        </audio></div>`;
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
                <label class="form-check-label">Pilih</label>
              </div>
              <div class="media-actions">
                ${m.type === 'Audio' ? `
                <button class="btn-enhanced btn-play" data-action="play" data-id="${m.id}" data-src="${fileUrl(m.file_path)}" data-name="${escapeHtml(m.name)}">
                  <i class="bi bi-play-circle"></i> Play
                </button>
                ` : `
                <button class="btn-enhanced btn-toggle" data-action="toggle" data-id="${m.id}">
                  <i class="bi bi-shuffle"></i> Toggle
                </button>
                `}
                <button class="btn-enhanced btn-delete" data-action="delete" data-id="${m.id}">
                  <i class="bi bi-trash"></i> Hapus
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
      if (el) el.textContent = `${count} dipilih`;
    }

    async function refreshMedia() { return fetchMedia({}); }
    function filterMedia() { fetchMedia({}); }
    function applyAdvancedFilters() { fetchMedia({}); }

    async function toggleLanding(mediaIds, desiredStatus = null) {
      if (!mediaIds || !mediaIds.length) return toast('Pilih media terlebih dahulu', 'error');
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
            toast('Semua media sudah dalam status yang diinginkan');
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
        if (!json.success) throw new Error(json.message || 'Gagal mengubah status');
        toast(json.message || 'Berhasil mengubah status');
      } catch (e) {
        console.error(e);
        toast('Terjadi kesalahan saat mengubah status', 'error');
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
        if (!json.success) throw new Error(json.message || 'Gagal menghapus media');
        toast(json.message || 'Media dihapus');
      } catch (e) {
        console.error(e);
        toast('Terjadi kesalahan saat menghapus media', 'error');
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
          toast('Gagal memuat media: ' + (src || 'unknown'), 'error');
        }, { once: true });
      });
    }

    

    function escapeHtml(str) {
      return String(str || '').replace(/[&<>"]+/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;'}[s] || s));
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
            <div class="fw-semibold" id="playAudioTitle">Putar Audio</div>
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
      ttl && (ttl.textContent = title || 'Putar Audio');
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
  </script>