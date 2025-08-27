<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Selamat Datang di BPS Sumatera Utara</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.plyr.io/3.7.8/plyr.css" rel="stylesheet" />
  <style>
 @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Open+Sans&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      overflow: hidden;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }

    .hero {
      height: 100vh;
      width: 100vw;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .hero-container {
      width: 100%;
      height: 100vh;
      overflow: hidden;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      gap: 2rem;
      flex-wrap: wrap; /* allow wrapping to prevent collision at mid widths */
    }

    /* Background image with dynamic content */
    .bg-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      z-index: 1;
      transition: opacity 1s ease-in-out;
    }

    /* Gradient overlay */
    .gradient-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        to right,
        rgba(0, 0, 0, 0.7) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.7) 100%
      );
      z-index: 2;
    }

    /* Konten teks */
    .text-content {
      position: relative;
      z-index: 2;
      font-family: 'Playfair Display', serif;
      font-weight: 450px;
      font-size: 70px; /* sedikit lebih besar */
      line-height: 1.2;
      letter-spacing: 1px; /* spasi antar huruf */
      margin-top: 220px; /* sedikit lebih rapat ke atas */
      margin-bottom: 20px;
      max-width: 650px;
      color: #fff;
      text-shadow:
        0 4px 10px rgba(0, 0, 0, 0.6), /* shadow lembut */
        0 0 25px rgba(0, 0, 0, 0.4);    /* glow tambahan */
    }

    /* Layout Images Grid */
    .layout-images {
      position: relative;
      z-index: 3;
      width: 420px;
      height: auto; /* let grid determine height */
      flex: 0 0 auto;
      overflow: visible;
    }

    .images-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-areas:
        "img1 img2"
        "img3 img2"
        "img3 img4"
        "img5 img6";
      gap: 1.2rem;
      align-content: start;
    }

    .layout-image {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .layout-image img,
    .layout-image video,
    .layout-image iframe {
      width: 100%;
      height: 100%;
      object-fit: contain;
      object-position: center;
      display: block;
      transition: transform 0.25s ease, filter 0.25s ease;
      will-change: transform;
    }

    .layout-image:hover img {
      transform: scale(1.04);
      filter: brightness(0.95);
    }

    .layout-image:nth-child(1) { grid-area: img1; aspect-ratio: 1 / 1; }

    .layout-image:nth-child(2) { grid-area: img2; aspect-ratio: 9 / 16; }

    .layout-image:nth-child(3) { grid-area: img3; aspect-ratio: 9 / 16; }

    .layout-image:nth-child(4) { grid-area: img4; aspect-ratio: 1 / 1; }

    .layout-image:nth-child(5) { grid-area: img5; aspect-ratio: 16 / 9; }

    .layout-image:nth-child(6) { grid-area: img6; aspect-ratio: 16 / 9; }

    .text-content h1 {
      font-size: 2.8rem;
      font-weight: bold;
      margin-bottom: 0.1rem;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .bps-word {
       font-weight: 700;
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
      line-height: 1.2;
    }

    .provinsi-word {
      font-size: 3.1rem;
      font-weight: 500;
      color: white;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .text-content h3 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 0.4rem;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .text-content p {
      font-size: 1.4rem;
      line-height: 1.6;
      font-family: "Marcellus", serif;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    /* Media section */
    .media-section {
      background-color: #f8f9fa;
      padding: 5rem 0;
      color: #333;
    }

    .media-section h2 {
      font-size: 2.5rem;
      text-align: center;
      margin-bottom: 3rem;
      color: #2c3a67;
    }

    .media-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 2rem;
      padding: 0 2rem;
    }

    .media-card {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      background-color: white;
    }

    .media-card:hover {
      transform: translateY(-5px);
    }

    .media-content {
      position: relative;
      width: 100%;
      height: 0;
      padding-bottom: 56.25%; /* 16:9 aspect ratio */
      overflow: hidden;
    }

    .media-content img, 
    .media-content video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .media-info {
      padding: 1.5rem;
    }

    .media-info h3 {
      font-size: 1.25rem;
      margin-bottom: 0.5rem;
      color: #2c3a67;
    }

    .media-info p {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 0.5rem;
    }

    .media-type {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .media-type.image {
      background-color: #e3f2fd;
      color: #1976d2;
    }

    .media-type.video {
      background-color: #fce4ec;
      color: #c2185b;
    }

    .media-type.audio {
      background-color: #e8f5e9;
      color: #388e3c;
    }

    /* Audio player styling */
    .audio-container {
      padding: 1rem;
      background-color: #f5f5f5;
      border-radius: 8px;
    }

    .plyr--audio .plyr__control.plyr__tab-focus,
    .plyr--audio .plyr__control:hover,
    .plyr--audio .plyr__control[aria-expanded=true] {
      background: #1F9E76;
    }

    .plyr--audio .plyr__control.plyr__tab-focus {
      box-shadow: 0 0 0 5px rgba(31, 158, 118, 0.5);
    }

    .plyr--audio .plyr__progress__buffer {
      color: rgba(31, 158, 118, 0.5);
    }

    .plyr--full-ui input[type=range] {
      color: #1F9E76;
    }

    /* Footer */
    footer {
      background-color: #2c3a67;
      color: white;
      padding: 2rem 0;
      text-align: center;
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .hero {
        height: 100vh;
        padding: 0;
      }
      .hero-container {
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
      }
      .text-content {
        max-width: 100%;
        margin: 0;
        padding: 1rem;
        text-align: center;
        flex: none;
      }
      .layout-images {
        position: relative;
        right: auto;
        top: auto;
        transform: none;
        width: 100%;
        margin-top: 2rem;
      }
    }
    @media (max-width: 992px) {
      .hero {
        height: 100vh;
        padding: 0;
      }

      .hero-container {
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
      }

      .text-content {
        max-width: 100%;
        margin: 0;
        padding: 1rem;
        text-align: center;
        flex: none;
      }

      .layout-images {
        position: relative;
        right: auto;
        top: auto;
        transform: none;
        width: 100%;
        margin-top: 2rem;
      }
      /* Keep the same areas on mobile/tablet but the container will be narrower */
    }

    @media (max-width: 768px) {
      .text-content h1 {
        font-size: 2rem;
      }

      .bps-word {
        font-size: 2.5rem;
      }

      .provinsi-word {
        font-size: 2rem;
      }

      .text-content h3 {
        font-size: 1.8rem;
      }

      .text-content p {
        font-size: 1rem;
      }

      .layout-images {
        height: 300px;
      }
    }
  </style>
</head>
<body>
  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-container">
      @if(isset($backgroundImage) && $backgroundImage)
        <div class="bg-image" style="background-image: url('{{ asset('storage/' . $backgroundImage->file_path) }}');"></div>
      @else
        <div class="bg-image" style="background-image: url('{{ asset('img/danau_toba.svg') }}');"></div>
      @endif
      <div class="gradient-overlay"></div>
      <div class="text-content">
        <h1>Selamat Datang Di</h1>
        <h2>
          <span class="bps-word">
            <span style="color:#0071BC;">B</span><span style="color:#8CC63F;">P</span><span style="color:#F7931E;">S</span>
          </span>
          <span class="provinsi-word">Provinsi</span>
        </h2>
        <h3>Sumatera Utara</h3>
        <p>
          {{ $description }}
        </p>
      </div>

      <!-- Layout Images Grid -->
      @if(isset($layoutImages) && $layoutImages->count() > 0)
        <div class="layout-images">
          <div class="images-grid">
            @foreach($layoutImages->take(6) as $image)
              @php
                $path = $image->file_path;
                $isExternal = \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']);
                $src = $isExternal ? $path : asset('storage/' . $path);
                $ytId = null;
                if ($image->type === 'Video') {
                  // Use ~ delimiter to avoid escaping slashes
                  if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([\w-]{11})~i', $src, $m)) {
                    $ytId = $m[1];
                  }
                }
              @endphp
              @if($image->type === 'Video')
                <div class="layout-image" data-media="video" data-src="{{ $src }}" @if($ytId) data-ytid="{{ $ytId }}" @endif data-name="{{ e($image->name) }}">
                  @if($ytId)
                    <div class="ratio ratio-16x9" style="width:100%; height:100%;">
                      <iframe src="https://www.youtube.com/embed/{{ $ytId }}?autoplay=1&mute=1&playsinline=1" title="{{ $image->name }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                  @else
                    <video src="{{ $src }}" autoplay muted playsinline controls preload="metadata" style="width:100%; height:100%; object-fit:contain;">
                      Browser Anda tidak mendukung pemutar video.
                    </video>
                  @endif
                </div>
              @else
                <div class="layout-image" data-media="image" data-src="{{ asset('storage/' . $image->file_path) }}" data-name="{{ e($image->name) }}">
                  <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->name }}">
                </div>
              @endif
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>

  <!-- Media Preview Modal (Image / Video) -->
  <div class="modal fade" id="mediaPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-transparent border-0">
        <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0 d-flex justify-content-center align-items-center">
          <div id="mediaPreviewContainer" style="width:100%; max-width: 90vw; max-height: 85vh; display:flex; align-items:center; justify-content:center;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Signage mode: remove gallery and footer to keep single screen -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize audio players
      const audioPlayers = document.querySelectorAll('.audio-player');
      if (audioPlayers.length > 0) {
        audioPlayers.forEach(player => {
          new Plyr(player, {
            controls: ['play','progress','current-time','mute','volume']
          });
        });
      }

      // Media preview modal logic (image + video)
      const modalEl = document.getElementById('mediaPreviewModal');
      const container = document.getElementById('mediaPreviewContainer');
      const bsModal = modalEl ? new bootstrap.Modal(modalEl) : null;

      function escapeHtml(text){
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
      }

      function openMediaModal(el){
        if(!bsModal || !container) return;
        const type = el.getAttribute('data-media');
        const src = el.getAttribute('data-src');
        const name = el.getAttribute('data-name') || '';
        const ytid = el.getAttribute('data-ytid');

        let html = '';
        if(type === 'image'){
          html = `<img src="${src}" alt="${escapeHtml(name)}" style="max-width:100%; max-height:85vh; object-fit:contain;"/>`;
        } else if(type === 'video'){
          if(ytid){
            html = `<div class="ratio ratio-16x9" style="width:100%; max-width:1000px;"><iframe src="https://www.youtube.com/embed/${ytid}?autoplay=1" title="${escapeHtml(name)}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
          } else {
            html = `<video controls autoplay playsinline style="width:100%; max-width:1000px; max-height:85vh;"><source src="${src}">Browser Anda tidak mendukung pemutar video.</video>`;
          }
        }
        container.innerHTML = html;
        bsModal.show();
      }

      document.querySelectorAll('.layout-image').forEach(el => {
        el.addEventListener('click', () => openMediaModal(el));
      });

      // Clear modal content on hide to stop playback
      if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', () => {
          if(container) container.innerHTML = '';
        });
      }
    });
  </script>
</body>
</html>
