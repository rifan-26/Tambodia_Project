<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tambodia - Super Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
  <style>
    body {
      background-color: #405672;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #2f3a55;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* Apply design system styles */
    .btn-primary {
      background-color: #1F9E76;
      color: #FFFFFF;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    
    /* Scrollable log table */
    .logs-container {
      max-height: 400px;
      overflow-y: auto;
      border-radius: 0.375rem;
      border: 1px solid #E0E7FF;
    }
    
    .logs-container::-webkit-scrollbar {
      width: 8px;
    }
    
    .logs-container::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .logs-container::-webkit-scrollbar-thumb {
      background: #1F9E76;
      border-radius: 10px;
    }
    
    .logs-container::-webkit-scrollbar-thumb:hover {
      background: #1a8a66;
    }

    .btn-primary:hover {
      background-color: #1a8a66;
    }

    .card {
      background: #FFFFFF;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
      padding: 1.5rem;
      border: none;
    }

    .card h5 {
      font-weight: 600;
      margin-bottom: 1rem;
      color: #273554;
    }

    .nav-link {
      color: #4b596a;
      padding: 11px 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover:not(.active) {
      background-color: #bcddc9;
      color: #1f9e76;
    }

    .nav-link.active {
      background-color: #1f9e76 !important;
      color: #fffff1 !important;
      font-weight: 600;
    }

    .user-badge {
      background: linear-gradient(90deg, #58CBA9, #7CB8F4);
      padding: 0.35rem 1rem;
      border-radius: 2rem;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .user-badge .status-indicator {
      width: 16px;
      height: 16px;
      background-color: #44d69e;
      border-radius: 50%;
      box-shadow: 0 0 6px #44d69eaa;
    }

    .sidebar {
      background: linear-gradient(180deg, #E7FFEA 0%, #FFFFFF 50%, #DCEDFF 100%);
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

    .content-area {
      margin-left: 240px;
      padding: 1.75rem 2rem 2rem 2rem;
      min-height: 100vh;
      background: linear-gradient(90deg, #FFFFFF, #E9EDFA);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .header-top h2 {
      margin: 0;
      font-weight: 600;
      font-size: 1.5rem;
      color: #2c3a67;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      background-color: #FFFFFF;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
    }

    .table thead {
      background-color: #E0E7FF;
    }

    .table thead th {
      color: #1150b6;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #C7D2FE;
    }

    .text-color {
      color : #1150b6;
    }

    .table tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #E0E7FF;
      color: #475569;
    }

    .table tbody tr:hover {
      background-color: #F1F5F9;
    }

    /* Scrollable admin table similar to logs */
    .admin-container {
      max-height: 400px;
      overflow-y: auto;
      border-radius: 0.375rem;
      border: 1px solid #E0E7FF;
    }
    .admin-container::-webkit-scrollbar {
      width: 8px;
    }
    .admin-container::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    .admin-container::-webkit-scrollbar-thumb {
      background: #1F9E76;
      border-radius: 10px;
    }
    .admin-container::-webkit-scrollbar-thumb:hover {
      background: #1a8a66;
    }

    /* Professional filter + search styling */
    .toolbox { display: flex; gap: 0.5rem; align-items: center; }
    .select-wrap { position: relative; }
    .btn-select {
      appearance: none;
      background-color: #ffffff;
      color: #1F2937;
      border: 1px solid #E5E7EB;
      padding: 0.45rem 2rem 0.45rem 0.65rem;
      border-radius: 0.5rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 1px 2px rgba(0,0,0,0.04);
      min-width: 140px;
    }
    .select-wrap .chevron {
      position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
      font-size: 1rem; color: #6B7280; pointer-events: none;
    }
    .btn-select:focus {
      outline: none;
      border-color: #3B82F6;
      box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
    }
    .btn-select:hover { border-color: #D1D5DB; }
    .search-wrap { position: relative; }
    .search-input {
      background: #ffffff;
      border: 1px solid #E5E7EB;
      border-radius: 0.5rem;
      padding: 0.45rem 0.75rem 0.45rem 2rem;
      min-width: 220px;
      box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .search-wrap .bi-search { position: absolute; left: 8px; top: 50%; transform: translateY(-50%); color: #6B7280; }
    .search-input:focus { outline: none; border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }

    /* Media by Type card styles */
    .media-type-card .card-title {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .media-type-card .card-title::before {
      content: "\f3ee"; /* bi-bar-chart */
      font-family: "bootstrap-icons";
      color: #1F9E76;
    }
    .media-stats {
      display: grid;
      grid-template-columns: 1fr;
      gap: 0.75rem;
      margin-top: 0.25rem;
    }
    .media-item {
      background: #F8FAFC;
      border: 1px solid #E2E8F0;
      border-radius: 0.5rem;
      padding: 0.6rem 0.75rem;
    }
    .media-item-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.35rem;
      font-weight: 600;
      color: #334155;
    }
    .media-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.825rem;
      padding: 0.15rem 0.5rem;
      border-radius: 999px;
      background: #E0E7FF;
      color: #1E40AF;
      font-weight: 600;
    }
    .badge-gambar { background: #DCFCE7; color: #166534; }
    .badge-video  { background: #FEF9C3; color: #92400E; }
    .badge-audio  { background: #FFE4E6; color: #9F1239; }
    .media-meter {
      width: 100%;
      height: 10px;
      background: #E5E7EB;
      border-radius: 999px;
      overflow: hidden;
      position: relative;
    }
    .media-fill {
      height: 100%;
      border-radius: 999px;
      transition: width 0.6s ease;
    }
    .fill-gambar { background: linear-gradient(90deg, #34D399, #10B981); }
    .fill-video  { background: linear-gradient(90deg, #FBBF24, #F59E0B); }
    .fill-audio  { background: linear-gradient(90deg, #F87171, #EF4444); }

    /* Compact stacked bar version */
    .media-compact {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      text-align: left;
    }
    .stacked-bar {
      width: 100%;
      height: 14px;
      border-radius: 999px;
      overflow: hidden;
      background: #E5E7EB;
      box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
    }
    .stacked-segment { height: 100%; float: left; }
    .seg-gambar { background: linear-gradient(90deg, #34D399, #10B981); }
    .seg-video  { background: linear-gradient(90deg, #FBBF24, #F59E0B); }
    .seg-audio  { background: linear-gradient(90deg, #F87171, #EF4444); }
    .legend-inline { display: flex; gap: 0.5rem; flex-wrap: wrap; font-weight: 600; font-size: 0.8rem; color: #334155; margin-top: 0.25rem; line-height: 1.1; }
    .legend-chip { display: inline-flex; align-items: center; gap: 0.3rem; }
    .legend-audio { flex-basis: 100%; } /* move audio to next line */
    .chip-dot { width: 10px; height: 10px; border-radius: 999px; display: inline-block; }
    .dot-gambar { background: #10B981; }
    .dot-video  { background: #F59E0B; }
    .dot-audio  { background: #EF4444; }

    @media (max-width: 768px) {
      .sidebar {
        width: 60px;
        padding-top: 1rem;
      }
      
      .content-area {
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
      
      .nav-link.active {
        border-radius: 0;
      }
      
      .sidebar-header h1 {
        font-size: 0;
      }
      
      .header-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
    }

    .text-bps-info {
      color: #005b96;
      font-weight: 500;
    }

    .text-bps-success {
      color: #028e36; 
      font-weight: 500;
    }

    .text-bps-danger {
      color: #8b0000; 
      font-weight: 500;
    }

  </style>
</head>

<body>
  <nav class="sidebar d-flex flex-column justify-content-between">
    <div>
      <div class="sidebar-header d-flex align-items-center gap-2">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" style="width:70px; height:70px; margin-left:20px; object-fit:contain;"/>
        <h1 class="sidebar-title" style="font-weight: 700; font-size: 1.25rem; margin: 0; display: flex; align-items: center;">
            <span class="title-text">
                <span style="color: #0084d6;">Tam</span><span style="color: #a0d5d2;">bo</span><span style="color: #1f9e76;">dia</span>
            </span>
        </h1>
      </div>
      <ul class="nav flex-column px-1">
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ url('/superadmin') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/superakun') }}">
            <i class="bi bi-person"></i> Admin
          </a>
        </li>
        <li class="nav-item mb-1">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
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
      <h2>Dashboard Super Admin</h2>
      <div class="user-badge" title="Logged in as Admin">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name ?? 'Super Admin' }}</span>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Total Media</h5>
            <h2 class="text-color">{{ $totalMedia ?? 0 }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Total Pegawai</h5>
            <h2 class="text-success">{{ $totalPegawai ?? 0 }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Total Superadmin</h5>
            <h2 class="text-danger">{{ $totalSuperadmin ?? 0 }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Media by Type</h5>
            @php
              $cntGambar = (int)($mediaByType['Gambar'] ?? 0);
              $cntVideo  = (int)($mediaByType['Video']  ?? 0);
              $cntAudio  = (int)($mediaByType['Audio']  ?? 0);
              $cntTotal  = max(1, $cntGambar + $cntVideo + $cntAudio);
              $pGambar   = round(($cntGambar / $cntTotal) * 100);
              $pVideo    = round(($cntVideo  / $cntTotal) * 100);
              $pAudio    = round(($cntAudio  / $cntTotal) * 100);
            @endphp

            <div class="media-compact" aria-describedby="media-type-legend">
              <div class="stacked-bar" role="img" aria-label="Komposisi media: Gambar {{ $pGambar }} persen, Video {{ $pVideo }} persen, Audio {{ $pAudio }} persen">
                <div class="stacked-segment seg-gambar" style="width: {{ $pGambar }}%" title="Gambar {{ $cntGambar }} ({{ $pGambar }}%)"></div>
                <div class="stacked-segment seg-video"  style="width: {{ $pVideo }}%"  title="Video {{ $cntVideo }} ({{ $pVideo }}%)"></div>
                <div class="stacked-segment seg-audio"  style="width: {{ $pAudio }}%"  title="Audio {{ $cntAudio }} ({{ $pAudio }}%)"></div>
              </div>
              <div id="media-type-legend" class="legend-inline">
                <span class="legend-chip"><span class="chip-dot dot-gambar"></span> Gambar {{ $cntGambar }} ({{ $pGambar }}%)</span>
                <span class="legend-chip"><span class="chip-dot dot-video"></span> Video {{ $cntVideo }} ({{ $pVideo }}%)</span>
                <span class="legend-chip legend-audio"><span class="chip-dot dot-audio"></span> Audio {{ $cntAudio }} ({{ $pAudio }}%)</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Admin Management Section -->
    <div class="card mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Daftar Admin</h5>
        <div class="toolbox">
          <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="adminSearch" class="search-input" placeholder="Cari nama atau email..." aria-label="Cari admin" />
          </div>
          <button id="adminSearchBtn" class="btn btn-primary" type="button" title="Cari">
            <i class="bi bi-search"></i>
          </button>
          <div class="select-wrap">
            <select id="adminRoleFilter" class="btn-select" aria-label="Filter peran">
              <option value="all" selected>Semua</option>
              <option value="pegawai">Pegawai</option>
              <option value="superadmin">Superadmin</option>
            </select>
            <span class="chevron"><i class="bi bi-chevron-down"></i></span>
          </div>
          <a href="{{ url('/superakun') }}" class="btn btn-primary">Kelola Admin</a>
        </div>
      </div>
      
      <div class="table-responsive admin-container">
        <table class="table table-hover" id="adminTable">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Tanggal Dibuat</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($admins) && $admins->count() > 0)
              @foreach($admins as $admin)
              <tr data-role="{{ $admin->role }}">
                <td class="row-no">{{ $loop->iteration }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->created_at->format('d M Y') }}</td>
              </tr>
              @endforeach
            @else
              <tr>
                <td colspan="4" class="text-center">Tidak ada data admin</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <!-- Activity Logs Section -->
    <div class="card">
      <h5>Aktivitas Akun Admin</h5>
      
      <div class="logs-container">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>User</th>
                <th>Aktivitas</th>
                <th>Deskripsi</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($recentLogs) && $recentLogs->count() > 0)
                @foreach($recentLogs as $log)
                <tr>
                  <td>{{ $log->user->name ?? 'Unknown User' }}</td>
                  <td>{{ $log->action }}</td>
                  <td>{{ $log->description }}</td>
                  <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="4" class="text-center">Tidak ada aktivitas</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function(){
      const filterSelect = document.getElementById('adminRoleFilter');
      const searchInput  = document.getElementById('adminSearch');
      const table = document.getElementById('adminTable');
      const searchBtn   = document.getElementById('adminSearchBtn');
      if (!table) return;

      function applyFilters(){
        const roleVal = (filterSelect?.value || 'all').toLowerCase();
        const q = (searchInput?.value || '').toLowerCase().trim();
        const rows = table.querySelectorAll('tbody tr');
        let no = 1;
        rows.forEach(tr => {
          const role = (tr.getAttribute('data-role') || '').toLowerCase();
          const cols = Array.from(tr.querySelectorAll('td')).map(td => (td.textContent || '').toLowerCase());
          const matchesRole = (roleVal === 'all') || (role === roleVal);
          const matchesSearch = !q || cols.some((txt, idx) => idx > 0 && txt.includes(q)); // search name/email/date
          const show = matchesRole && matchesSearch;
          tr.style.display = show ? '' : 'none';
          if (show) {
            const cell = tr.querySelector('.row-no');
            if (cell) cell.textContent = no++;
          }
        });
      }

      filterSelect?.addEventListener('change', applyFilters);
      searchInput?.addEventListener('input', applyFilters);
      searchBtn?.addEventListener('click', applyFilters);
      // Initial
      applyFilters();
    })();
  </script>
</body>
</html>
