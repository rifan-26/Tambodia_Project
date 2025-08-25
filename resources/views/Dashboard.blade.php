<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    :root {
      --primary-color: #1f9e76;
      --secondary-color: #0084d6;
      --accent-color: #a0d5d2;
      --background-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    body {
      background: var(--background-gradient);
      font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #2f3a55;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    
    /* Dashboard Cards */
    .dashboard-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    .dashboard-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }
    
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .stats-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      position: relative;
      overflow: hidden;
    }
    
    .stats-card::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 100%;
      height: 100%;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      transition: var(--transition);
    }
    
    .stats-card:hover::after {
      transform: scale(1.2);
    }
    
    .stats-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .stats-label {
      font-size: 0.9rem;
      opacity: 0.9;
    }
    
    /* Audio Player Styles */
    .audio-player-container {
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 15px;
      margin-bottom: 20px;
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
    
    .media-card {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      background: white;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .media-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .media-card-header {
      padding: 12px 15px;
      background: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .media-card-body {
      padding: 15px;
    }
    
    .media-title {
      font-weight: 600;
      color: #2c3a67;
      margin: 0;
      font-size: 1.1rem;
    }
    
    .media-date {
      font-size: 0.85rem;
      color: #6c757d;
    }
    
    .media-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 10px;
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

    .tam {
        color: #0084d6;
    }

    .bo {
        color: #a0d5d2;
    }

    .dia {
        color: #1f9e76;
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
        width: 240px;
        overflow: hidden;
    }

    .sidebar-footer-img {
        width: 100%;
        height: auto;
        display: block;
    }

    .sidebar-footer-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 500px; /* tinggi overlay */
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
      color: #ffffff;
    }
    .bi-pencil-square {
      color: #5a7062;
    }
    .bi-calendar3 {
      color: #5a7062;
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
        margin-left: 60px;
        padding: 1rem 1rem 1rem 1rem;
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
    
    .card {
      background: white;
      box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
      border-radius: 0.5rem;
      padding: 1.5rem 2rem 2rem 2rem;
      border: none;
    }

    .button-section {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 20px;
    }
    /* Styling dropdown */
.custom-select {
  appearance: none; /* Hilangkan default style browser */
  background-color: #ffffff;
  border: 2px solid #a7b6d9;
  border-radius: 0.6rem;
  padding: 0.6rem 1rem;
  font-size: 1rem;
  color: #405672;
  cursor: pointer;
  transition: all 0.3s ease;
  background-image: url('data:image/svg+xml;utf8,<svg fill="%23405672" height="20" viewBox="0 0 24 24" width="20"><path d="M7 10l5 5 5-5z"/></svg>');
  background-repeat: no-repeat;
  background-position: right 1rem center;
}

/* Fokus & hover efek */
.custom-select:hover,
.custom-select:focus {
  border-color: #1f9e76;
  box-shadow: 0 0 8px rgba(31, 158, 118, 0.3);
  outline: none;
}

/* Styling option saat di dropdown */
.custom-select option {
  padding: 0.6rem;
  background-color: #ffffff;
  color: #405672;
}

.custom-select option:hover {
  background-color: #dff5ec;
}

/* Untuk Firefox (hover option tidak default) */
@-moz-document url-prefix() {
  .custom-select option:checked,
  .custom-select option:hover {
    background-color: #dff5ec;
    color: #1f9e76;
  }
}

</style>
<!-- css dari dashboard bwangg -->

<body>
  <nav class="sidebar d-flex flex-column justify-content-between">
    <div>
      <div class="sidebar-header d-flex align-items-center gap-2 mb-4">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo-Tambodia">
        <h1 class="sidebar-title mb-0 fs-4">
            <span class="title-text">
                <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
            </span>
        </h1>
      </div>
      <ul class="nav flex-column px-1">
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ url('/dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/input') }}">
            <i class="bi bi-pencil-square"></i> Input Media
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/jadwal') }}">
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
        <h2>Media Yang Telah Di Input</h2>
        <div class="user-badge" title="Logged in as Admin">
            <span class="status-indicator" aria-label="online status"></span>
            <span>{{ Auth::user()->name ?? 'Username Admin' }}</span>
        </div>
    </div>
    
    <form id="filterForm" class="mb-4" onsubmit="return false;">
      <div class="mb-3">
        <label for="jenisMedia" class="form-label">Jenis Media</label>
        <select class="form-select" id="jenisMedia" onchange="filterMedia()">
            <option value="" selected>Semua Jenis</option>
            <option value="Audio">Audio</option>
            <option value="Gambar">Gambar</option>
            <option value="Video">Video</option>
        </select>
      </div>
    </form>
    
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="selectAll">
        <label class="form-check-label" for="selectAll">
          Pilih Semua
        </label>
      </div>
      <div class="btn-group" role="group" aria-label="Bulk actions">
        <button type="button" id="btnBulkToggle" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle tampil/sembunyi pada Landing untuk media yang dipilih">
          <i class="bi bi-shuffle"></i> Toggle Terpilih
        </button>
        <button type="button" id="btnBulkShow" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan semua media terpilih di Landing (yang belum tampil saja yang akan berubah)">
          <i class="bi bi-eye"></i> Tampilkan Terpilih
        </button>
        <button type="button" id="btnBulkHide" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Sembunyikan semua media terpilih dari Landing (yang sedang tampil saja yang akan berubah)">
          <i class="bi bi-eye-slash"></i> Sembunyikan Terpilih
        </button>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Media hanya akan tampil di Landing jika status 'Show on Landing' aktif dan (opsional) jadwalnya sedang aktif.">
          <i class="bi bi-info-circle"></i>
        </button>
      </div>
    </div>
    
    <div class="row" id="mediaContainer">
        @if(isset($media) && count($media) > 0)
            @foreach($media as $item)
                <div class="col-md-6 col-lg-4 media-item" data-type="{{ $item->type }}">
                    <div class="media-card">
                        <div class="media-card-header">
                            <div class="d-flex align-items-center gap-2">
                              <input class="form-check-input select-media" type="checkbox" value="{{ $item->id }}" data-status="{{ $item->show_on_landing ? 'true' : 'false' }}">
                              <h5 class="media-title mb-0">{{ $item->name }}</h5>
                            </div>
                            <span class="badge {{ $item->type == 'Audio' ? 'bg-primary' : ($item->type == 'Video' ? 'bg-danger' : 'bg-success') }}">{{ $item->type }}</span>
                        </div>
                        <div class="media-card-body">
                            <p class="media-date">Uploaded: {{ $item->date->format('d M Y') }}</p>
                            
                            @if($item->type == 'Audio')
                                <div class="audio-player-container">
                                    <audio class="audio-player" controls>
                                        <source src="{{ asset('storage/' . $item->file_path) }}" type="audio/mp3">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @elseif($item->type == 'Gambar')
                                <img src="{{ asset('storage/' . $item->file_path) }}" class="img-fluid rounded" alt="{{ $item->name }}">
                            @elseif($item->type == 'Video')
                                <div class="ratio ratio-16x9">
                                    <video controls>
                                        <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @endif
                            
                            <div class="media-actions">
                                <button class="btn btn-sm btn-outline-primary toggle-landing" data-id="{{ $item->id }}" data-status="{{ $item->show_on_landing ? 'true' : 'false' }}" data-bs-toggle="tooltip" title="Tampilkan/Sembunyikan media ini pada Landing">
                                    <i class="bi {{ $item->show_on_landing ? 'bi-eye-slash' : 'bi-eye' }}"></i> 
                                    {{ $item->show_on_landing ? 'Hide from Landing' : 'Show on Landing' }}
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-media" data-id="{{ $item->id }}" data-bs-toggle="tooltip" title="Hapus media ini">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    No media found. Please upload some media files.
                </div>
            </div>
        @endif
    </div>
    
    <div class="card p-3">
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
          <tr>
            <td><input type="checkbox" name="select_row" value="admin1"></td>
            <td>Foto1</td>
            <td>Gambar</td>
            <td>2024-06-01</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="select_row" value="admin2"></td>
            <td>Video2</td>
            <td>Video</td>
            <td>2024-06-01</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="select_row" value="admin3"></td>
            <td>Audio3</td>
            <td>Audio</td>
            <td>2024-06-01</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="button-section">
      <button type="button" id="btnTampilkan" class="btn btn-success">Tampilkan</button>
    </div>
  </main>

  <script>
document.getElementById("btnTampilkan").addEventListener("click", function () {
    let selectedMedia = document.getElementById("jenisMedia").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let fileType = row.cells[2].textContent.trim().toLowerCase();
        let show = (selectedMedia === "" || fileType.includes(selectedMedia));
        row.style.display = show ? "" : "none";
    });
});
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Initialize Plyr for audio players
  document.addEventListener('DOMContentLoaded', function() {
    // Enable Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // CSRF token for fetch calls
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Bulk selection helpers
    const selectAll = document.getElementById('selectAll');
    const mediaCheckboxes = () => document.querySelectorAll('.select-media');
    if (selectAll) {
      selectAll.addEventListener('change', function() {
        mediaCheckboxes().forEach(cb => { cb.checked = selectAll.checked; });
      });
    }

    function callToggle(ids) {
      return fetch('{{ route("media.toggle-landing") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
          },
          body: JSON.stringify({ media_ids: ids })
        }).then(r => r.json());
    }

    function updateCardUI(ids, targetStatus) {
      ids.forEach(id => {
        const card = document.querySelector(`.toggle-landing[data-id="${id}"]`);
        const checkbox = document.querySelector(`.select-media[value="${id}"]`);
        if (card) {
          const btn = card;
          const icon = btn.querySelector('i');
          if (targetStatus === true) {
            icon?.classList.remove('bi-eye');
            icon?.classList.add('bi-eye-slash');
            btn.innerHTML = '<i class="bi bi-eye-slash"></i> Hide from Landing';
            btn.setAttribute('data-status', 'true');
          } else {
            icon?.classList.remove('bi-eye-slash');
            icon?.classList.add('bi-eye');
            btn.innerHTML = '<i class="bi bi-eye"></i> Show on Landing';
            btn.setAttribute('data-status', 'false');
          }
        }
        if (checkbox) {
          checkbox.setAttribute('data-status', targetStatus ? 'true' : 'false');
        }
      });
    }

    // Bulk actions
    document.getElementById('btnBulkToggle')?.addEventListener('click', async function(){
      const selected = Array.from(mediaCheckboxes()).filter(cb => cb.checked).map(cb => cb.value);
      if (selected.length === 0) { alert('Pilih media terlebih dahulu'); return; }
      try {
        const res = await callToggle(selected);
        if (res.success) {
          const newStatus = !!res.show_on_landing;
          updateCardUI(selected, newStatus);
          alert(res.message);
        } else {
          alert(res.message || 'Gagal melakukan toggle');
        }
      } catch(e){
        console.error(e); alert('Terjadi kesalahan saat toggle');
      }
    });

    document.getElementById('btnBulkShow')?.addEventListener('click', async function(){
      const unchecked = Array.from(mediaCheckboxes()).filter(cb => cb.checked && cb.getAttribute('data-status') === 'false').map(cb => cb.value);
      if (unchecked.length === 0) { alert('Tidak ada media yang perlu ditampilkan'); return; }
      try {
        const res = await callToggle(unchecked);
        if (res.success) {
          updateCardUI(unchecked, true);
          alert(res.message);
        } else { alert(res.message || 'Gagal menampilkan media'); }
      } catch(e){ console.error(e); alert('Terjadi kesalahan'); }
    });

    document.getElementById('btnBulkHide')?.addEventListener('click', async function(){
      const checkedShown = Array.from(mediaCheckboxes()).filter(cb => cb.checked && cb.getAttribute('data-status') === 'true').map(cb => cb.value);
      if (checkedShown.length === 0) { alert('Tidak ada media yang perlu disembunyikan'); return; }
      try {
        const res = await callToggle(checkedShown);
        if (res.success) {
          updateCardUI(checkedShown, false);
          alert(res.message);
        } else { alert(res.message || 'Gagal menyembunyikan media'); }
      } catch(e){ console.error(e); alert('Terjadi kesalahan'); }
    });
    const audioPlayers = document.querySelectorAll('.audio-player');
    if (audioPlayers.length > 0) {
      audioPlayers.forEach(player => {
        new Plyr(player, {
          controls: [
            'play',
            'progress',
            'current-time',
            'mute',
            'volume'
          ]
        });
      });
    }
    
    // Setup toggle landing page visibility
    const toggleButtons = document.querySelectorAll('.toggle-landing');
    toggleButtons.forEach(button => {
      button.addEventListener('click', function() {
        const mediaId = this.getAttribute('data-id');
        const currentStatus = this.getAttribute('data-status');
        
        // Send AJAX request to toggle landing page visibility
        fetch('{{ route("media.toggle-landing") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
          },
          body: JSON.stringify({
            media_ids: [mediaId]
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update button text and icon
            const newStatus = currentStatus === 'true' ? 'false' : 'true';
            this.setAttribute('data-status', newStatus);
            // also reflect on the checkbox status if present
            const checkbox = document.querySelector(`.select-media[value="${mediaId}"]`);
            if (checkbox) checkbox.setAttribute('data-status', newStatus);
            
            const icon = this.querySelector('i');
            if (newStatus === 'true') {
              icon.classList.remove('bi-eye');
              icon.classList.add('bi-eye-slash');
              this.innerHTML = '<i class="bi bi-eye-slash"></i> Hide from Landing';
            } else {
              icon.classList.remove('bi-eye-slash');
              icon.classList.add('bi-eye');
              this.innerHTML = '<i class="bi bi-eye"></i> Show on Landing';
            }
            
            // Show success message
            alert(data.message);
          } else {
            alert('Failed to update landing page visibility');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating landing page visibility');
        });
      });
    });
    
    // Setup delete media functionality
    const deleteButtons = document.querySelectorAll('.delete-media');
    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this media?')) {
          const mediaId = this.getAttribute('data-id');
          
          // Send AJAX request to delete media
          fetch(`/media/${mediaId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Remove media card from DOM
              this.closest('.media-item').remove();
              alert(data.message);
            } else {
              alert('Failed to delete media');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting media');
          });
        }
      });
    });
  });
  
  // Filter media by type
  function filterMedia() {
    const selectedType = document.getElementById('jenisMedia').value;
    const mediaItems = document.querySelectorAll('.media-item');
    
    mediaItems.forEach(item => {
      const itemType = item.getAttribute('data-type');
      if (selectedType === '' || itemType === selectedType) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  }
</script>
</body>
</html>

