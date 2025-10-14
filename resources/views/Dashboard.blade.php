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
      overflow-x: hidden;
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

    <!-- Active Audio Schedule Section -->
    @if(isset($activeAudioSchedules) && $activeAudioSchedules->count() > 0)
    <div class="dashboard-section">
      <div class="section-header">
        <h3 class="section-title">
          <i class="bi bi-music-note-beamed"></i>
          Audio Terjadwal Aktif
        </h3>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-success">{{ $activeAudioSchedules->count() }} Audio</span>
          <button class="btn btn-sm btn-outline-primary" id="refreshAudioSchedules">
            <i class="bi bi-arrow-clockwise"></i> Refresh
          </button>
        </div>
      </div>
      
      <div class="section-content">
        <div id="audioScheduleContainer" class="row g-3 p-3">
          @foreach($activeAudioSchedules as $schedule)
          <div class="col-md-6 col-lg-4">
            <div class="card border-success">
              <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">{{ $schedule->media->name }}</h6>
                <span class="badge bg-light text-success">{{ $schedule->display_duration }}s</span>
              </div>
              <div class="card-body">
                <div class="mb-2">
                  <small class="text-muted">
                    <i class="bi bi-calendar3"></i> 
                    {{ $schedule->start_date }} - {{ $schedule->end_date }}
                  </small>
                </div>
                @if($schedule->day_of_week)
                <div class="mb-2">
                  <small class="text-muted">
                    <i class="bi bi-calendar-week"></i> 
                    {{ ucfirst($schedule->day_of_week) }}
                  </small>
                </div>
                @endif
                @if($schedule->time)
                <div class="mb-3">
                  <small class="text-muted">
                    <i class="bi bi-clock"></i> 
                    {{ $schedule->time->format('H:i') }}
                  </small>
                </div>
                @endif
                
                <div class="audio-player-container mb-2">
                  <audio class="scheduled-audio" controls preload="metadata" 
                         data-schedule-id="{{ $schedule->id }}"
                         data-duration="{{ $schedule->display_duration }}"
                         data-auto-rotate="false">
                    <source src="{{ asset('storage/' . $schedule->media->file_path) }}" type="audio/mpeg">
                    Your browser does not support audio playback.
                  </audio>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                  <div class="form-check form-switch">
                    <input class="form-check-input auto-play-toggle" type="checkbox" 
                           data-schedule-id="{{ $schedule->id }}"
                           {{ $schedule->isCurrentlyActive() ? 'checked' : '' }}>
                    <label class="form-check-label">
                      <small>Auto Play</small>
                    </label>
                  </div>
                  <button class="btn btn-sm btn-success play-scheduled-audio" 
                          data-schedule-id="{{ $schedule->id }}">
                    <i class="bi bi-play-fill"></i> Play
                  </button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

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
          @forelse($media as $item)
            <div class="media-card" data-id="{{ $item->id }}">
              <div class="media-card-header">
                <h5 class="media-title mb-0">{{ $item->name }}</h5>
                <span class="media-badge {{ strtolower($item->type) }}">{{ $item->type }}</span>
              </div>
              <div class="media-card-body">
                <div class="media-date">
                  <i class="bi bi-calendar3 me-1"></i>{{ $item->created_at ? $item->created_at->format('Y-m-d') : $item->date }}
                </div>
                <div class="media-preview">
                  @if($item->type === 'Gambar')
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->name }}" class="img-fluid rounded"/>
                  @elseif($item->type === 'Video')
                    <video class="w-100 rounded" controls preload="metadata">
                      <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                      Browser Anda tidak mendukung pemutar video.
                    </video>
                  @elseif($item->type === 'Audio')
                    <div class="audio-player-container">
                      <audio class="js-player" controls preload="metadata">
                        <source src="{{ asset('storage/' . $item->file_path) }}" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                      </audio>
                    </div>
                  @endif
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="form-check">
                    <input class="form-check-input checkbox-enhanced media-checkbox" type="checkbox" value="{{ $item->id }}" data-id="{{ $item->id }}">
                    <label class="form-check-label">Select</label>
                  </div>
                  <div class="media-actions">
                    <button class="btn-enhanced btn-preview" data-action="preview" data-id="{{ $item->id }}" data-type="{{ $item->type }}" data-src="{{ asset('storage/' . $item->file_path) }}" data-name="{{ $item->name }}">
                      <i class="bi bi-eye"></i> Preview
                    </button>
                    <button class="btn-enhanced btn-delete" data-action="delete" data-id="{{ $item->id }}">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="empty-state w-100">
              <i class="bi bi-folder-x"></i>
              <div>No media found.</div>
            </div>
          @endforelse
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
      // Use the direct media serving route
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

    async function checkFileExists(url) {
      try {
        const response = await fetch(url, { method: 'HEAD' });
        return response.ok;
      } catch (e) {
        console.error('File check error:', e);
        return false;
      }
    }

    let isProcessing = false;

    async function renderMediaGrid(items) {
      const container = document.getElementById('mediaContainer');
      if (!container || isProcessing) return;
      
      try {
        isProcessing = true;
        showLoading(true);
        
        console.debug('[renderMediaGrid] items:', Array.isArray(items) ? items.length : 'non-array');
        
        if (!items.length) {
          container.innerHTML = `
            <div class="empty-state w-100">
              <i class="bi bi-folder-x"></i>
              <div>No media found.</div>
            </div>`;
          container.style.display = 'grid';
          return;
        }

        // Process items in batches to prevent too many simultaneous requests
        const batchSize = 3;
        const validItems = [];
        const itemsToDelete = [];

        for (let i = 0; i < items.length; i += batchSize) {
          const batch = items.slice(i, i + batchSize);
          const checkResults = await Promise.all(
            batch.map(async (item) => {
              const fileUrl = `${window.location.origin}/storage/${item.file_path}`;
              const exists = await checkFileExists(fileUrl);
              return { item, exists };
            })
          );

          checkResults.forEach(({ item, exists }) => {
            if (exists) {
              validItems.push(item);
            } else {
              itemsToDelete.push(item);
            }
          });
        }

        // Delete invalid items one at a time
        if (itemsToDelete.length > 0) {
          console.log(`Found ${itemsToDelete.length} invalid items to remove`);
          for (const item of itemsToDelete) {
            try {
              await deleteMedia(item.id);
              await new Promise(resolve => setTimeout(resolve, 500)); // Add delay between deletions
            } catch (e) {
              console.error('Auto-delete failed:', e);
            }
          }
        }
      try {
        // Only render if we still have the container
        if (container) {
          container.innerHTML = validItems.map(m => mediaCardTemplate(m)).join('');
          // Update state with only valid items
          state.media = validItems;
          
          // Ensure the grid is visible after re-render
          container.style.display = 'grid';
          console.debug('[renderMediaGrid] rendered cards:', container.children.length);
          
          // Make sure cards are visible
          container.querySelectorAll('.media-card').forEach(card => { 
            card.style.opacity = '1'; 
          });
          
          // Trigger animations
          requestAnimationFrame(() => animateCards());
          
          // Update stats with valid items only
          updateStats(validItems);
        }
      } catch (e) {
        console.error('Render error:', e);
      } finally {
        // Always reset processing flag and hide loading
        isProcessing = false;
        showLoading(false);
      }
      
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
          if (!confirm('Apakah Anda yakin ingin menghapus media ini?')) return;
          
          await deleteMedia(id);
          
          // Only refresh the entire grid if there are no media items left
          if (document.querySelectorAll('.media-card').length === 0) {
            await refreshMedia();
          }
        });
      });
    }

    function mediaCardTemplate(m) {
      const typeClass = m.type === 'Audio' ? 'audio' : (m.type === 'Video' ? 'video' : 'image');
      const created = (m.created_at || m.date || '').toString().split('T')[0];
      let preview = '';
      if (m.type === 'Gambar') {
        preview = `<img src="${fileUrl(m.file_path)}" alt="${escapeHtml(m.name)}" class="img-fluid rounded" onerror="toast('Failed to load image', 'error')"/>`;
      } else if (m.type === 'Video') {
        const src = fileUrl(m.file_path);
        // If YouTube URL, render iframe embed instead of <video>
        const yt = String(src).match(/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]{11})/i);
        if (yt) {
          const vid = yt[1];
          preview = `<div class="ratio ratio-16x9"><iframe src="https://www.youtube.com/embed/${vid}?autoplay=1&mute=1&playsinline=1" title="${escapeHtml(m.name)}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded"></iframe></div>`;
        } else {
          const mime = guessMimeFromPath(m.file_path, 'video/mp4');
          preview = `<video class="w-100 rounded" controls preload="metadata" autoplay muted playsinline onerror="toast('Failed to load video', 'error')">
            <source src="${src}" type="${mime}">
            Browser Anda tidak mendukung pemutar video.
          </video>`;
        }
      } else if (m.type === 'Audio') {
        const src = fileUrl(m.file_path);
        const mime = guessMimeFromPath(m.file_path, 'audio/mpeg');
        preview = `<div class="audio-player-container"><audio class="js-player" controls preload="metadata" playsinline onerror="toast('Failed to load audio', 'error')">
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

    async function refreshMedia() { 
      try {
        showLoading(true);
        await fetchMedia({});
      } catch (e) {
        console.error('Refresh error:', e);
        toast('Error refreshing media list', 'error');
      } finally {
        showLoading(false);
      }
    }
    
    function applyAdvancedFilters() { 
      fetchMedia({}); 
    }

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
      if (!id) {
        toast('Invalid media ID', 'error');
        return false;
      }
      
      try {
        showLoading(true);
        
        // Find the media item in state
        const mediaItem = state.media.find(m => m.id === id);
        if (mediaItem) {
          // Check if file exists before attempting delete
          const fileUrl = `${window.location.origin}/storage/${mediaItem.file_path}`;
          const exists = await checkFileExists(fileUrl);
          if (!exists) {
            console.log('File already missing, proceeding with database cleanup');
          }
        }
        
        const res = await fetch(`/dashboard/media/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          credentials: 'same-origin'
        });

        if (!res.ok) {
          const json = await res.json();
          throw new Error(json.message || 'Failed to delete media');
        }

        const json = await res.json();
        
        // Remove the media from state immediately
        state.media = state.media.filter(m => m.id !== id);
        
        // Remove the card from DOM
        const card = document.querySelector(`.media-card[data-id="${id}"]`);
        if (card) {
          card.remove();
        }
        
        // Update stats and UI
        updateStats(state.media);
        updateSelectedCount();
        
        toast(json.message || 'Media deleted', 'success');
        return true;
      } catch (e) {
        console.error('Delete error:', e);
        if (e.message.includes('not found') || e.message.includes('tidak ditemukan')) {
          // If media is not found, remove it from the UI anyway
          const card = document.querySelector(`.media-card[data-id="${id}"]`);
          if (card) {
            card.remove();
            state.media = state.media.filter(m => m.id !== id);
            updateStats(state.media);
            updateSelectedCount();
          }
        }
        toast('Error deleting media: ' + (e.message || 'Unknown error'), 'error');
        return false;
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
        img.onerror = function() {
          toast('Failed to load image', 'error');
        };
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
          video.onerror = function() {
            toast('Failed to load video', 'error');
          };
          modalBody.appendChild(video);
        }
      } else if (type === 'Audio') {
        const audio = document.createElement('audio');
        audio.src = src;
        audio.controls = true;
        audio.className = 'w-100';
        audio.onerror = function() {
          toast('Failed to load audio', 'error');
        };
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

    // ===== AUDIO SCHEDULING SYSTEM =====
    let audioScheduleCheckInterval;
    let currentlyPlayingAudio = null;
    let audioQueue = [];
    let isAutoPlayEnabled = false;

    // Initialize audio scheduling system
    function initAudioSchedulingSystem() {
      console.log('🎵 Initializing audio scheduling system...');
      
      // Check for active audio schedules immediately
      checkAudioSchedules();
      
      // Set up periodic checking every 30 seconds
      audioScheduleCheckInterval = setInterval(checkAudioSchedules, 30000);
      
      // Initialize scheduled audio players
      initScheduledAudioPlayers();
      
      // Initialize refresh button
      const refreshBtn = document.getElementById('refreshAudioSchedules');
      if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshAudioSchedules);
      }
    }

    async function checkAudioSchedules() {
      try {
        console.log('🎵 Dashboard: Checking for audio schedules...');
        const response = await fetch('/api/dashboard/audio-schedules', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'same-origin'
        });

        if (response.ok) {
          const data = await response.json();
          console.log('🎵 Dashboard: API Response:', data);
          
          if (data.success && data.schedules) {
            console.log(`🎵 Dashboard: Found ${data.schedules.length} audio schedules`);
            
            if (data.schedules.length > 0) {
              console.log(`🎵 Dashboard: Processing ${data.schedules.length} active audio schedules`);
              handleDashboardAudioSchedules(data.schedules);
            } else {
              console.log('⏸️ Dashboard: No audio schedules found');
            }
          } else {
            console.log('⏸️ Dashboard: No schedules in response');
          }
        } else {
          console.error('❌ Dashboard: API response not ok:', response.status);
        }

      } catch (error) {
        console.error('❌ Dashboard: Error checking audio schedules:', error);
      }
    }

    function handleDashboardAudioSchedules(schedules) {
      // Update audio queue - no auto-rotate, play once only
      audioQueue = schedules.map(schedule => ({
        id: schedule.id,
        name: schedule.media.name,
        src: `/storage/${schedule.media.file_path}`,
        duration: schedule.display_duration,
        autoRotate: false
      }));

      // Dashboard audio scheduling is independent - no auto-play to landing page
      console.log(`🎵 Dashboard: Audio queue updated with ${audioQueue.length} items (play once only)`);
      
      // Auto-play first audio if queue has items and no audio is currently playing
      if (audioQueue.length > 0 && !currentlyPlayingAudio) {
        console.log('🎵 Dashboard: Auto-playing first scheduled audio');
        playNextScheduledAudio();
      }
    }

    function playNextScheduledAudio() {
      if (audioQueue.length === 0) return;
      
      const nextAudio = audioQueue.shift();
      console.log(`🎵 Dashboard: Playing scheduled audio: ${nextAudio.name}`);

      // Create audio element dynamically since we don't have pre-existing elements
      const audioElement = document.createElement('audio');
      audioElement.src = nextAudio.src;
      audioElement.volume = 0.7;
      audioElement.setAttribute('data-schedule-id', nextAudio.id);
      audioElement.setAttribute('data-duration', nextAudio.duration);
      
      // Add to DOM temporarily
      document.body.appendChild(audioElement);
      if (audioElement) {
        currentlyPlayingAudio = {
          element: audioElement,
          duration: nextAudio.duration,
          autoRotate: nextAudio.autoRotate
        };

        audioElement.currentTime = 0;
        audioElement.play().then(() => {
          console.log(`🎵 Dashboard: Playing scheduled audio: ${nextAudio.name} for ${nextAudio.duration}s`);
          
          // Show audio popup notification
          showAudioPopup(nextAudio);
          
          // Auto-stop after duration - play once only, no looping
          setTimeout(() => {
            audioElement.pause();
            audioElement.currentTime = 0;
            audioElement.remove(); // Remove from DOM
            currentlyPlayingAudio = null;
            hideAudioPopup();
            console.log(`🎵 Dashboard: Audio playback completed - stopped after ${nextAudio.duration}s`);
            // Do not continue to next audio - play once only
          }, nextAudio.duration * 1000);
        }).catch(error => {
          console.error('❌ Dashboard: Error playing audio:', error);
          audioElement.remove(); // Remove from DOM on error
          currentlyPlayingAudio = null;
        });
      }
    }

    function initScheduledAudioPlayers() {
      // Initialize play buttons for scheduled audio
      document.querySelectorAll('.play-scheduled-audio').forEach(button => {
        button.addEventListener('click', function() {
          const scheduleId = this.dataset.scheduleId;
          const audioElement = document.querySelector(`audio[data-schedule-id="${scheduleId}"]`);
          
          if (audioElement) {
            // Stop any currently playing audio
            if (currentlyPlayingAudio) {
              currentlyPlayingAudio.element.pause();
              currentlyPlayingAudio = null;
            }
            
            // Play this audio
            audioElement.currentTime = 0;
            audioElement.play().then(() => {
              const duration = parseInt(audioElement.dataset.duration) || 10;
              console.log(`🎵 Dashboard: Manual play: ${audioElement.dataset.scheduleId} for ${duration}s`);
              
              // Auto-stop after duration - play once only, no looping
              setTimeout(() => {
                audioElement.pause();
                audioElement.currentTime = 0;
                console.log(`🎵 Dashboard: Manual playback completed - stopped after ${duration}s`);
                // Do not continue to next audio - play once only
              }, duration * 1000);
            }).catch(error => {
              console.error('❌ Dashboard: Error playing audio:', error);
              toast('Failed to play audio', 'error');
            });
          }
        });
      });

      // Initialize auto-play toggles
      document.querySelectorAll('.auto-play-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
          const scheduleId = this.dataset.scheduleId;
          isAutoPlayEnabled = this.checked;
          
          console.log(`🔄 Auto-play ${isAutoPlayEnabled ? 'enabled' : 'disabled'} for schedule ${scheduleId}`);
          
          if (isAutoPlayEnabled) {
            // Start checking for active schedules more frequently
            if (audioScheduleCheckInterval) {
              clearInterval(audioScheduleCheckInterval);
            }
            audioScheduleCheckInterval = setInterval(checkAudioSchedules, 10000); // Every 10 seconds
            checkAudioSchedules(); // Check immediately
          } else {
            // Stop any currently playing audio
            if (currentlyPlayingAudio) {
              currentlyPlayingAudio.element.pause();
              currentlyPlayingAudio = null;
            }
            // Reset to normal checking interval
            if (audioScheduleCheckInterval) {
              clearInterval(audioScheduleCheckInterval);
            }
            audioScheduleCheckInterval = setInterval(checkAudioSchedules, 30000); // Every 30 seconds
          }
        });
      });
    }

    async function refreshAudioSchedules() {
      try {
        showLoading(true);
        
        // Just refresh audio schedules data, no page reload
        await checkAudioSchedules();
        toast('Audio schedules refreshed', 'success');
        
      } catch (error) {
        console.error('❌ Error refreshing audio schedules:', error);
        toast('Failed to refresh audio schedules', 'error');
      } finally {
        showLoading(false);
      }
    }

    // Initialize audio scheduling when page loads
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize audio scheduling system always - it will check for schedules
      setTimeout(initAudioSchedulingSystem, 1000);
    });

    // Clean up intervals when page unloads
    window.addEventListener('beforeunload', function() {
      if (audioScheduleCheckInterval) {
        clearInterval(audioScheduleCheckInterval);
      }
      if (currentlyPlayingAudio) {
        currentlyPlayingAudio.element.pause();
      }
    });

    // Audio popup functions for dashboard
    function showAudioPopup(audioData) {
      // Remove existing popup
      hideAudioPopup();
      
      const popup = document.createElement('div');
      popup.id = 'dashboardAudioPopup';
      popup.innerHTML = `
        <div style="
          position: fixed;
          top: 20px;
          right: 20px;
          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
          color: white;
          padding: 15px 20px;
          border-radius: 12px;
          box-shadow: 0 8px 32px rgba(0,0,0,0.3);
          z-index: 9999;
          min-width: 280px;
          backdrop-filter: blur(10px);
          border: 1px solid rgba(255,255,255,0.2);
          animation: slideInRight 0.3s ease-out;
        ">
          <div style="display: flex; align-items: center; gap: 12px;">
            <div style="
              width: 40px;
              height: 40px;
              background: rgba(255,255,255,0.2);
              border-radius: 50%;
              display: flex;
              align-items: center;
              justify-content: center;
              animation: pulse 2s infinite;
            ">
              <i class="bi bi-music-note-beamed" style="font-size: 18px;"></i>
            </div>
            <div style="flex: 1;">
              <div style="font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                🎵 Audio Dashboard
              </div>
              <div style="font-size: 12px; opacity: 0.9;">
                ${audioData.name} (${audioData.duration}s)
              </div>
            </div>
            <button onclick="hideAudioPopup()" style="
              background: rgba(255,255,255,0.2);
              border: none;
              color: white;
              width: 24px;
              height: 24px;
              border-radius: 50%;
              cursor: pointer;
              display: flex;
              align-items: center;
              justify-content: center;
            ">×</button>
          </div>
        </div>
      `;
      
      document.body.appendChild(popup);
      
      // Add animations
      const style = document.createElement('style');
      style.textContent = `
        @keyframes slideInRight {
          from { transform: translateX(100%); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
        @keyframes pulse {
          0%, 100% { transform: scale(1); }
          50% { transform: scale(1.1); }
        }
      `;
      document.head.appendChild(style);
    }

    function hideAudioPopup() {
      const popup = document.getElementById('dashboardAudioPopup');
      if (popup) {
        popup.remove();
      }
    }

    // Make functions globally available
    window.hideAudioPopup = hideAudioPopup;

    // Debug functions
    window.checkAudioSchedules = checkAudioSchedules;
    window.playNextScheduledAudio = playNextScheduledAudio;
  </script>
</body>
</html>