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


    /* Icons from Bootstrap Icons CDN */
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
    /* Responsive adjustments */
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
      margin-left: 240px;
      padding: 1.75rem 2rem 2rem 2rem;
      min-height: 100vh;
      background: linear-gradient(90deg, #ffffff, #e9edfa);
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      position: relative;
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
    .button-section {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
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

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #ffffff;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }
    thead {
      background-color: #e0e7ff;
    }
    thead th {
      color: #3b82f6;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #c7d2fe;
      user-select: none;
    }
    tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #e0e7ff;
      color: #475569;
    }
    tbody tr:hover {
      background-color: #f1f5f9;
    }
    .icon-cell {
      width: 40px;
      text-align: center;
      color: #3b82f6;
      cursor: pointer;
      user-select: none;
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

</style>
<!-- css dari superadmin bwangg -->

<body>
  <nav class="sidebar d-flex flex-column justify-content-between">
    <div>
      <div class="sidebar-header d-flex align-items-center gap-2">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo-Tambodia">
        <h1 class="sidebar-title">
            <span class="title-text">
                <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
            </span>
        </h1>

      </div>
      <ul class="nav flex-column px-1">
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/input') }}">
            <i class="bi bi-pencil-square"></i> Input Media
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ url('/jadwal') }}">
            <i class="bi bi-calendar3"></i> Penjadwalan
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
    <div class="sidebar-footer-img-container">
        <div class="sidebar-footer-gradient"></div>
    </div>

  </nav>

    <main class="content-area">
      <div class="header-top">
      <h2 class="section-header">Atur Jadwal Media </h2>
      <div class="user-badge" title="Logged in as {{ Auth::user()->name }}">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name }}</span>
      </div>
    </div>
      <div class="container">
        <div class="row">
          <div class="col">
              <div class="mb-3 form-section">
                <label for="cariFile" class="form-label">Cari File</label>
                <input type="text" class="form-control" id="cariFile" placeholder="Cari Nama File...">
                <button type="button" class="btn btn-outline-success mt-2 button-search">Search</button>
              </div>
              
              <div class="card-media">
              <table>
                <thead>
                  <tr>
                    <th class="icon-cell">✔</th>
                    <th>Media Name</th>
                    <th>File</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($media) && $media->count() > 0)
                    @foreach($media as $item)
                    <tr data-id="{{ $item->id }}">
                      <td>
                        <input type="checkbox" name="select_row" value="{{ $item->id }}">
                      </td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->type }}</td>
                      <td>{{ $item->date->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="4" class="text-center">Tidak ada media yang tersedia</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>

          </div>
          <div class="col">
          <form id="scheduleForm" action="{{ route('schedule.store') }}" method="POST">
            @csrf
            <input type="hidden" id="media_id" name="media_id">
            
            <div class="mb-3 form-section">
              <label for="namaFile" class="form-label">Nama File</label>
              <input type="text" class="form-control" id="namaFile" readonly>
            </div>
            
            <div class="mb-3 form-section">
              <label for="start_date" class="form-label">Tanggal Mulai</label>
              <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            
            <div class="mb-3 form-section">
              <label for="end_date" class="form-label">Tanggal Selesai</label>
              <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            
            <div class="mb-3 form-section">
              <label for="day_of_week" class="form-label">Pilih Hari</label>
              <select class="form-select mb-2" id="day_of_week" name="day_of_week">
                <option value="">Semua Hari</option>
                <option value="senin">Senin</option>
                <option value="selasa">Selasa</option>
                <option value="rabu">Rabu</option>
                <option value="kamis">Kamis</option>
                <option value="jumat">Jumat</option>
                <option value="sabtu">Sabtu</option>
                <option value="minggu">Minggu</option>
              </select>
              
              <label for="time" class="form-label">Pilih Jam</label>
              <input type="time" class="form-control" id="time" name="time">
            </div>
            
            <div class="button-section">
              <button type="reset" class="btn btn-danger" id="resetButton">Reset</button>
              <button type="submit" class="btn btn-success" id="submitButton">Simpan</button>
            </div>
          </form>
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

