<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Master Layout - BPS Sumatera Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
        }
        .sidebar {
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #092058 0%, #1345BE 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-header h4 {
            color: white;
            font-weight: 600;
            margin: 0;
        }
        .sidebar-nav {
            padding: 1rem 0;
        }
        .nav-item {
            margin-bottom: 0.5rem;
        }
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
        }
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
        }
        .page-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>BPS Sumatera Utara</h4>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('dashboard.pegawai') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('media.input') }}" class="nav-link">
                    <i class="bi bi-upload"></i>
                    Input Media
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('schedule.index') }}" class="nav-link">
                    <i class="bi bi-calendar3"></i>
                    Jadwal Media
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('layout') }}" class="nav-link active">
                    <i class="bi bi-grid-3x3-gap"></i>
                    Master Layout
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('staff.index') }}" class="nav-link">
                    <i class="bi bi-people"></i>
                    Staff Manager
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Master Layout</h1>
            <p class="text-muted mb-0">Pilih atau buat template untuk landing page</p>
        </div>

        <!-- Template Selector Content -->
        @include('components.template-selector-content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
