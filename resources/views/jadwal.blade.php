<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Jadwal Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
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
        display: inline-block;  /* biar teks-nya satu blok */
    }

    .tam {
        color: #0084d6;
    }

    .bo {
        color: #a0d5d2;
    }

    .dia {
        color: #1f9e76;
    }

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
    .sidebar-footer-img-container {
        position: relative;
        width: 260px; /* Adjust width as needed */
        overflow: hidden;
    }

    .sidebar-footer {
    position: relative;
    width: 100%;
    height: 100px; /* Sesuaikan tinggi sesuai kebutuhan */
    overflow: hidden;
    bottom: 0;
}

    .sidebar-footer-img {
        bottom: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;  /* Memastikan gambar terisi penuh tanpa merusak rasio */
        display: block;
    }

    .sidebar-footer-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%; /* Use 100% to cover the entire height of the container */
        background: linear-gradient(to bottom, white, rgba(255,255,255,0));
        z-index: 2;
        pointer-events: none;
    }


    .bi {
      font-size: 1.2rem;
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
      /* Background with subtle gradient */
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
    
    label {
      font-weight: 500;
      margin-bottom: 0.3rem;
      display: inline-block;
      color: #405672;
    }
    select.form-select {
      max-width: 300px;
      border-radius: 0.5rem;
      padding: 0.55rem 0.75rem;
    }
    textarea {
      width: 100%;
      height: 320px;
      margin-top: 1.25rem;
      padding: 1rem;
      border-radius: 0.5rem;
      border: 1px solid #a7b6d9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 1rem;
      resize: vertical;
      color: #334;
      transition: border-color 0.3s ease;
    }
    textarea:focus {
      outline: none;
      border-color: #1f9e76;
      box-shadow: 0 0 8px #1f9e76aa;
    }
    /* Sidebar icons color */
    .bi-speedometer2 {
      color: #5a7062;
    }
    .bi-pencil-square {
      color: #5a7062;
    }
    .bi-calendar3 {
      color: #ffffff;
    }
    .bi-box-arrow-left {
      color: #5a7062;
    }
    /* Scrollbar styling for textarea */
    textarea::-webkit-scrollbar {
      width: 10px;
    }
    textarea::-webkit-scrollbar-track {
      background: #f0f0f5;
      border-radius: 0.3rem;
    }
    textarea::-webkit-scrollbar-thumb {
      background-color: #a8bee3;
      border-radius: 0.3rem;
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
    }

    .nav-link.active {
      background-color: #1f9e76 !important;
      color: #ffffff !important;
    }
  
    main.content-area {
      margin-left: 240px;
      padding: 1.75rem 2rem 2rem 2rem;
      min-height: 100vh;
      background: linear-gradient(90deg, #ffffff, #e9edfa);
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      position: relative;
    }
    .upload-area {
      border: 2px dashed #1f9e76;
      padding: 2rem;
      text-align: center;
      margin: 1rem 0;
      border-radius: 0.5rem;
      background: #f0f9f0;
    }

    .upload-area:hover {
      cursor: pointer;
      background: #e9f7e9;
    }
    /* Button Styling */
    .button-section {
      display: flex;
      justify-content: flex-end;
      gap: 0.75rem;
      margin-top: 2rem;
      padding-top: 1rem;
      border-top: 1px solid #e9ecef;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      font-weight: 500;
      font-size: 0.95rem;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
    }

    .btn-success {
      background: linear-gradient(135deg, #1f9e76 0%, #16a085 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(31, 158, 118, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.4);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    /* Loading and feedback states */
    .btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none !important;
    }

    .loading {
      position: relative;
      color: transparent;
    }

    .loading::after {
      content: '';
      position: absolute;
      width: 16px;
      height: 16px;
      top: 50%;
      left: 50%;
      margin-left: -8px;
      margin-top: -8px;
      border: 2px solid transparent;
      border-top-color: #ffffff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .card {
      background: white;
      box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
      border-radius: 0.5rem;
      padding: 1.5rem 2rem 2rem 2rem;
      border: none;
    }
    .card h5 {
      font-weight: 600;
      margin-bottom: 1rem;
      color: #273554;
    }

    /* Table Styling */
    .table-container {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #ffffff;
      margin: 0;
    }

    thead {
      background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    }

    thead th {
      color: #3b82f6;
      font-weight: 600;
      padding: 1rem;
      text-align: left;
      border: none;
      user-select: none;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    tbody td {
      padding: 1rem;
      border-bottom: 1px solid #f1f5f9;
      color: #475569;
      vertical-align: middle;
    }

    tbody tr {
      transition: all 0.2s ease;
    }

    tbody tr:hover {
      background-color: #f8fafc;
      transform: translateY(-1px);
    }

    tbody tr:last-child td {
      border-bottom: none;
    }

    .icon-cell {
      width: 60px;
      text-align: center;
    }

    .checkbox-custom {
      width: 18px;
      height: 18px;
      accent-color: #1f9e76;
      cursor: pointer;
    }

    /* Selected row styling */
    tbody tr.selected {
      background-color: rgba(31, 158, 118, 0.1);
      border-left: 4px solid #1f9e76;
    }

    .card- {
      background: white;
      box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
      border-radius: 0.5rem;
      padding: 1.5rem 2rem 2rem 2rem;
      border: none;
    }

    .button-search {
      margin-bottom: 5px;
    }

    .form-control {
      margin-bottom: 10px;
    }

    /* Alert and notification styles */
    .alert-custom {
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: none;
      font-weight: 500;
    }

    .alert-success {
      background-color: rgba(31, 158, 118, 0.1);
      color: #1f9e76;
      border-left: 4px solid #1f9e76;
    }

    .alert-error {
      background-color: rgba(220, 53, 69, 0.1);
      color: #dc3545;
      border-left: 4px solid #dc3545;
    }

    /* Empty state styling */
    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: #6c757d;
    }

    .empty-state i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    /* Responsive improvements */
    @media (max-width: 992px) {
      .content-area {
        padding: 1rem;
      }
      
      .header-top {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
      
      .button-section {
        flex-direction: column;
      }
      
      .btn {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .table-container {
        overflow-x: auto;
      }
      
      table {
        min-width: 500px;
      }
    }
    .content-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #e9ecef;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      transition: box-shadow 0.3s ease;
    }

    .content-card:hover {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    }

    .content-card h5 {
      font-weight: 600;
      margin-bottom: 1.25rem;
      color: #2c3a67;
      font-size: 1.1rem;
      border-bottom: 2px solid #1f9e76;
      padding-bottom: 0.5rem;
      display: inline-block;
    }

    .form-section {
      margin-bottom: 1.25rem;
    }

    .form-label {
      font-weight: 500;
      color: #405672;
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
    }

    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid #d1d5db;
      padding: 0.75rem;
      font-size: 0.95rem;
      transition: all 0.2s ease;
      background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
      outline: none;
      border-color: #1f9e76;
      box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1);
    }

    .form-control[readonly] {
      background-color: #f8f9fa;
      border-color: #e9ecef;
    }

    .search-container {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .search-input {
      padding-left: 2.5rem;
    }

    .search-icon {
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
      z-index: 2;
    }
</style>

<body>
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
          <a class="nav-link" href="{{ route('layout.index') }}">
            <i class="bi bi-grid-3x3-gap"></i> <span>Layout Manager</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar3"></i> <span>Penjadwalan</span>
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

    <main class="content-area">
      <div class="header-top">
      <h2 class="section-header">Atur Jadwal Media </h2>
      <div class="user-badge" title="Logged in">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name ?? 'User' }}</span>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-lg-7">
          <div class="content-card">
            <h5><i class="bi bi-table me-2"></i>Pilih Media</h5>
            
            <div class="search-container">
              <i class="bi bi-search search-icon"></i>
              <input type="text" class="form-control search-input" id="cariFile" placeholder="Cari nama file media...">
            </div>
            
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th class="icon-cell"><i class="bi bi-check-square"></i></th>
                    <th><i class="bi bi-file-earmark me-2"></i>Nama Media</th>
                    <th><i class="bi bi-file-type me-2"></i>Tipe File</th>
                    <th><i class="bi bi-calendar-date me-2"></i>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($media) && $media->count() > 0)
                    @foreach($media as $item)
                    <tr data-id="{{ $item->id }}" class="media-row">
                      <td class="icon-cell">
                        <input type="checkbox" name="select_row" value="{{ $item->id }}" class="checkbox-custom">
                      </td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->type }}</td>
                      <td>{{ $item->date->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="4" class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <div>Tidak ada media yang tersedia</div>
                        <small>Silakan tambahkan media terlebih dahulu</small>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>

          </div>
        </div>
        
        <div class="col-lg-5">
          <div class="content-card">
            <h5><i class="bi bi-calendar-plus me-2"></i>Atur Jadwal</h5>
            
            <div id="alertContainer"></div>
            
            <form id="scheduleForm" action="{{ route('schedule.store') }}" method="POST">
              @csrf
              <input type="hidden" id="media_id" name="media_id">
              
              <div class="form-section">
                <label for="namaFile" class="form-label">
                  <i class="bi bi-file-earmark-text me-2"></i>Media Terpilih
                </label>
                <input type="text" class="form-control" id="namaFile" readonly placeholder="Pilih media dari tabel">
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-section">
                    <label for="start_date" class="form-label">
                      <i class="bi bi-calendar-event me-2"></i>Tanggal Mulai
                    </label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-section">
                    <label for="end_date" class="form-label">
                      <i class="bi bi-calendar-check me-2"></i>Tanggal Selesai
                    </label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                  </div>
                </div>
              </div>
              
              <div class="form-section">
                <label for="day_of_week" class="form-label">
                  <i class="bi bi-calendar-week me-2"></i>Hari dalam Seminggu
                </label>
                <select class="form-select" id="day_of_week" name="day_of_week">
                  <option value="">Semua Hari</option>
                  <option value="senin">Senin</option>
                  <option value="selasa">Selasa</option>
                  <option value="rabu">Rabu</option>
                  <option value="kamis">Kamis</option>
                  <option value="jumat">Jumat</option>
                  <option value="sabtu">Sabtu</option>
                  <option value="minggu">Minggu</option>
                </select>
              </div>
              
              <div class="form-section">
                <label for="time" class="form-label">
                  <i class="bi bi-clock me-2"></i>Waktu Tayang
                </label>
                <input type="time" class="form-control" id="time" name="time">
              </div>
            
              <div class="button-section">
                <button type="reset" class="btn btn-danger" id="resetButton">
                  <i class="bi bi-arrow-clockwise me-2"></i>Reset
                </button>
                <button type="submit" class="btn btn-success" id="submitButton">
                  <i class="bi bi-check-lg me-2"></i>Simpan Jadwal
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("cariFile");
    const tableRows = document.querySelectorAll("table tbody tr");
    const checkboxes = document.querySelectorAll('input[name="select_row"]');
    const mediaIdInput = document.getElementById('media_id');
    const namaFileInput = document.getElementById('namaFile');
    const scheduleForm = document.getElementById('scheduleForm');
    
    // Set today as default for date inputs
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').value = today;
    document.getElementById('end_date').value = today;

    // Search functionality
    searchInput.addEventListener("input", function () {
        const keyword = searchInput.value.trim().toLowerCase();

        tableRows.forEach(row => {
            if (row.cells.length > 1) {
                const mediaName = row.cells[1].textContent.toLowerCase();
                row.style.display = mediaName.includes(keyword) ? "" : "none";
            }
        });
    });
    
    // Handle checkbox selection
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Uncheck all other checkboxes
            checkboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
            
            if (checkbox.checked) {
                const row = checkbox.closest('tr');
                const mediaId = row.getAttribute('data-id');
                const mediaName = row.cells[1].textContent;
                
                // Set values in the form
                mediaIdInput.value = mediaId;
                namaFileInput.value = mediaName;
            } else {
                // Clear form if unchecked
                mediaIdInput.value = '';
                namaFileInput.value = '';
            }
        });
    });
    
    // Form submission
    scheduleForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!mediaIdInput.value) {
            alert('Silakan pilih media terlebih dahulu');
            return;
        }
        
        // Validate dates
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (new Date(startDate) > new Date(endDate)) {
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai');
            return;
        }
        
        // Submit form via AJAX
        const formData = new FormData(scheduleForm);
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(scheduleForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                // Reset form
                scheduleForm.reset();
                mediaIdInput.value = '';
                namaFileInput.value = '';
                // Uncheck all checkboxes
                checkboxes.forEach(cb => {
                    cb.checked = false;
                });
                // Set today as default for date inputs
                document.getElementById('start_date').value = today;
                document.getElementById('end_date').value = today;
            } else {
                alert(data.message || 'Terjadi kesalahan saat menyimpan jadwal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan jadwal');
        });
    });
    
    // Reset button
    document.getElementById('resetButton').addEventListener('click', function() {
        mediaIdInput.value = '';
        namaFileInput.value = '';
        // Uncheck all checkboxes
        checkboxes.forEach(cb => {
            cb.checked = false;
        });
    });
});
</script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

