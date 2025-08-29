<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BPS Sumatera Utara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Open+Sans&display=swap');

    * {
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Open Sans', sans-serif;
      background-color: #0b0b0b;
      color: white;
      height: 100vh;
      overflow-x: hidden;
    }

    .container-left {
      display: relative;
      height: 100vh;
      width: 100vw;
      overflow: hidden;
      background: #0b0b0b;
    }

    /* Left section with background image and text */
    .left-section {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        linear-gradient(to bottom, rgba(0, 0, 0, 0) 70%, rgba(0, 0, 0, 0.8) 100%),
        @if($backgroundImage)
          url('{{ asset("storage/" . $backgroundImage->file_path) }}')
        @else
          url('img/danau toba img1.svg')
        @endif;
      background-size: cover;
      background-position: center;
      padding: 60px 80px;
      color: white;
      z-index: 1; /* biar di bawah gallery */
    }

    .left-section h1 {
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

    .left-section p {
      max-width: 620px;
      font-size: 1.25rem;
      line-height: 1.7;
      letter-spacing: 0.3px;
      color: #f5f5f5;
      text-shadow:
      0 4px 8px rgba(0, 0, 0, 0.7),   /* shadow utama lebih tebal */
      0 0 12px rgba(0, 0, 0, 0.5),    /* glow sedang */
      0 0 30px rgba(0, 0, 0, 0.4);    /* glow lebar */
    }

    /* Highlight for BPS letters */
    .bps {
      font-weight: 700;
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
      line-height: 1.2;
    }
    .bps .b {
      color: #0c77d2; /* Blue shade */
    }
    .bps .p {
      color: #1cd03d; /* Mustard/Gold shade */
    }
    .bps .s {
      color: #f8bc08; /* Orange shade */
    }

    /* Right section with images grid */
    .right-section {
      position: absolute;
      top: 0;
      right: 0;
      width: 30%;   /* sesuaikan lebar gallery */
      height: 100%;
      flex: 1.5;
      padding: 20px;
      display: flex;
      flex-direction: column;
      z-index: 2;
      overflow: hidden;
      background: rgba(0, 0, 0, 0.3); /* semi transparan */
      backdrop-filter: blur(12px);    /* blur area di belakang */
      -webkit-backdrop-filter: blur(12px); /* untuk Safari */
      border-left: 1px solid rgba(255,255,255,0.1);
    }

    .right-section::before {
      display: none;
    }

    .row {
      margin-top: 5px;
      margin-bottom: 20px;
    }

    .img-potrait-1 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 0;
      padding-bottom: 177.78%; /* 16/9 * 100 = 177.78% → portrait 9:16 */
    }

    .img-potrait-1 img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .img-1-1 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 50%; 
      padding-bottom: 100%;
    }

    .img-1-1 img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .img-potrait-2 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 0;
      padding-bottom: 177.78%; /* 16/9 * 100 = 177.78% → portrait 9:16 */
      margin-top: -140px; /* naik ke atas biar nyelip */
      z-index: 2;        /* pastikan tampil di atas */
    }

    .img-potrait-2 img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .img-1-1-2 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 50%; 
      padding-bottom: 100%;
    }

    .img-1-1-2 img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .img-1-1-3 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 0;
      padding-bottom: 56.25%; /* 9/16 = 0.5625 */
    }

    .img-1-1-3 img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .right-section img {
      transition: transform 0.4s ease, box-shadow 0.4s ease, filter 0.4s ease;
    }

    .right-section img:hover {
      transform: scale(1.05); /* zoom sedikit */
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* shadow lebih tebal saat hover */
      filter: brightness(1.05) contrast(1.05); /* sedikit lebih terang & kontras */
    }

    /* ===== LAYOUT GRID SYSTEM ===== */
    .layout-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: repeat(4, 1fr);
      gap: 1rem;
      height: 100%;
    }

    /* ===== GRID POSITIONING & ASPECT RATIOS ===== */
    /* Position 1: Top Left - Square (1:1) */
    .layout-item:nth-child(1) {
      grid-column: 1;
      grid-row: 1;
      aspect-ratio: 1/1;
      height: auto;
    }

    /* Position 2: Top Right - Portrait (9:16) */
    .layout-item:nth-child(2) {
      grid-column: 2;
      grid-row: 1 / 3;
      aspect-ratio: 9/16;
      height: auto;
    }

    /* Position 3: Middle Left - Portrait (9:16) */
    .layout-item:nth-child(3) {
      grid-column: 1;
      grid-row: 2 / 4;
      aspect-ratio: 9/16;
      height: auto;
    }

    /* Position 4: Middle Right - Square (1:1) */
    .layout-item:nth-child(4) {
      grid-column: 2;
      grid-row: 3;
      aspect-ratio: 1/1;
      height: auto;
    }

    /* Position 5: Bottom Left - Landscape (16:9) */
    .layout-item:nth-child(5) {
      grid-column: 1;
      grid-row: 4;
      aspect-ratio: 16/9;
      height: auto;
    }

    /* Position 6: Bottom Right - Landscape (16:9) */
    .layout-item:nth-child(6) {
      grid-column: 2;
      grid-row: 4;
      aspect-ratio: 16/9;
      height: auto;
    }

    /* ===== LAYOUT ITEM STYLING ===== */
    .layout-item {
      position: relative;
      background: white;
      border: 3px solid #ffffff;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 120px;
    }

    .layout-item:hover {
      border-color: #1f9e76;
      box-shadow: 0 6px 20px rgba(31, 158, 118, 0.2);
      transform: translateY(-2px);
    }

    /* ===== MODAL STYLING ===== */
    .modal-xl {
      max-width: 90%;
    }

    .youtube-modal-container {
      position: relative;
      width: 100%;
      height: 500px;
    }

    .youtube-modal-container iframe {
      width: 100%;
      height: 100%;
      border-radius: 8px;
    }

    #modalMediaContent img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    #modalMediaContent video {
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* ===== MEDIA CONTENT STYLING ===== */
    .layout-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .layout-item video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .layout-item .youtube-video {
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 8px;
    }

    /* ===== ASPECT RATIO CONTROL ===== */
    /* Square Content (1:1) - Positions 1 & 4 */
    .layout-item:nth-child(1) img,
    .layout-item:nth-child(1) video,
    .layout-item:nth-child(1) .youtube-video,
    .layout-item:nth-child(4) img,
    .layout-item:nth-child(4) video,
    .layout-item:nth-child(4) .youtube-video {
      aspect-ratio: 1/1;
      object-fit: cover;
    }

    /* Portrait Content (9:16) - Positions 2 & 3 */
    .layout-item:nth-child(2) img,
    .layout-item:nth-child(2) video,
    .layout-item:nth-child(2) .youtube-video,
    .layout-item:nth-child(3) img,
    .layout-item:nth-child(3) video,
    .layout-item:nth-child(3) .youtube-video {
      aspect-ratio: 9/16;
      object-fit: cover;
    }

    /* Landscape Content (16:9) - Positions 5 & 6 */
    .layout-item:nth-child(5) img,
    .layout-item:nth-child(5) video,
    .layout-item:nth-child(5) .youtube-video,
    .layout-item:nth-child(6) img,
    .layout-item:nth-child(6) video,
    .layout-item:nth-child(6) .youtube-video {
      aspect-ratio: 16/9;
      object-fit: cover;
    }

    /* ===== OVERLAY ELEMENTS ===== */
    .layout-item .video-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 6px 12px;
      border-radius: 15px;
      font-size: 0.7rem;
      display: flex;
      align-items: center;
      gap: 4px;
      z-index: 2;
    }

    .layout-item .layout-order {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #1f9e76;
      color: white;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: bold;
      z-index: 2;
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
      }
      .left-section, .right-section {
        flex: none;
        width: 100%;
        height: auto;
        padding: 30px 20px;
      }
      .left-section h1 {
        font-size: 2.5rem;
      }
      .right-section {
        flex-wrap: wrap;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 12px;
        padding: 20px;
        max-height: none;
      }
      .img-large-blue {
        grid-column: span 3;
        height: 250px;
      }
      .img-large-blue img {
        height: 100%;
      }
      .right-column-small, .small-image-row, .bottom-row {
        grid-column: span 3;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 12px;
      }
      .right-column-small img,
      .small-image-row img,
      .bottom-row img {
        height: 150px;
        border: none;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
        border-radius: 6px;
      }
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
      .layout-grid {
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: auto;
        height: auto;
        gap: 12px;
      }
      
      .layout-item {
        min-height: 100px;
      }
      
      /* Reset grid positioning for mobile */
      .layout-item:nth-child(1),
      .layout-item:nth-child(2),
      .layout-item:nth-child(3),
      .layout-item:nth-child(4),
      .layout-item:nth-child(5),
      .layout-item:nth-child(6) {
        grid-column: span 1;
        grid-row: auto;
      }

      /* Maintain aspect ratios on mobile */
      .layout-item:nth-child(1),
      .layout-item:nth-child(4) {
        aspect-ratio: 1/1;
        height: auto;
      }
      
      .layout-item:nth-child(2),
      .layout-item:nth-child(3) {
        aspect-ratio: 9/16;
        height: auto;
      }
      
      .layout-item:nth-child(5),
      .layout-item:nth-child(6) {
        aspect-ratio: 16/9;
        height: auto;
      }
    }
  </style>
