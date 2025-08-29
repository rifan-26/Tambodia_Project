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
      width: 100%;
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
      z-index: 3;
      font-family: 'Playfair Display', serif;
      font-weight: 450;
      font-size: clamp(2rem, 5vw, 4rem);
      line-height: 1.2;
      letter-spacing: 1px;
      margin: 0;
      padding: 2rem 0;
      max-width: 650px;
      color: #fff;
      text-shadow:
        0 4px 10px rgba(0, 0, 0, 0.6),
        0 0 25px rgba(0, 0, 0, 0.4);
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    /* Right section with images grid */
    .right-section {
      position: relative;
      width: 100%;
      max-width: 1100px;
      min-height: 850px;
      padding: 35px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 3;
      overflow: hidden;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 15px;
      border: 1px solid rgba(255,255,255,0.1);
    }

    .layout-images {
      position: relative;
      z-index: 3;
      width: 100%;
      max-width: 1100px;
      height: auto;
      display: flex;
      flex-direction: column;
      justify-content: center;
      overflow: visible;
    }

    .images-grid { 
      display: grid; 
      grid-template-columns: 1fr 1fr;
      grid-template-rows: auto auto auto auto;
      grid-template-areas: 
        "img1 img2"
        "img3 img2" 
        "img3 img4" 
        "img5 img6"; 
      gap: 2.5rem; 
      width: 100%; 
      height: 85vh;
      align-items: center;
      justify-items: center;
    }

    .layout-image {
      border-radius: 8px;
      overflow: hidden;
      background: #111;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      cursor: pointer;
    }

    .layout-image img,
    .layout-image video,
    .layout-image iframe {
      width: 100%;
      height: 100%;
      object-fit: cover; /* isi penuh, sesuai rasio grid */
      display: block;
    }

    .layout-image:hover img {
      transform: scale(1.04);
      filter: brightness(0.95);
    }

    .layout-image:nth-child(1) { 
      grid-area: img1; 
      aspect-ratio: 1 / 1; 
      min-height: 300px;
      max-height: 350px;
    }
    .layout-image:nth-child(2) { 
      grid-area: img2; 
      aspect-ratio: 9 / 16; 
      min-height: 480px;
      max-height: 550px;
    }
    .layout-image:nth-child(3) {
      grid-area: img3; 
      aspect-ratio: 9 / 16; 
      min-height: 480px;
      max-height: 550px;
    }
    .layout-image:nth-child(4) { 
      grid-area: img4; 
      aspect-ratio: 1 / 1; 
      min-height: 300px;
      max-height: 350px;
    }
    .layout-image:nth-child(5) { 
      grid-area: img5; 
      aspect-ratio: 16 / 9; 
      min-height: 200px;
      max-height: 250px;
    }
    .layout-image:nth-child(6) { 
      grid-area: img6; 
      aspect-ratio: 16 / 9; 
      min-height: 200px;
      max-height: 250px;
    }

    .text-content h1 {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: bold;
      margin-bottom: 0.1rem;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .bps-word {
      font-weight: 700;
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.5rem, 6vw, 3.5rem);
      line-height: 1.2;
    }

    .provinsi-word {
      font-size: clamp(2rem, 5vw, 3.1rem);
      font-weight: 500;
      color: white;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .text-content h3 {
      font-size: clamp(1.8rem, 4.5vw, 3rem);
      font-weight: 700;
      margin-bottom: 0.4rem;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .text-content p {
      font-size: clamp(1rem, 2.5vw, 1.4rem);
      line-height: 1.6;
      font-family: "Marcellus", serif;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
      margin-top: 1rem;
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
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      padding: 0 2rem;
      max-width: 1200px;
      margin: 0 auto;
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

    /* Desktop - Large screens */
    @media (min-width: 1200px) {
      .hero-container {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        padding: 0 3rem;
      }
      
      .right-section {
        position: absolute;
        top: 0;
        right: 0;
        width: 48%;
        height: 100vh;
        max-width: none;
        border-radius: 0;
        border-left: 1px solid rgba(255,255,255,0.1);
        border: none;
        padding: 35px;
      }
      
      .text-content {
        max-width: 47%;
        text-align: left;
      }
      
      .images-grid {
        gap: 2.8rem;
        height: 90vh;
      }
    }

    /* Tablet - Medium screens */
    @media (max-width: 1199px) and (min-width: 769px) {
      .hero-container {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        gap: 3rem;
      }
      
      .text-content {
        text-align: center;
        max-width: 100%;
        order: 1;
      }
      
      .right-section {
        order: 2;
        width: 100%;
        max-width: 950px;
        min-height: 700px;
        padding: 35px;
      }
      
      .images-grid {
        gap: 2.2rem;
        height: 70vh;
      }
      
      .layout-image:nth-child(1),
      .layout-image:nth-child(4) {
        min-height: 220px;
        max-height: 270px;
      }
      
      .layout-image:nth-child(2),
      .layout-image:nth-child(3) {
        min-height: 350px;
        max-height: 420px;
      }
      
      .layout-image:nth-child(5),
      .layout-image:nth-child(6) {
        min-height: 160px;
        max-height: 200px;
      }
    }

    /* Mobile - Small screens */
    @media (max-width: 768px) {
      .hero {
        height: 100vh;
        padding: 0;
      }
      
      .hero-container {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        gap: 2rem;
      }
      
      .text-content {
        text-align: center;
        max-width: 100%;
        padding: 1rem 0;
        order: 1;
      }
      
      .right-section {
        order: 2;
        width: 100%;
        max-width: 100%;
        min-height: 500px;
        padding: 30px;
      }
      
      .images-grid {
        gap: 1.5rem;
        height: 60vh;
        grid-template-areas: 
          "img1 img2"
          "img3 img4"
          "img5 img6";
        grid-template-rows: auto auto auto;
      }
      
      .layout-image:nth-child(1),
      .layout-image:nth-child(2),
      .layout-image:nth-child(3),
      .layout-image:nth-child(4) {
        aspect-ratio: 1 / 1;
        min-height: 180px;
        max-height: 220px;
      }
      
      .layout-image:nth-child(5),
      .layout-image:nth-child(6) {
        aspect-ratio: 16 / 9;
        min-height: 120px;
        max-height: 160px;
      }
    }

    /* Extra small screens */
    @media (max-width: 480px) {
      .hero-container {
        padding: 0.5rem;
        gap: 1.5rem;
      }
      
      .text-content {
        padding: 0.5rem 0;
      }
      
      .right-section {
        min-height: 450px;
        padding: 30px;
      }
      
      .images-grid {
        gap: 1.2rem;
        height: 50vh;
      }
      
      .layout-image:nth-child(1),
      .layout-image:nth-child(2),
      .layout-image:nth-child(3),
      .layout-image:nth-child(4) {
        min-height: 150px;
        max-height: 180px;
      }
      
      .layout-image:nth-child(5),
      .layout-image:nth-child(6) {
        min-height: 110px;
        max-height: 140px;
      }
    }

    /* Media section responsive */
    @media (max-width: 768px) {
      .media-section {
        padding: 3rem 0;
      }
      
      .media-section h2 {
        font-size: 2rem;
        margin-bottom: 2rem;
      }
      
      .media-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 0 1rem;
      }
    }

    /* Touch improvements for mobile */
    @media (hover: none) and (pointer: coarse) {
      .layout-image {
        cursor: default;
      }
      
      .layout-image:hover img {
        transform: none;
        filter: none;
      }
      
      .layout-image:active img {
        transform: scale(0.98);
        filter: brightness(0.9);
      }
      
      .media-card:hover {
        transform: none;
      }
      
      .media-card:active {
        transform: scale(0.98);
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
        <div class="right-section">
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
