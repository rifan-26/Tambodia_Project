<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Master Profil - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  @include('components.global-audio-system')
</head>

<style>
  html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    opacity: 0;
    animation: pageLoad 0.6s ease-out forwards;
  }

  /* Page Load Animation */
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

  /* Fade In Up Animation */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Slide In Left Animation */
  @keyframes slideInLeft {
    from {
      opacity: 0;
      transform: translateX(-50px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  /* Slide In Right Animation */
  @keyframes slideInRight {
    from {
      opacity: 0;
      transform: translateX(50px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  /* Scale In Animation */
  @keyframes scaleIn {
    from {
      opacity: 0;
      transform: scale(0.9);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  /* Bounce In Animation */
  @keyframes bounceIn {
    0% {
      opacity: 0;
      transform: scale(0.3);
    }
    50% {
      opacity: 1;
      transform: scale(1.05);
    }
    70% {
      transform: scale(0.9);
    }
    100% {
      transform: scale(1);
    }
  }

  /* Sidebar Styles */
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
    z-index: 1000;
    overflow-y: auto;
    animation: slideInLeft 0.6s cubic-bezier(0.4, 0, 0.2, 1);
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

  /* Content Area */
  .content-area {
    position: fixed;
    top: 0;
    left: 250px;
    right: 0;
    bottom: 0;
    padding: 1.5rem;
    background: linear-gradient(90deg, #ffffff, #e9edfa);
    overflow-y: auto;
    overflow-x: hidden;
  }

  /* Custom Scrollbar for Content Area */
  .content-area::-webkit-scrollbar {
    width: 8px;
  }

  .content-area::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
  }

  .content-area::-webkit-scrollbar-thumb {
    background: #1f9e76;
    border-radius: 4px;
  }

  .content-area::-webkit-scrollbar-thumb:hover {
    background: #16a085;
  }

  .header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s both;
  }

  .header-top h2 {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
    color: #2c3a67;
  }

  .user-badge {
    background: linear-gradient(90deg, #58cbaa, #7cb8f4);
    padding: 0.4rem 1rem;
    border-radius: 2rem;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
    animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
  }

  .status-indicator {
    width: 16px;
    height: 16px;
    background-color: #44d69e;
    border-radius: 50%;
    box-shadow: 0 0 6px #44d69eaa;
  }

  /* Card Styles */
  .content-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
  }

  .content-card:nth-child(3) {
    animation-delay: 0.4s;
  }

  .content-card h5 {
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2c3a67;
    font-size: 1.1rem;
    border-bottom: 2px solid #1f9e76;
    padding-bottom: 0.5rem;
    display: inline-block;
  }

  /* Staff Grid */
  .staff-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
  }

  .staff-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    animation: scaleIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) both;
  }

  .staff-card:nth-child(1) { animation-delay: 0.1s; }
  .staff-card:nth-child(2) { animation-delay: 0.2s; }
  .staff-card:nth-child(3) { animation-delay: 0.3s; }
  .staff-card:nth-child(4) { animation-delay: 0.4s; }
  .staff-card:nth-child(5) { animation-delay: 0.5s; }
  .staff-card:nth-child(6) { animation-delay: 0.6s; }

  .staff-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
  }

  .staff-photo {
    width: 120px;
    height: 160px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .staff-name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #2c3a67;
    margin-bottom: 0.5rem;
  }

  .staff-position {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: linear-gradient(135deg, #1f9e76, #58cbaa);
    color: white;
    border-radius: 20px;
    font-size: 0.85rem;
    margin-bottom: 1rem;
  }

  .staff-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
  }

  .btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-primary {
    background: linear-gradient(135deg, #1f9e76, #58cbaa);
    color: white;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(31, 158, 118, 0.3);
  }

  .btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
  }

  .btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
  }

  /* Input Group Button */
  .input-group .btn-outline-primary {
    border: 2px solid #1f9e76;
    color: #1f9e76;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .input-group .btn-outline-primary:hover {
    background: #1f9e76;
    color: white;
    transform: scale(1.05);
  }

  .input-group .form-control {
    border-right: none;
  }

  .input-group .btn {
    border-left: none;
  }

  /* Modal Enhancements */
  .modal {
    z-index: 1055 !important;
  }

  .modal-backdrop {
    z-index: 1050 !important;
  }

  .modal-dialog {
    margin: 1.75rem auto;
    max-width: 500px;
  }

  .modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 3.5rem);
  }

  .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  }

  .modal-header {
    border-bottom: 1px solid #e9ecef;
    padding: 1.25rem 1.5rem;
    border-radius: 12px 12px 0 0;
  }

  .modal-body {
    padding: 1.5rem;
    max-height: calc(100vh - 200px);
    overflow-y: auto;
  }

  .modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
    border-radius: 0 0 12px 12px;
  }

  .modal-header.bg-primary {
    background: linear-gradient(135deg, #1f9e76, #58cbaa) !important;
  }

  /* Form Styles */
  .form-label {
    font-weight: 500;
    color: #405672;
    margin-bottom: 0.5rem;
  }

  .form-control {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    padding: 0.6rem 1rem;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    outline: none;
    border-color: #1f9e76;
    box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1);
  }

  /* Select2 Custom Styling */
  .select2-container--bootstrap-5 .select2-selection {
    border: 2px solid #e5e7eb !important;
    border-radius: 8px !important;
    min-height: 45px !important;
    padding: 0.3rem 0.5rem !important;
  }

  .select2-container--bootstrap-5.select2-container--focus .select2-selection,
  .select2-container--bootstrap-5.select2-container--open .select2-selection {
    border-color: #1f9e76 !important;
    box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1) !important;
  }

  .select2-container--bootstrap-5 .select2-selection__rendered {
    padding-left: 0.5rem !important;
    line-height: 28px !important;
  }

  .select2-container--bootstrap-5 .select2-selection__placeholder {
    color: #6c757d !important;
  }

  .select2-container--bootstrap-5 .select2-dropdown {
    border: 2px solid #1f9e76 !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
  }

  .select2-container--bootstrap-5 .select2-search__field {
    border: 1px solid #ddd !important;
    border-radius: 6px !important;
    padding: 0.5rem !important;
  }

  .select2-container--bootstrap-5 .select2-search__field:focus {
    border-color: #1f9e76 !important;
    outline: none !important;
  }

  .select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: #1f9e76 !important;
    color: white !important;
  }

  .select2-container--bootstrap-5 .select2-results__option--selected {
    background-color: #e8f5f1 !important;
    color: #1f9e76 !important;
  }

  /* Select2 with input-group */
  .input-group .select2-container {
    flex: 1 1 auto;
    width: 1% !important;
  }

  .input-group .select2-container .select2-selection {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
  }

  /* SweetAlert2 Custom Styling */
  .swal2-popup {
    border-radius: 12px !important;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
  }

  .swal2-title {
    color: #2c3a67 !important;
    font-size: 1.5rem !important;
    font-weight: 600 !important;
  }

  .swal2-html-container {
    color: #4b596a !important;
    font-size: 1rem !important;
  }

  .swal2-confirm.btn-danger {
    padding: 0.5rem 1.5rem !important;
    font-size: 0.95rem !important;
    border-radius: 8px !important;
    margin: 0 0.5rem !important;
  }

  .swal2-cancel.btn-secondary {
    padding: 0.5rem 1.5rem !important;
    font-size: 0.95rem !important;
    border-radius: 8px !important;
    margin: 0 0.5rem !important;
  }

  .swal2-icon.swal2-success {
    border-color: #1f9e76 !important;
    color: #1f9e76 !important;
  }

  .swal2-icon.swal2-success [class^='swal2-success-line'] {
    background-color: #1f9e76 !important;
  }

  .swal2-icon.swal2-success .swal2-success-ring {
    border-color: rgba(31, 158, 118, 0.3) !important;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
    animation: fadeInUp 0.6s ease-out;
  }

  .empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
    animation: bounceIn 0.8s ease-out;
  }

  /* Loading */
  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    visibility: hidden;
    opacity: 0;
    transition: all 0.3s ease;
  }

  .loading-overlay.show {
    visibility: visible;
    opacity: 1;
  }

  .spinner-border {
    width: 3rem;
    height: 3rem;
    border-width: 0.3rem;
    border-color: #1f9e76;
    border-right-color: transparent;
  }