</head>
<body>
  <div class="container-left" role="main" aria-label="Welcome page for BPS Sumatera Utara">

    <section class="left-section" aria-labelledby="welcome-title" aria-describedby="welcome-description">
        <h1 id="welcome-title">Selamat Datang Di <span class="bps"><span class="b">B</span><span class="p">P</span><span class="s">S</span></span> Provinsi Sumatera Utara</h1>
        <p id="welcome-description">
          {{ $description }}
        </p>
    </section>

    <aside class="right-section" aria-label="Gallery of images representing Sumatera Utara and cultural elements">
      @if($layoutImages && $layoutImages->count() > 0)
        <!-- Dynamic layout grid from layout manager -->
        <div class="layout-grid">
          @foreach($layoutImages as $media)
            @php
              $videoPath = $media->file_path;
              $isYouTube = str_contains($videoPath, 'youtube.com') || str_contains($videoPath, 'youtu.be');
              $videoId = '';
              if ($isYouTube) {
                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoPath, $matches);
                $videoId = $matches[1] ?? '';
              }
            @endphp
            <div class="layout-item" 
                 data-order="{{ $media->layout_order }}"
                 data-media-type="{{ $media->type }}"
                 data-media-path="{{ $media->file_path }}"
                 data-media-name="{{ $media->name }}"
                 data-youtube-id="{{ $videoId }}"
                 style="cursor: pointer;">
              <div class="layout-order">{{ $media->layout_order }}</div>
              @if($media->type === 'Gambar')
                <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->name }}" title="{{ $media->name }}">
              @elseif($media->type === 'Video')
                @if($isYouTube && $videoId)
                  <div class="video-overlay">
                    <i class="bi bi-play-circle"></i>
                    YouTube Video
                  </div>
                  <iframe 
                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
                    title="{{ $media->name }}"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                    class="youtube-video">
                  </iframe>
                @else
                  <video autoplay muted loop>
                    <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                @endif
              @endif
            </div>
          @endforeach
        </div>
      @else
        <!-- Fallback static layout when no media is configured -->
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="img-1-1">
                <img src="{{ asset('img/img 1.1.svg') }}" alt="Gambar2">
              </div>
            </div>

            <div class="col">
              <div class="img-potrait-1">
                <img src="{{ asset('img/img potrait.svg') }}" alt="Gambar1">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="img-potrait-2">
                <img src="{{ asset('img/img potrait 2.svg') }}" alt="Gambar2">
              </div>
            </div>

            <div class="col">
              <div class="img-1-1-2">
                <img src="{{ asset('img/img 1.1 2.svg') }}" alt="Gambar1">
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col">
              <div class="img-1-1-3">
                <img src="{{ asset('img/img 1.1 3.svg') }}" alt="Gambar2">
              </div>
            </div>

            <div class="col">
              <div class="img-1-1-3">
                <img src="{{ asset('img/img 1.1 4.svg') }}" alt="Gambar1">
              </div>
            </div>
          </div>
        </div>
      @endif
    </aside>
  </div>

  <!-- ===== MEDIA MODAL ===== -->
  <div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mediaModalLabel">Media Preview</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div id="modalMediaContent">
            <!-- Media content will be loaded here -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
  <!-- ===== MEDIA CLICK HANDLER ===== -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mediaModal = new bootstrap.Modal(document.getElementById('mediaModal'));
      const modalContent = document.getElementById('modalMediaContent');
      const modalTitle = document.getElementById('mediaModalLabel');
      
      // Add click event to all layout items
      document.querySelectorAll('.layout-item').forEach(function(item) {
        item.addEventListener('click', function() {
          const mediaType = this.getAttribute('data-media-type');
          const mediaPath = this.getAttribute('data-media-path');
          const mediaName = this.getAttribute('data-media-name');
          const isYouTube = this.getAttribute('data-youtube-id');
          
          if (mediaType && mediaPath) {
            modalTitle.textContent = mediaName || 'Media Preview';
            
            if (mediaType === 'Video' && isYouTube) {
              // YouTube video
              modalContent.innerHTML = `
                <div class="youtube-modal-container">
                  <iframe 
                    src="https://www.youtube.com/embed/${isYouTube}?autoplay=1&mute=1&loop=1&playlist=${isYouTube}&controls=1&showinfo=1&rel=0&modestbranding=1&playsinline=1" 
                    width="100%" 
                    height="500" 
                    frameborder="0" 
                    allowfullscreen>
                  </iframe>
                </div>
              `;
            } else if (mediaType === 'Video') {
              // Local video
              modalContent.innerHTML = `
                <video controls autoplay muted loop width="100%" height="500">
                  <source src="/storage/${mediaPath}" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
              `;
            } else {
              // Image
              modalContent.innerHTML = `
                <img src="/storage/${mediaPath}" alt="${mediaName}" class="img-fluid" style="max-height: 70vh; object-fit: contain;">
              `;
            }
            
            mediaModal.show();
          }
        });
      });
    });
  </script>
</body>
</html>

