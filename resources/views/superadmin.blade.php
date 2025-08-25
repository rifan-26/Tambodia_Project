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
      color: #4B596A;
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover:not(.active) {
      background-color: #BCDDC9;
      color: #1F9E76;
    }

    .nav-link.active {
      background-color: #1F9E76 !important;
      color: #FFFFFF !important;
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
      color: #3B82F6;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #C7D2FE;
    }

    .table tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #E0E7FF;
      color: #475569;
    }

    .table tbody tr:hover {
      background-color: #F1F5F9;
    }

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
        <li class="nav-item mt-1">
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
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Total Media</h5>
            <h2 class="text-primary">{{ $totalMedia ?? 0 }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Total Pegawai</h5>
            <h2 class="text-success">{{ $totalPegawai ?? 0 }}</h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Media by Type</h5>
            <div class="d-flex justify-content-around">
              <span class="text-info">Gambar: {{ $mediaByType['Gambar'] ?? 0 }}</span>
              <span class="text-warning">Video: {{ $mediaByType['Video'] ?? 0 }}</span>
              <span class="text-danger">Audio: {{ $mediaByType['Audio'] ?? 0 }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Admin Management Section -->
    <div class="card mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Daftar Admin</h5>
        <a href="{{ url('/superakun') }}" class="btn btn-primary">Kelola Admin</a>
      </div>
      
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Tanggal Dibuat</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($admins) && $admins->count() > 0)
              @foreach($admins as $admin)
              <tr>
                <td>{{ $admin->id }}</td>
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
</body>
</html>