</style>

<body>
  <!-- Loading Overlay -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="sidebar-header">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" />
        <h1 class="sidebar-title">
          <span class="title-text">
            <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
          </span>
        </h1>
      </div>
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
          <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar-event"></i> <span>Penjadwalan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('layout') }}">
            <i class="bi bi-grid-3x3"></i> <span>Master Layout</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('staff.index') }}">
            <i class="bi bi-people"></i> <span>Master Profil</span>
          </a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
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
  <main class="content-area">
    <div class="header-top">
      <h2><i class="bi bi-people me-2"></i>Master Profil</h2>
      <div class="user-badge">
        <span class="status-indicator"></span>
        <span>{{ Auth::user()->name ?? 'User' }}</span>
      </div>
    </div>

    <!-- Add Staff Form -->
    <div class="content-card">
      <h5><i class="bi bi-plus-circle me-2"></i>Tambah Petugas Baru</h5>
      <form id="addStaffForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Nama Petugas</label>
              <div class="input-group">
                <select class="form-control" name="name" id="staffNameSelect" required>
                  <option value="">Pilih Nama Petugas</option>
                  <option value="Ahmad Fauzi">Ahmad Fauzi</option>
                  <option value="Budi Santoso">Budi Santoso</option>
                  <option value="Citra Dewi">Citra Dewi</option>
                  <option value="Dian Pratama">Dian Pratama</option>
                  <option value="Eka Putri">Eka Putri</option>
                  <option value="Fajar Ramadhan">Fajar Ramadhan</option>
                  <option value="Gita Sari">Gita Sari</option>
                  <option value="Hendra Wijaya">Hendra Wijaya</option>
                  <option value="Indah Permata">Indah Permata</option>
                  <option value="Joko Susilo">Joko Susilo</option>
                  <option value="Kartika Sari">Kartika Sari</option>
                  <option value="Lestari Wulandari">Lestari Wulandari</option>
                  <option value="Muhammad Rizki">Muhammad Rizki</option>
                  <option value="Nur Azizah">Nur Azizah</option>
                  <option value="Oki Setiawan">Oki Setiawan</option>
                  <option value="Putri Ayu">Putri Ayu</option>
                  <option value="Qori Hidayat">Qori Hidayat</option>
                  <option value="Rina Marlina">Rina Marlina</option>
                  <option value="Siti Nurhaliza">Siti Nurhaliza</option>
                  <option value="Taufik Hidayat">Taufik Hidayat</option>
                </select>
                <button type="button" class="btn btn-outline-primary" id="btnAddNewName" title="Tambah nama baru ke daftar">
                  <i class="bi bi-plus-lg"></i>
                </button>
              </div>
              <small class="text-muted">Pilih dari dropdown atau tambah nama baru</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Posisi</label>
              <select class="form-control" name="position" required>
                <option value="">Pilih Posisi</option>
                <option value="1">Kiri</option>
                <option value="2">Kanan</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Foto Petugas</label>
              <input type="file" class="form-control" name="photo" accept="image/*" required>
            </div>
          </div>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Petugas
          </button>
        </div>
      </form>
    </div>

    <!-- Staff List -->
    <div class="content-card">
      <h5><i class="bi bi-people-fill me-2"></i>Daftar Petugas</h5>
      <div class="staff-grid" id="staffGrid">
        <!-- Staff cards will be loaded here -->
      </div>
      <div class="empty-state d-none" id="emptyState">
        <i class="bi bi-people"></i>
        <p>Belum ada data petugas</p>
        <small>Tambahkan petugas baru menggunakan form di atas</small>
      </div>
    </div>
  </main>

  <!-- Add New Name Modal -->
  <div class="modal fade" id="addNameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Nama Baru</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Petugas Baru</label>
            <input type="text" class="form-control" id="newNameInput" placeholder="Masukkan nama petugas baru" required>
            <small class="text-muted">Nama ini akan ditambahkan ke daftar pilihan</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="btnSaveNewName">
            <i class="bi bi-check-lg me-1"></i>Tambah ke Daftar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Petugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="editStaffForm">
          <div class="modal-body">
            <input type="hidden" name="staff_id" id="editStaffId">
            <div class="mb-3">
              <label class="form-label">Nama Petugas</label>
              <div class="input-group">
                <select class="form-control" name="name" id="editNameSelect" required>
                  <option value="">Pilih Nama Petugas</option>
                  <option value="Ahmad Fauzi">Ahmad Fauzi</option>
                  <option value="Budi Santoso">Budi Santoso</option>
                  <option value="Citra Dewi">Citra Dewi</option>
                  <option value="Dian Pratama">Dian Pratama</option>
                  <option value="Eka Putri">Eka Putri</option>
                  <option value="Fajar Ramadhan">Fajar Ramadhan</option>
                  <option value="Gita Sari">Gita Sari</option>
                  <option value="Hendra Wijaya">Hendra Wijaya</option>
                  <option value="Indah Permata">Indah Permata</option>
                  <option value="Joko Susilo">Joko Susilo</option>
                  <option value="Kartika Sari">Kartika Sari</option>
                  <option value="Lestari Wulandari">Lestari Wulandari</option>
                  <option value="Muhammad Rizki">Muhammad Rizki</option>
                  <option value="Nur Azizah">Nur Azizah</option>
                  <option value="Oki Setiawan">Oki Setiawan</option>
                  <option value="Putri Ayu">Putri Ayu</option>
                  <option value="Qori Hidayat">Qori Hidayat</option>
                  <option value="Rina Marlina">Rina Marlina</option>
                  <option value="Siti Nurhaliza">Siti Nurhaliza</option>
                  <option value="Taufik Hidayat">Taufik Hidayat</option>
                </select>
                <button type="button" class="btn btn-outline-primary" id="btnEditAddNewName" title="Tambah nama baru ke daftar">
                  <i class="bi bi-plus-lg"></i>
                </button>
              </div>
              <small class="text-muted">Pilih dari dropdown atau tambah nama baru</small>
            </div>
            <div class="mb-3">
              <label class="form-label">Posisi</label>
              <select class="form-control" name="position" id="editPosition" required>
                <option value="1">Kiri</option>
                <option value="2">Kanan</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Foto Baru (opsional)</label>
              <input type="file" class="form-control" name="photo" accept="image/*">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Confirm Delete Modal (Bootstrap Modal seperti di Master Layout) -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div class="modal-header" style="border-bottom: 1px solid #e9ecef; padding: 20px 25px;">
          <h5 class="modal-title" style="font-weight: 600; color: #dc3545;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Konfirmasi Hapus Petugas
          </h5>
        </div>
        <div class="modal-body" style="padding: 25px;">
          <div id="confirmDeleteMessage" style="font-size: 1rem; color: #495057; margin-bottom: 20px;">
            <!-- Message will be inserted here -->
          </div>
          <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
            <div style="display: flex; align-items: flex-start; margin-bottom: 8px;">
              <i class="bi bi-info-circle-fill me-2" style="color: #856404; font-size: 1.1rem; flex-shrink: 0;"></i>
              <span style="color: #856404;">Data petugas akan dihapus permanen dari sistem</span>
            </div>
            <div style="display: flex; align-items: flex-start;">
              <i class="bi bi-info-circle-fill me-2" style="color: #856404; font-size: 1.1rem; flex-shrink: 0;"></i>
              <span style="color: #856404;">Foto petugas akan dihapus dari storage</span>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 15px 25px; gap: 10px;">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 25px; border-radius: 8px;">
            <i class="bi bi-x-circle me-1"></i> Batal
          </button>
          <button type="button" class="btn btn-danger" id="confirmDeleteYes" style="padding: 10px 30px; border-radius: 8px;">
            <i class="bi bi-trash me-1"></i> Ya, Hapus!
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    // Helper functions - expose to window for global access
    window.showLoading = function() {
      const overlay = document.getElementById('loadingOverlay');
      if (overlay) {
        overlay.classList.add('show');
      }
    }

    window.hideLoading = function() {
      const overlay = document.getElementById('loadingOverlay');
      if (overlay) {
        overlay.classList.remove('show');
      }
    }

    window.toast = function(message, type = 'success') {
      const bg = type === 'success' ? '#1f9e76' : '#dc3545';
      if (typeof Toastify !== 'undefined') {
        Toastify({
          text: message,
          duration: 3000,
          close: true,
          gravity: 'top',
          position: 'right',
          style: { background: bg }
        }).showToast();
      } else {
        console.log(`Toast (${type}): ${message}`);
      }
    }

    // Shorthand references for internal use
    const showLoading = window.showLoading;
    const hideLoading = window.hideLoading;
    const toast = window.toast;

    // Attach event listeners to staff buttons
    function attachStaffButtonListeners() {
      // Edit buttons
      document.querySelectorAll('.btn-edit-staff').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          const staffId = parseInt(this.getAttribute('data-staff-id'));
          console.log('Edit button clicked for staff ID:', staffId);
          window.editStaff(staffId);
        });
      });
      
      // Delete buttons
      document.querySelectorAll('.btn-delete-staff').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          const staffId = parseInt(this.getAttribute('data-staff-id'));
          const staffName = this.getAttribute('data-staff-name').replace(/&#39;/g, "'").replace(/&quot;/g, '"');
          console.log('Delete button clicked for staff ID:', staffId, 'Name:', staffName);
          window.deleteStaff(staffId, staffName);
        });
      });
    }

    // Load staff data
    async function loadStaff() {
      try {
        const response = await fetch('/api/staff');
        const data = await response.json();
        
        const grid = document.getElementById('staffGrid');
        const emptyState = document.getElementById('emptyState');
        
        if (!data.success || !data.staff || data.staff.length === 0) {
          grid.innerHTML = '';
          emptyState.classList.remove('d-none');
        } else {
          emptyState.classList.add('d-none');
          grid.innerHTML = data.staff.map(staff => {
            // Escape HTML entities in name
            const safeName = staff.name.replace(/'/g, '&#39;').replace(/"/g, '&quot;');
            return `
              <div class="staff-card">
                <img src="/storage/${staff.photo_path}" alt="${staff.name}" class="staff-photo" onerror="this.src='/img/placeholder.png'">
                <div class="staff-name">${staff.name}</div>
                <div class="staff-position">${staff.position === 1 ? 'Kiri' : 'Kanan'}</div>
                <div class="staff-actions">
                  <button class="btn btn-sm btn-primary btn-edit-staff" data-staff-id="${staff.id}" type="button">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                  <button class="btn btn-sm btn-danger btn-delete-staff" data-staff-id="${staff.id}" data-staff-name="${safeName}" type="button">
                    <i class="bi bi-trash"></i> Hapus
                  </button>
                </div>
              </div>
            `;
          }).join('');
          
          // Attach event listeners to buttons using event delegation
          attachStaffButtonListeners();
        }
        
        console.log(`Loaded ${data.staff ? data.staff.length : 0} staff members`);
      } catch (error) {
        console.error('Error loading staff:', error);
        toast('Gagal memuat data petugas', 'error');
      }
    }

    // Add staff
    document.getElementById('addStaffForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const formData = new FormData(e.target);
      showLoading();
      
      try {
        const response = await fetch('/api/staff', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
          toast('Petugas berhasil ditambahkan');
          e.target.reset();
          loadStaff();
        } else {
          toast(data.message || 'Gagal menambahkan petugas', 'error');
        }
      } catch (error) {
        console.error('Error adding staff:', error);
        toast('Terjadi kesalahan', 'error');
      } finally {
        hideLoading();
      }
    });

    // Edit staff
    window.editStaff = async function(id) {
      try {
        const response = await fetch('/api/staff');
        const data = await response.json();
        const staff = data.staff ? data.staff.find(s => s.id === id) : null;
        
        if (staff) {
          document.getElementById('editStaffId').value = staff.id;
          
          // Set Select2 value
          $('#editNameSelect').val(staff.name).trigger('change');
          $('#editNameSelect').next('.select2-container').find('.select2-selection').css('border-color', '#1f9e76');
          
          document.getElementById('editPosition').value = staff.position;
          
          new bootstrap.Modal(document.getElementById('editModal')).show();
        }
      } catch (error) {
        console.error('Error loading staff:', error);
        toast('Gagal memuat data petugas', 'error');
      }
    }

    // Update staff
    document.getElementById('editStaffForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const staffId = document.getElementById('editStaffId').value;
      const formData = new FormData(e.target);
      showLoading();
      
      try {
        const response = await fetch(`/api/staff/${staffId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
          toast('Petugas berhasil diupdate');
          bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
          loadStaff();
        } else {
          toast(data.message || 'Gagal mengupdate petugas', 'error');
        }
      } catch (error) {
        console.error('Error updating staff:', error);
        toast('Terjadi kesalahan', 'error');
      } finally {
        hideLoading();
      }
    });

    // Delete staff with Bootstrap Modal (seperti di Master Layout)
    window.deleteStaff = function(id, name) {
      console.log('Delete button clicked for staff ID:', id, 'Name:', name);
      
      // Set message
      document.getElementById('confirmDeleteMessage').innerHTML = 
        `Apakah Anda yakin ingin menghapus petugas <strong>"${name}"</strong>?`;
      
      // Remove old event handlers and add new one
      const confirmBtn = document.getElementById('confirmDeleteYes');
      const newConfirmBtn = confirmBtn.cloneNode(true);
      confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
      
      newConfirmBtn.addEventListener('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
        modal.hide();
        executeDeleteStaff(id, name);
      });
      
      // Show modal
      const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
      modal.show();
    }
    
    // Execute delete staff
    async function executeDeleteStaff(id, name) {
      showLoading();
      
      console.log(`Deleting staff with ID: ${id}`);
      
      try {
        const response = await fetch(`/api/staff/${id}/delete`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        });
        
        console.log('Delete response status:', response.status);
        
        const data = await response.json();
        
        hideLoading();
        
        if (data.success) {
          toast('Petugas berhasil dihapus', 'success');
          loadStaff();
        } else {
          toast(data.message || 'Gagal menghapus petugas', 'error');
        }
      } catch (error) {
        hideLoading();
        console.error('Error deleting staff:', error);
        toast('Terjadi kesalahan saat menghapus petugas', 'error');
      }
    }

    // Add new name functionality with database persistence
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM Content Loaded');
      console.log('Bootstrap loaded:', typeof bootstrap !== 'undefined');
      console.log('jQuery loaded:', typeof $ !== 'undefined');
      console.log('Toastify loaded:', typeof Toastify !== 'undefined');
      
      loadStaff();
      
      const staffNameSelect = document.getElementById('staffNameSelect');
      const editNameSelect = document.getElementById('editNameSelect');
      const btnAddNewName = document.getElementById('btnAddNewName');
      const btnEditAddNewName = document.getElementById('btnEditAddNewName');
      const addNameModal = new bootstrap.Modal(document.getElementById('addNameModal'));
      const newNameInput = document.getElementById('newNameInput');
      const btnSaveNewName = document.getElementById('btnSaveNewName');
      
      // Initialize Select2 with search
      function initializeSelect2() {
        $('#staffNameSelect').select2({
          theme: 'bootstrap-5',
          placeholder: 'Pilih atau cari nama petugas',
          allowClear: true,
          width: '100%',
          language: {
            noResults: function() {
              return 'Nama tidak ditemukan';
            },
            searching: function() {
              return 'Mencari...';
            }
          }
        });

        $('#editNameSelect').select2({
          theme: 'bootstrap-5',
          placeholder: 'Pilih atau cari nama petugas',
          allowClear: true,
          width: '100%',
          dropdownParent: $('#editModal'),
          language: {
            noResults: function() {
              return 'Nama tidak ditemukan';
            },
            searching: function() {
              return 'Mencari...';
            }
          }
        });

        // Handle Select2 change events for visual feedback
        $('#staffNameSelect').on('select2:select', function() {
          $(this).next('.select2-container').find('.select2-selection').css('border-color', '#1f9e76');
        });

        $('#staffNameSelect').on('select2:clear', function() {
          $(this).next('.select2-container').find('.select2-selection').css('border-color', '#e5e7eb');
        });

        $('#editNameSelect').on('select2:select', function() {
          $(this).next('.select2-container').find('.select2-selection').css('border-color', '#1f9e76');
        });

        $('#editNameSelect').on('select2:clear', function() {
          $(this).next('.select2-container').find('.select2-selection').css('border-color', '#e5e7eb');
        });
      }

      // Load staff names from database
      async function loadStaffNames() {
        try {
          const response = await fetch('/api/staff-names');
          const data = await response.json();
          
          if (data.success && data.names) {
            // Clear existing options except placeholder
            $('#staffNameSelect').empty().append('<option value="">Pilih atau cari nama petugas</option>');
            $('#editNameSelect').empty().append('<option value="">Pilih atau cari nama petugas</option>');
            
            // Add all names from database
            data.names.forEach(nameObj => {
              const option1 = new Option(nameObj.name, nameObj.name, false, false);
              const option2 = new Option(nameObj.name, nameObj.name, false, false);
              $('#staffNameSelect').append(option1);
              $('#editNameSelect').append(option2);
            });
            
            // Trigger Select2 to update
            $('#staffNameSelect').trigger('change');
            $('#editNameSelect').trigger('change');
          }
        } catch (error) {
          console.error('Error loading staff names:', error);
          toast('Gagal memuat daftar nama', 'error');
        }
      }
      
      // Initialize Select2 after page load
      initializeSelect2();
      
      // Load names from database
      loadStaffNames();

      // Open add name modal from add form
      if (btnAddNewName) {
        btnAddNewName.addEventListener('click', function() {
          newNameInput.value = '';
          addNameModal.show();
          setTimeout(() => newNameInput.focus(), 300);
        });
      }

      // Open add name modal from edit form
      if (btnEditAddNewName) {
        btnEditAddNewName.addEventListener('click', function() {
          newNameInput.value = '';
          addNameModal.show();
          setTimeout(() => newNameInput.focus(), 300);
        });
      }

      // Save new name to database
      if (btnSaveNewName) {
        btnSaveNewName.addEventListener('click', async function() {
          const newName = newNameInput.value.trim();
          
          if (!newName) {
            toast('Nama tidak boleh kosong', 'error');
            return;
          }

          // Check if name already exists in main select
          const existingOptions = Array.from(staffNameSelect.options);
          const nameExists = existingOptions.some(option => 
            option.value.toLowerCase() === newName.toLowerCase()
          );

          if (nameExists) {
            toast('Nama sudah ada dalam daftar', 'error');
            return;
          }

          showLoading();

          try {
            // Save to database
            const response = await fetch('/api/staff-names', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify({ name: newName })
            });

            const data = await response.json();

            if (data.success) {
              // Reload names from database
              await loadStaffNames();

              // Set the new name as selected value in the active form
              if (document.getElementById('editModal').classList.contains('show')) {
                $('#editNameSelect').val(newName).trigger('change');
                $('#editNameSelect').next('.select2-container').find('.select2-selection').css('border-color', '#1f9e76');
              } else {
                $('#staffNameSelect').val(newName).trigger('change');
                $('#staffNameSelect').next('.select2-container').find('.select2-selection').css('border-color', '#1f9e76');
              }

              // Close modal and show success
              addNameModal.hide();
              toast('Nama berhasil ditambahkan dan disimpan');
            } else {
              toast(data.message || 'Gagal menambahkan nama', 'error');
            }
          } catch (error) {
            console.error('Error saving name:', error);
            toast('Terjadi kesalahan saat menyimpan nama', 'error');
          } finally {
            hideLoading();
          }
        });
      }

      // Allow Enter key to save
      if (newNameInput) {
        newNameInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            btnSaveNewName.click();
          }
        });
      }
    });
  </script>
</body>
</html>
