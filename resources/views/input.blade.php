<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>InputMedia Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
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
        width: 100%;
        height: auto;
        position: relative;
    }

    .sidebar {
        background: linear-gradient(180deg, #E7FFEA 0%, #ffffff 50%, #dcedff 100%);
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

    .sidebar-footer-img {
        width: 90%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    .sidebar-footer-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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
      color: #ffffff;
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
    
    /* Loading Spinner Styles */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.7);
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
      color: #1f9e76;
      font-weight: 500;
    }
    
    /* Card hover effect */
    .media-item .card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .media-item .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      cursor: pointer;
    }
    
    /* Active filter button */
    .filter-btn.active {
      background-color: #1f9e76 !important;
      border-color: #1f9e76 !important;
      color: white !important;
    }
    
    /* Form validation styles */
    .form-control.is-invalid {
      border-color: #dc3545;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .invalid-feedback {
      display: none;
      width: 100%;
      margin-top: 0.25rem;
      font-size: 0.875em;
      color: #dc3545;
    }
</style>
<!-- css dari input bwangg -->

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
          <a class="nav-link active" href="{{ url('/input') }}">
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
  </nav>


  <main class="content-area">
    <div class="header-top">
      <h2>Input Media</h2>
      <div class="user-badge" title="Logged in as Admin">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
      </div>
    </div>
    
    <!-- Search and Filter Section -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <input type="text" id="searchInput" class="form-control" placeholder="Cari media..." aria-label="Search">
              <button class="btn btn-outline-secondary" type="button" id="searchButton">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-outline-primary filter-btn" data-filter="all">Semua</button>
              <button type="button" class="btn btn-outline-primary filter-btn" data-filter="Gambar">Gambar</button>
              <button type="button" class="btn btn-outline-primary filter-btn" data-filter="Video">Video</button>
              <button type="button" class="btn btn-outline-primary filter-btn" data-filter="Audio">Audio</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Media Display Section -->
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Media Tersedia</h5>
        <div class="row" id="mediaContainer">
          @if(isset($media) && $media->count() > 0)
            @foreach($media as $item)
              <div class="col-md-4 col-lg-3 mb-4 media-item" data-type="{{ $item->type }}" data-name="{{ $item->name }}">
                <div class="card h-100">
                  <div class="card-body">
                    <h6 class="card-title">{{ $item->name }}</h6>
                    <p class="card-text"><span class="badge bg-info">{{ $item->type }}</span></p>
                    <p class="card-text small">{{ $item->date }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col-12 text-center py-4">
              <p>Tidak ada media tersedia.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
    
    <form id="mediaForm" action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label for="jenisMedia" class="form-label">Jenis Media</label>
        <select class="form-select" id="jenisMedia" name="jenisMedia" required>
            <option value="" disabled selected>Pilih Jenis Media</option>
            <option value="audio">Audio</option>
            <option value="image">Gambar</option>
            <option value="video">Video</option>
        </select>
        <small id="allowedTypesHint" class="text-muted d-block mt-1">Pilih jenis media untuk melihat tipe file yang didukung.</small>
        <div class="invalid-feedback">Silakan pilih jenis media</div>
      </div>
      <div class="upload-area" id="uploadArea">
        <p>Klik untuk menambahkan File atau drag and drop file di sini</p>
        <input type="file" name="file" id="fileUpload" style="display:none;" />
        <button type="button" id="uploadButton" class="btn btn-outline-success">Upload File</button>
        <div id="filePreview" class="mt-3 d-none">
          <div class="d-flex align-items-center">
            <i class="bi bi-file-earmark me-2"></i>
            <span id="fileName">No file selected</span>
            <button type="button" id="removeFile" class="btn btn-sm btn-outline-danger ms-2">
              <i class="bi bi-x"></i>
            </button>
            <button type="button" id="openPreviewBtn" class="btn btn-sm btn-primary ms-2 d-none">
              <i class="bi bi-eye"></i> Lihat Preview
            </button>
          </div>
          <div id="previewCanvas" class="mt-3"></div>
          <small id="fileMeta" class="text-muted d-block mt-1"></small>
          <div id="uploadProgressWrap" class="progress mt-3 d-none" aria-hidden="true">
            <div id="uploadProgress" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="namaFile" class="form-label">Nama File</label>
        <input type="text" class="form-control" id="namaFile" name="namaFile" placeholder="Masukkan Nama File" required>
        <div class="invalid-feedback">Nama file tidak boleh kosong</div>
      </div>
      <div class="button-section">
        <button type="reset" class="btn btn-danger" id="resetButton">Hapus</button>
        <button type="submit" class="btn btn-success" id="submitButton">Simpan</button>
      </div>
    </form>
  </main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Loading overlay functionality
      const loadingOverlay = document.getElementById('loadingOverlay');
      
      function showLoading(message = 'Memproses...') {
        document.querySelector('.spinner-text').textContent = message;
        loadingOverlay.classList.add('show');
      }
      
      function hideLoading() {
        loadingOverlay.classList.remove('show');
      }
      
      // Toast notification function
      function showToast(message, type = 'success') {
        const background = type === 'success' ? '#1f9e76' : 
                           type === 'error' ? '#dc3545' : 
                           type === 'warning' ? '#ffc107' : '#0d6efd';
        Toastify({
          text: message,
          duration: 3000,
          close: true,
          gravity: "top",
          position: "right",
          style: { background },
          stopOnFocus: true
        }).showToast();
      }

      // Format bytes helper
      function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
      }
      
      // Filter buttons functionality
      const filterButtons = document.querySelectorAll('.filter-btn');
      const searchInput = document.getElementById('searchInput');
      const searchButton = document.getElementById('searchButton');
      const mediaContainer = document.getElementById('mediaContainer');
      
      // Set active class for filter buttons
      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Remove active class from all buttons
          filterButtons.forEach(btn => btn.classList.remove('btn-primary', 'active'));
          filterButtons.forEach(btn => btn.classList.add('btn-outline-primary'));
          
          // Add active class to clicked button
          this.classList.remove('btn-outline-primary');
          this.classList.add('btn-primary', 'active');
          
          const filterValue = this.getAttribute('data-filter');
          fetchFilteredMedia(filterValue, searchInput.value);
        });
      });
      
      // Search functionality
      searchButton.addEventListener('click', function() {
        const searchValue = searchInput.value;
        const activeFilter = document.querySelector('.filter-btn.active');
        const filterValue = activeFilter ? activeFilter.getAttribute('data-filter') : 'all';
        
        fetchFilteredMedia(filterValue, searchValue);
      });
      
      // Search on Enter key press
      searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
          const searchValue = searchInput.value;
          const activeFilter = document.querySelector('.filter-btn.active');
          const filterValue = activeFilter ? activeFilter.getAttribute('data-filter') : 'all';
          
          fetchFilteredMedia(filterValue, searchValue);
        }
      });
      
      // Fetch filtered media via AJAX
      function fetchFilteredMedia(filterType, searchText) {
        // Show loading indicator in the media container
        mediaContainer.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        
        // Prepare request parameters
        let params = {};
        if (filterType && filterType !== 'all') {
          params.type = filterType;
        }
        if (searchText) {
          params.search = searchText;
        }
        
        // Make AJAX request
        $.ajax({
          url: '{{ route("api.media.filter") }}', // Updated to use the correct API route
          type: 'GET',
          data: params,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              updateMediaDisplay(response.data);
            } else {
              mediaContainer.innerHTML = '<div class="col-12 text-center py-4"><p>Error loading media.</p></div>';
              showToast(response.message || 'Error loading media', 'error');
            }
          },
          error: function() {
            mediaContainer.innerHTML = '<div class="col-12 text-center py-4"><p>Error loading media.</p></div>';
            showToast('Gagal memuat data media', 'error');
          }
        });
      }
      
      // Update media display with fetched data
      function updateMediaDisplay(mediaData) {
        mediaContainer.innerHTML = '';
        
        if (mediaData.length === 0) {
          mediaContainer.innerHTML = '<div class="col-12 text-center py-4"><p>Tidak ada media yang sesuai dengan kriteria pencarian.</p></div>';
          return;
        }
        
        mediaData.forEach(item => {
          const mediaCard = document.createElement('div');
          mediaCard.className = 'col-md-4 col-lg-3 mb-4 media-item';
          mediaCard.setAttribute('data-type', item.type);
          mediaCard.setAttribute('data-name', item.name);
          
          mediaCard.innerHTML = `
            <div class="card h-100">
              <div class="card-body">
                <h6 class="card-title">${item.name}</h6>
                <p class="card-text"><span class="badge bg-info">${item.type}</span></p>
                <p class="card-text small">${item.created_at || item.date}</p>
              </div>
            </div>
          `;
          
          mediaContainer.appendChild(mediaCard);
        });
      }
      
      // File upload functionality
      const uploadArea = document.getElementById('uploadArea');
      const fileUpload = document.getElementById('fileUpload');
      const uploadButton = document.getElementById('uploadButton');
      const filePreview = document.getElementById('filePreview');
      const fileName = document.getElementById('fileName');
      const removeFile = document.getElementById('removeFile');
      const previewCanvas = document.getElementById('previewCanvas');
      const jenisMedia = document.getElementById('jenisMedia');
      const allowedTypesHint = document.getElementById('allowedTypesHint');
      const fileMeta = document.getElementById('fileMeta');
      const uploadProgressWrap = document.getElementById('uploadProgressWrap');
      const uploadProgress = document.getElementById('uploadProgress');

      // Update accept attribute and hint based on media type
      function updateAcceptAndHint() {
        const jm = jenisMedia.value;
        let accept = '';
        let hint = '';
        if (jm === 'image') {
          accept = 'image/jpeg,image/png,image/gif,image/webp';
          hint = 'Tipe gambar didukung: JPG, PNG, GIF, WEBP. Maks ukuran file 250MB.';
        } else if (jm === 'audio') {
          accept = 'audio/mpeg,audio/mp3,audio/wav,audio/ogg';
          hint = 'Tipe audio didukung: MP3, WAV, OGG. Maks ukuran file 250MB.';
        } else if (jm === 'video') {
          accept = 'video/mp4,video/mpeg,video/quicktime,video/webm';
          hint = 'Tipe video didukung: MP4, MPEG, MOV, WEBM. Maks ukuran file 250MB.';
        } else {
          accept = '';
          hint = 'Pilih jenis media untuk melihat tipe file yang didukung.';
        }
        fileUpload.setAttribute('accept', accept);
        allowedTypesHint.textContent = hint;
      }
      jenisMedia.addEventListener('change', updateAcceptAndHint);
      updateAcceptAndHint();
      
      uploadArea.addEventListener('click', function(e) {
        if (e.target !== removeFile && e.target !== removeFile.querySelector('i')) {
          fileUpload.click();
        }
      });
      
      uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('bg-light');
      });
      
      uploadArea.addEventListener('dragleave', function() {
        uploadArea.classList.remove('bg-light');
      });
      
      uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('bg-light');
        
        if (e.dataTransfer.files.length) {
          fileUpload.files = e.dataTransfer.files;
          updateFilePreview();
        }
      });
      
      fileUpload.addEventListener('change', updateFilePreview);
      
      function updateFilePreview() {
        if (fileUpload.files.length) {
          const file = fileUpload.files[0];
          fileName.textContent = file.name;
          filePreview.classList.remove('d-none');
          // build rich preview
          previewCanvas.innerHTML = '';
          const jm = jenisMedia.value;
          const url = URL.createObjectURL(file);
          // meta info
          fileMeta.textContent = `${file.type || 'unknown'} • ${formatBytes(file.size)}`;
          // Show the modal-preview button
          openPreviewBtn.classList.remove('d-none');
          if (jm === 'image') {
            const img = document.createElement('img');
            img.src = url;
            img.alt = 'Preview';
            img.style.maxWidth = '320px';
            img.style.maxHeight = '200px';
            img.style.borderRadius = '8px';
            previewCanvas.appendChild(img);
          } else if (jm === 'video') {
            const video = document.createElement('video');
            video.src = url;
            video.controls = true;
            video.style.maxWidth = '320px';
            video.style.maxHeight = '200px';
            previewCanvas.appendChild(video);
          } else if (jm === 'audio') {
            const audio = document.createElement('audio');
            audio.src = url;
            audio.controls = true;
            audio.style.width = '320px';
            previewCanvas.appendChild(audio);
          }
          
          // Auto-fill name field if empty
          const nameField = document.getElementById('namaFile');
          if (!nameField.value) {
            // Remove file extension from name
            const baseName = file.name.split('.').slice(0, -1).join('.');
            nameField.value = baseName;
          }

          // Auto-open the modal preview after selecting file
          openPreviewModal();
        } else {
          filePreview.classList.add('d-none');
          previewCanvas.innerHTML = '';
          fileMeta.textContent = '';
          uploadProgressWrap.classList.add('d-none');
          uploadProgress.setAttribute('aria-valuenow', '0');
          uploadProgress.style.width = '0%';
          uploadProgress.textContent = '0%';
          openPreviewBtn.classList.add('d-none');
        }
      }
      
      removeFile.addEventListener('click', function(e) {
        e.stopPropagation();
        fileUpload.value = '';
        filePreview.classList.add('d-none');
      });
      // Open modal on button click
      const openPreviewBtn = document.getElementById('openPreviewBtn');
      openPreviewBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        openPreviewModal();
      });
      // Also open when clicking the inline preview
      previewCanvas.addEventListener('click', function(e) {
        if (fileUpload.files.length) {
          openPreviewModal();
        }
      });

      function openPreviewModal() {
        const modalEl = document.getElementById('mediaPreviewModal');
        const modalBody = document.getElementById('modalPreviewContent');
        const modalTitle = document.getElementById('modalPreviewTitle');
        modalBody.innerHTML = '';
        let title = 'Preview';
        if (!fileUpload.files.length) return;
        const file = fileUpload.files[0];
        const jm = jenisMedia.value;
        const url = URL.createObjectURL(file);
        if (jm === 'image') {
          const img = document.createElement('img');
          img.src = url;
          img.alt = 'Preview';
          img.className = 'img-fluid rounded shadow';
          modalBody.appendChild(img);
          title = 'Preview Gambar';
        } else if (jm === 'video') {
          const video = document.createElement('video');
          video.src = url;
          video.controls = true;
          video.autoplay = true;
          video.style.width = '100%';
          video.className = 'rounded shadow';
          modalBody.appendChild(video);
          title = 'Preview Video';
        } else if (jm === 'audio') {
          const audio = document.createElement('audio');
          audio.src = url;
          audio.controls = true;
          audio.style.width = '100%';
          modalBody.appendChild(audio);
          title = 'Preview Audio';
        }
        modalTitle.textContent = title;
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
      }
      
      // Form validation and submission
      const mediaForm = document.getElementById('mediaForm');
      const resetButton = document.getElementById('resetButton');
      
      resetButton.addEventListener('click', function() {
        filePreview.classList.add('d-none');
        // Remove validation classes
        const formElements = mediaForm.querySelectorAll('.form-control, .form-select');
        formElements.forEach(element => {
          element.classList.remove('is-invalid');
        });
      });
      
      mediaForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        let isValid = true;
        const formElements = mediaForm.querySelectorAll('[required]');
        
        formElements.forEach(element => {
          if (!element.value) {
            element.classList.add('is-invalid');
            isValid = false;
          } else {
            element.classList.remove('is-invalid');
          }
        });
        
        // Check file upload
        if (!fileUpload.files.length) {
          uploadArea.classList.add('border-danger');
          showToast('Silakan pilih file untuk diunggah', 'warning');
          isValid = false;
        } else {
          uploadArea.classList.remove('border-danger');
        }
        
        if (isValid) {
          showLoading('Mengunggah media...');
          
          // Use FormData to handle file uploads
          const formData = new FormData(mediaForm);
          
          console.log('Submitting upload via AJAX:', { url: mediaForm.action, method: 'POST' });
          // Show progress UI
          uploadProgressWrap.classList.remove('d-none');
          uploadProgressWrap.removeAttribute('aria-hidden');
          uploadProgress.setAttribute('aria-valuenow', '0');
          uploadProgress.style.width = '0%';
          uploadProgress.textContent = '0%';

          $.ajax({
            url: mediaForm.action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
              const xhr = new window.XMLHttpRequest();
              if (xhr.upload) {
                xhr.upload.addEventListener('progress', function(e) {
                  if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    uploadProgress.setAttribute('aria-valuenow', String(percent));
                    uploadProgress.style.width = percent + '%';
                    uploadProgress.textContent = percent + '%';
                  }
                }, false);
              }
              return xhr;
            },
            success: function(response) {
              hideLoading();
              uploadProgressWrap.classList.add('d-none');
              if (response.success) {
                // Close preview modal if open
                const modalEl = document.getElementById('mediaPreviewModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) { modal.hide(); }
                showToast('Media berhasil diunggah', 'success', { style: { background: 'linear-gradient(to right, #00b09b, #96c93d)' } });
                // Reset form
                mediaForm.reset();
                filePreview.classList.add('d-none');
                previewCanvas.innerHTML = '';
                fileMeta.textContent = '';
                uploadProgress.setAttribute('aria-valuenow', '0');
                uploadProgress.style.width = '0%';
                uploadProgress.textContent = '0%';
                // Refresh media list
                const activeFilter = document.querySelector('.filter-btn.active');
                const filterValue = activeFilter ? activeFilter.getAttribute('data-filter') : 'all';
                fetchFilteredMedia(filterValue, '');
              } else {
                showToast(response.message || 'Gagal mengunggah media', 'error', { style: { background: 'linear-gradient(to right, #ff69b4, #ff3737)' } });
              }
            },
            error: function(xhr) {
              hideLoading();
              uploadProgressWrap.classList.add('d-none');
              let errorMessage = 'Gagal mengunggah media';
              
              if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
              } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors)[0][0];
              }
              
              showToast(errorMessage, 'error', { style: { background: 'linear-gradient(to right, #ff69b4, #ff3737)' } });
            }
          });
        }
      });
      
      // Set 'All' button as active by default and trigger initial load
      const allButton = document.querySelector('.filter-btn[data-filter="all"]');
      if (allButton) {
        allButton.classList.remove('btn-outline-primary');
        allButton.classList.add('btn-primary', 'active');
        fetchFilteredMedia('all', '');
      }
    });
  </script>
  
  <!-- Media Preview Modal (moved outside sidebar for correct z-index/visibility) -->
  <div class="modal fade" id="mediaPreviewModal" tabindex="-1" aria-labelledby="modalPreviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPreviewTitle">Preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-light">
          <div id="modalPreviewContent" class="w-100 d-flex justify-content-center align-items-center" style="min-height:280px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  </body>
  </html>
