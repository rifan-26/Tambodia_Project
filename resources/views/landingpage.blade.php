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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: "Marcellus SC", serif;
      color: white;
      scroll-behavior: smooth;
      overflow: hidden; /* signage: no scroll */
    }

    .hero {
      position: relative;
      height: 100vh;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      padding: 2rem;
    }

    .hero-container {
      width: 100%;
      height: 100vh;
      overflow: hidden;
      position: relative;
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
      color: white;
      padding: 3rem;
      max-width: 45%;
      margin-top: 5rem;
    }

    .text-content h1 {
      font-size: 2.8rem;
      font-weight: bold;
      margin-bottom: 0.1rem;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
    }

    .bps-word {
      font-size: 3.8rem;
      margin-right: 0.1px;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
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
    @media (max-width: 992px) {
      .hero {
        flex-direction: column;
        height: auto;
        padding: 5rem 1rem;
      }

      .text-content {
        max-width: 100%;
        margin-top: 2rem;
        padding: 1rem;
      }

      .media-container {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .text-content h1 {
        font-size: 2.2rem;
      }

      .bps-word {
        font-size: 3rem;
      }

      .provinsi-word {
        font-size: 2.5rem;
      }

      .text-content h3 {
        font-size: 2.2rem;
      }

      .text-content p {
        font-size: 1.1rem;
      }

      .media-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-container">
      @if(isset($media) && $media->where('type', 'Gambar')->count() > 0)
        <div class="bg-image" style="background-image: url('{{ asset('storage/' . $media->where('type', 'Gambar')->first()->file_path) }}');"></div>
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
          Kami adalah lembaga resmi pemerintah yang bertugas <br>
          menyelenggarakan kegiatan statistik di wilayah <br>
          Sumatera Utara. BPS hadir untuk memberikan data akurat, <br>
          terpercaya, dan terkini.
        </p>
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

      // Background image rotation for hero section
      const imageElements = @json($media->where('type', 'Gambar')->pluck('file_path'));
      
      if (imageElements && imageElements.length > 1) {
        let currentIndex = 0;
        const bgImage = document.querySelector('.bg-image');
        
        setInterval(() => {
          currentIndex = (currentIndex + 1) % imageElements.length;
          bgImage.style.opacity = 0;
          
          setTimeout(() => {
            bgImage.style.backgroundImage = `url('{{ asset('storage') }}/${imageElements[currentIndex]}')`;  
            bgImage.style.opacity = 1;
          }, 1000);
        }, 5000);
      }
    });
  </script>
</body>
</html>
