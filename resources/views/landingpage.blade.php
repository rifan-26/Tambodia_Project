<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BPS Sumatera Utara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
      display: flex;
      height: 100vh;
      width: 100vw;
      background: #0b0b0b;
    }

    /* Left section with background image and text */
    .left-section {
      flex: 3;
      position: relative;
      background-image: 
        linear-gradient(to bottom, rgba(0, 0, 0, 0) 70%, rgba(0, 0, 0, 0.8) 100%),
        url('img/danau toba img1.svg');
      background-size: cover;
      background-position: center;
      padding: 60px 60px 60px 80px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      color: white;
      text-shadow:
        1px 1px 3px rgba(0,0,0,0.9);
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
      position: relative; /* penting supaya ::before bisa absolute di dalamnya */
      flex: 1.5;
      padding: 20px;
      display: flex;
      flex-direction: column;
      z-index: 1;
      overflow: hidden;
    }

    .right-section::before {
      content: "";
      position: absolute;
      top: -10px; /* tambah ruang */
      left: -10px;
      right: -10px;
      bottom: -10px;
      background-image: 
        linear-gradient(to right, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.8) 100%),
        url('img/danau toba img1.svg');
      background-size: cover;
      background-position: center;
      filter: blur(8px);
      z-index: -1;
    }



    .row {
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
      padding-bottom: 335px;
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
      height: 50%; /* setengah tinggi col kanan */
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
      padding-bottom: 335px;
      margin-top: -170px; /* naik ke atas biar nyelip */
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
      height: 100%
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
      padding-bottom: 100%; /* 1:1 ratio */
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
  </style>
</head>
<body>
  <div class="container-left" role="main" aria-label="Welcome page for BPS Sumatera Utara">

    <section class="left-section" aria-labelledby="welcome-title" aria-describedby="welcome-description">
        <h1 id="welcome-title">Selamat Datang Di <span class="bps"><span class="b">B</span><span class="p">P</span><span class="s">S</span></span> Provinsi Sumatera Utara</h1>
        <p id="welcome-description">
          Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.
        </p>
    </section>

    <aside class="right-section" aria-label="Gallery of images representing Sumatera Utara and cultural elements">
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

          <div class="col">
            <div class="img-1-1-3">
              <img src="{{ asset('img/img 1.1 5.svg') }}" alt="Gambar1">
            </div>
          </div>
        </div>
      </div>
    </aside>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

