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

    /* Background video */
    .background-video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
    }

    /* YouTube background video specific styles */
    .youtube-bg {
      width: 100vw;
      height: 56.25vw; /* 16:9 aspect ratio */
      min-height: 100vh;
      min-width: 177.77vh; /* 16:9 aspect ratio */
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    /* Video overlay for better text readability */
    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      z-index: 1;
    }

    /* Left section with background image and text */
    .left-section {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: none;
      z-index: 2;
      padding: 60px 80px;
      color: white;
    }

    /* Video overlay */
    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 70%, rgba(0, 0, 0, 0.8) 100%);
      z-index: 1;
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
    }

    /* ===== LEGACY FALLBACK STYLES (for static layout) ===== */
    .img-potrait-1,
    .img-potrait-2 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 0;
      padding-bottom: 177.78%; /* portrait 9:16 */
    }

    .img-potrait-2 {
      margin-top: -140px;
      z-index: 2;
    }

    .img-1-1,
    .img-1-1-2 {
      position: relative;
      border: 4px solid #ffffff;
      border-radius: 4px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      cursor: default;
      width: 100%;
      height: 50%;
      padding-bottom: 100%; /* square 1:1 */
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
      padding-bottom: 56.25%; /* landscape 16:9 */
    }

    /* Common image styling for legacy containers */
    .img-potrait-1 img,
    .img-potrait-2 img,
    .img-1-1 img,
    .img-1-1-2 img,
    .img-1-1-3 img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease, box-shadow 0.4s ease, filter 0.4s ease;
    }

    .right-section img:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      filter: brightness(1.05) contrast(1.05);
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
    .layout-item[data-order="1"] {
      grid-column: 1;
      grid-row: 1;
      aspect-ratio: 1/1;
      height: auto;
    }

    /* Position 2: Top Right - Portrait (9:16) */
    .layout-item[data-order="2"] {
      grid-column: 2;
      grid-row: 1 / 3;
      aspect-ratio: 9/16;
      height: auto;
    }

    /* Position 3: Middle Left - Portrait (9:16) */
    .layout-item[data-order="3"] {
      grid-column: 1;
      grid-row: 2 / 4;
      aspect-ratio: 9/16;
      height: auto;
    }

    /* Position 4: Middle Right - Square (1:1) */
    .layout-item[data-order="4"] {
      grid-column: 2;
      grid-row: 3;
      aspect-ratio: 1/1;
      height: auto;
    }

    /* Position 5: Bottom Left - Landscape (16:9) */
    .layout-item[data-order="5"] {
      grid-column: 1;
      grid-row: 4;
      aspect-ratio: 16/9;
      height: auto;
    }

    /* Position 6: Bottom Right - Landscape (16:9) */
    .layout-item[data-order="6"] {
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
    .layout-item[data-order="1"] img,
    .layout-item[data-order="1"] video,
    .layout-item[data-order="1"] .youtube-video,
    .layout-item[data-order="4"] img,
    .layout-item[data-order="4"] video,
    .layout-item[data-order="4"] .youtube-video {
      aspect-ratio: 1/1;
      object-fit: cover;
    }

    /* Portrait Content (9:16) - Positions 2 & 3 */
    .layout-item[data-order="2"] img,
    .layout-item[data-order="2"] video,
    .layout-item[data-order="2"] .youtube-video,
    .layout-item[data-order="3"] img,
    .layout-item[data-order="3"] video,
    .layout-item[data-order="3"] .youtube-video {
      aspect-ratio: 9/16;
      object-fit: cover;
    }

    /* Landscape Content (16:9) - Positions 5 & 6 */
    .layout-item[data-order="5"] img,
    .layout-item[data-order="5"] video,
    .layout-item[data-order="5"] .youtube-video,
    .layout-item[data-order="6"] img,
    .layout-item[data-order="6"] video,
    .layout-item[data-order="6"] .youtube-video {
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
  <script>
    // Force video autoplay on page load
    document.addEventListener('DOMContentLoaded', function() {
      const backgroundVideo = document.querySelector('.background-video');
      if (backgroundVideo) {
        backgroundVideo.play().catch(function(error) {
          console.log('Video autoplay failed:', error);
        });
      }
    });
  </script>
  <div class="container-left" role="main" aria-label="Welcome page for BPS Sumatera Utara">
    
    @if($backgroundImage && $backgroundImage->type === 'Video')
      @php
        $isYouTube = strpos($backgroundImage->file_path, 'youtube.com') !== false || strpos($backgroundImage->file_path, 'youtu.be') !== false;
        $videoId = '';
        if ($isYouTube) {
          preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $backgroundImage->file_path, $matches);
          $videoId = $matches[1] ?? '';
        }
      @endphp
      
      @if($isYouTube && $videoId)
        <!-- YouTube background video -->
        <iframe class="background-video youtube-bg" 
                src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&playsinline=1&enablejsapi=1"
                frameborder="0" 
                allow="autoplay; encrypted-media" 
                allowfullscreen>
        </iframe>
        <div class="video-overlay"></div>
      @elseif(!$isYouTube)
        <!-- Background video for local files -->
        <video class="background-video" autoplay muted loop playsinline preload="auto">
          <source src="{{ asset('storage/' . $backgroundImage->file_path) }}" type="video/mp4">
          <source src="{{ asset('storage/' . $backgroundImage->file_path) }}" type="video/webm">
          <source src="{{ asset('storage/' . $backgroundImage->file_path) }}" type="video/ogg">
        </video>
        <div class="video-overlay"></div>
      @endif
    @endif

    <section class="left-section" aria-labelledby="welcome-title" aria-describedby="welcome-description">
        <h1 id="welcome-title">Selamat Datang Di <span class="bps"><span class="b">B</span><span class="p">P</span><span class="s">S</span></span> Provinsi Sumatera Utara</h1>
        <p id="welcome-description">
          {{ $description }}
        </p>
    </section>

    <aside class="right-section" aria-label="Gallery of images representing Sumatera Utara and cultural elements">
      @if($media && $media->count() > 0)
        <!-- Dynamic layout grid from layout manager -->
        <div class="layout-grid">
          @php
            // Sort media by layout_order to ensure proper positioning
            $sortedMedia = $media->sortBy('layout_order');
            // Create array with proper grid positioning
            $gridPositions = [];
            foreach($sortedMedia as $mediaItem) {
              $gridPositions[$mediaItem->layout_order] = $mediaItem;
            }
          @endphp
          
          @for($position = 1; $position <= 6; $position++)
            @if(isset($gridPositions[$position]))
              @php
                $mediaItem = $gridPositions[$position];
                $videoPath = $mediaItem->file_path;
                $isYouTube = str_contains($videoPath, 'youtube.com') || str_contains($videoPath, 'youtu.be');
                $videoId = '';
                if ($isYouTube) {
                  preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoPath, $matches);
                  $videoId = $matches[1] ?? '';
                }
              @endphp
              <div class="layout-item" 
                   data-order="{{ $mediaItem->layout_order }}"
                   data-media-type="{{ $mediaItem->type }}"
                   data-media-path="{{ $mediaItem->file_path }}"
                   data-media-name="{{ $mediaItem->name }}"
                   data-youtube-id="{{ $videoId }}"
                   style="cursor: pointer; grid-area: auto;">
                <div class="layout-order">{{ $mediaItem->layout_order }}</div>
              @if($mediaItem->type === 'Gambar')
                <img src="{{ asset('storage/' . $mediaItem->file_path) }}" alt="{{ $mediaItem->name }}" title="{{ $mediaItem->name }}">
              @elseif($mediaItem->type === 'Video')
                @if($isYouTube && $videoId)
                  <iframe 
                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
                    title="{{ $mediaItem->name }}"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                    class="youtube-video">
                  </iframe>
                @else
                  <video autoplay muted loop>
                    <source src="{{ asset('storage/' . $mediaItem->file_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                @endif
              @endif
              </div>
            @else
              <!-- Empty grid position -->
              <div class="layout-item" style="opacity: 0; pointer-events: none;"></div>
            @endif
          @endfor
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
  
  <!-- ===== MEDIA CLICK HANDLER & SCHEDULE SYSTEM ===== -->
  <script>
    // Schedule management system
    let scheduleCheckInterval;
    let audioCheckInterval;
    let currentScheduleData = null;
    let currentAudioData = null;
    let isScheduleActive = {{ $activeSchedules && $activeSchedules->count() > 0 ? 'true' : 'false' }};
    let currentAudioPlayer = null;
    let audioPlaylist = [];
    let currentAudioIndex = 0;

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

      // Initialize schedule checking system
      initScheduleSystem();
      
      // Initialize audio scheduling system
      initAudioSystem();
    });

    // Audio System Functions
    function initAudioSystem() {
      console.log('🎵 Initializing audio scheduling system');
      
      // Check for audio schedules immediately
      checkAudioSchedules();
      
      // Check every 30 seconds for new audio schedules
      audioCheckInterval = setInterval(checkAudioSchedules, 30000);
      
      // Check when page becomes visible again
      document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
          checkAudioSchedules();
        }
      });
    }

    // Check for active audio schedules
    async function checkAudioSchedules() {
      try {
        const response = await fetch('/api/public/landing/audio-schedules');
        const data = await response.json();
        
        if (data.success && data.has_active_audio) {
          console.log('🎵 Active audio schedules found:', data.audio_schedules.length);
          
          // Update audio playlist
          audioPlaylist = data.audio_schedules;
          
          // Start playing audio if not already playing
          if (!currentAudioPlayer || currentAudioPlayer.paused) {
            playScheduledAudio();
          }
        } else {
          console.log('🔇 No active audio schedules');
          
          // Stop current audio if playing
          if (currentAudioPlayer && !currentAudioPlayer.paused) {
            stopScheduledAudio();
          }
        }
      } catch (error) {
        console.error('❌ Error checking audio schedules:', error);
      }
    }

    // Play scheduled audio
    function playScheduledAudio() {
      if (audioPlaylist.length === 0) return;
      
      const audioSchedule = audioPlaylist[currentAudioIndex];
      console.log('🎵 Playing audio:', audioSchedule.media_name);
      
      // Create or update audio player
      if (currentAudioPlayer) {
        currentAudioPlayer.pause();
        currentAudioPlayer.remove();
      }
      
      currentAudioPlayer = new Audio('/storage/' + audioSchedule.media_path);
      currentAudioPlayer.volume = 0.7; // Set volume to 70%
      
      // Handle audio metadata loaded - get duration
      currentAudioPlayer.addEventListener('loadedmetadata', function() {
        const duration = currentAudioPlayer.duration;
        console.log('🎵 Audio duration:', Math.round(duration), 'seconds');
        
        // Show audio popup with duration info
        showAudioPopup(audioSchedule, duration);
      });
      
      // Handle audio end - move to next in playlist
      currentAudioPlayer.addEventListener('ended', function() {
        console.log('🎵 Audio ended, moving to next');
        hideAudioPopup();
        
        currentAudioIndex = (currentAudioIndex + 1) % audioPlaylist.length;
        
        // If we've played all audio files, wait 5 seconds before restarting
        if (currentAudioIndex === 0 && audioPlaylist.length > 1) {
          setTimeout(() => {
            playScheduledAudio();
          }, 5000);
        } else {
          playScheduledAudio();
        }
      });
      
      // Handle audio errors
      currentAudioPlayer.addEventListener('error', function(e) {
        console.error('❌ Audio playback error:', e);
        hideAudioPopup();
        
        // Try next audio in playlist
        currentAudioIndex = (currentAudioIndex + 1) % audioPlaylist.length;
        if (currentAudioIndex !== 0) {
          setTimeout(() => {
            playScheduledAudio();
          }, 2000);
        }
      });
      
      // Handle audio time updates for progress
      currentAudioPlayer.addEventListener('timeupdate', function() {
        updateAudioProgress();
      });
      
      // Start playing
      currentAudioPlayer.play().catch(function(error) {
        console.error('❌ Audio autoplay failed:', error);
        // Show manual play button in popup
        updateAudioPopupForManualPlay(audioSchedule);
      });
    }

    // Stop scheduled audio
    function stopScheduledAudio() {
      if (currentAudioPlayer) {
        currentAudioPlayer.pause();
        currentAudioPlayer.currentTime = 0;
      }
      hideAudioPopup();
      console.log('🔇 Audio playback stopped');
    }

    // Show audio popup indicator
    function showAudioPopup(audioSchedule, duration = null) {
      // Remove existing popup
      hideAudioPopup();
      
      const durationText = duration ? formatDuration(duration) : 'Loading...';
      
      const popup = document.createElement('div');
      popup.id = 'audioPopup';
      popup.innerHTML = `
        <div style="
          position: fixed;
          top: 20px;
          right: 20px;
          background: linear-gradient(135deg, #1f9e76 0%, #16a085 100%);
          color: white;
          padding: 15px 20px;
          border-radius: 10px;
          box-shadow: 0 4px 20px rgba(31, 158, 118, 0.3);
          z-index: 9999;
          display: flex;
          align-items: center;
          gap: 10px;
          min-width: 300px;
          backdrop-filter: blur(10px);
          border: 1px solid rgba(255, 255, 255, 0.1);
        ">
          <div style="
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: audioRotate 2s linear infinite;
          ">
            <i class="bi bi-music-note-beamed" style="font-size: 18px;"></i>
          </div>
          <div style="flex: 1;">
            <div style="font-weight: 600; font-size: 14px; margin-bottom: 2px;">
              🎵 Audio Terjadwal
            </div>
            <div style="font-size: 12px; opacity: 0.9; margin-bottom: 4px;">
              ${audioSchedule.media_name}
            </div>
            <div style="font-size: 11px; opacity: 0.8; display: flex; align-items: center; gap: 5px;">
              <span id="audioCurrentTime">0:00</span>
              <div style="
                flex: 1;
                height: 2px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 1px;
                overflow: hidden;
              ">
                <div id="audioProgressBar" style="
                  height: 100%;
                  background: rgba(255, 255, 255, 0.8);
                  width: 0%;
                  transition: width 0.1s ease;
                "></div>
              </div>
              <span id="audioDuration">${durationText}</span>
            </div>
          </div>
          <button onclick="stopScheduledAudio()" style="
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
          ">
            <i class="bi bi-x" style="font-size: 16px;"></i>
          </button>
        </div>
      `;
      
      document.body.appendChild(popup);
      
      // Add rotation animation
      const style = document.createElement('style');
      style.textContent = `
        @keyframes audioRotate {
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
        }
        @keyframes audioPulse {
          0%, 100% { transform: scale(1); }
          50% { transform: scale(1.05); }
        }
      `;
      document.head.appendChild(style);
    }

    // Update popup for manual play
    function updateAudioPopupForManualPlay(audioSchedule) {
      const popup = document.getElementById('audioPopup');
      if (popup) {
        popup.innerHTML = `
          <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(255, 193, 7, 0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 280px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
          ">
            <button onclick="manualPlayAudio()" style="
              width: 40px;
              height: 40px;
              background: rgba(255, 255, 255, 0.2);
              border: none;
              color: white;
              border-radius: 50%;
              cursor: pointer;
              display: flex;
              align-items: center;
              justify-content: center;
            ">
              <i class="bi bi-play-fill" style="font-size: 18px;"></i>
            </button>
            <div style="flex: 1;">
              <div style="font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                🎵 Klik untuk Putar Audio
              </div>
              <div style="font-size: 12px; opacity: 0.9;">
                ${audioSchedule.media_name}
              </div>
            </div>
            <button onclick="hideAudioPopup()" style="
              background: rgba(255, 255, 255, 0.2);
              border: none;
              color: white;
              width: 30px;
              height: 30px;
              border-radius: 50%;
              cursor: pointer;
              display: flex;
              align-items: center;
              justify-content: center;
            ">
              <i class="bi bi-x" style="font-size: 16px;"></i>
            </button>
          </div>
        `;
      }
    }

    // Manual play audio function
    function manualPlayAudio() {
      if (currentAudioPlayer) {
        currentAudioPlayer.play().then(() => {
          // Update popup back to playing state
          const audioSchedule = audioPlaylist[currentAudioIndex];
          showAudioPopup(audioSchedule);
        }).catch(error => {
          console.error('❌ Manual audio play failed:', error);
        });
      }
    }

    // Update audio progress
    function updateAudioProgress() {
      if (!currentAudioPlayer) return;
      
      const currentTime = currentAudioPlayer.currentTime;
      const duration = currentAudioPlayer.duration;
      
      if (duration && !isNaN(duration)) {
        const progress = (currentTime / duration) * 100;
        
        // Update progress bar
        const progressBar = document.getElementById('audioProgressBar');
        if (progressBar) {
          progressBar.style.width = progress + '%';
        }
        
        // Update current time display
        const currentTimeEl = document.getElementById('audioCurrentTime');
        if (currentTimeEl) {
          currentTimeEl.textContent = formatDuration(currentTime);
        }
        
        // Update duration display
        const durationEl = document.getElementById('audioDuration');
        if (durationEl && durationEl.textContent === 'Loading...') {
          durationEl.textContent = formatDuration(duration);
        }
      }
    }

    // Format duration in MM:SS format
    function formatDuration(seconds) {
      if (!seconds || isNaN(seconds)) return '0:00';
      
      const minutes = Math.floor(seconds / 60);
      const remainingSeconds = Math.floor(seconds % 60);
      return minutes + ':' + (remainingSeconds < 10 ? '0' : '') + remainingSeconds;
    }

    // Hide audio popup
    function hideAudioPopup() {
      const popup = document.getElementById('audioPopup');
      if (popup) {
        popup.remove();
      }
    }

    // Schedule System Functions - DISABLED TO PREVENT REFRESH LOOPS
    function initScheduleSystem() {
      console.log('🕐 Schedule system disabled to prevent refresh loops');
      
      // All schedule checking disabled
      // checkScheduleUpdates();
      // scheduleCheckInterval = setInterval(checkScheduleUpdates, 60000);
      // document.addEventListener('visibilitychange', function() {
      //   if (!document.hidden) {
      //     checkScheduleUpdates();
      //   }
      // });
    }

    // DISABLED - Function that was causing refresh loops
    async function checkScheduleUpdates() {
      console.log('⏸️ Schedule checking disabled to prevent refresh loops');
      return;
    }


    // Clean up intervals when page unloads
    window.addEventListener('beforeunload', function() {
      if (scheduleCheckInterval) {
        clearInterval(scheduleCheckInterval);
      }
      if (audioCheckInterval) {
        clearInterval(audioCheckInterval);
      }
      if (currentAudioPlayer) {
        currentAudioPlayer.pause();
      }
    });

    // Debug function to manually check schedule
    window.checkSchedule = checkScheduleUpdates;
  </script>
</body>
</html>

