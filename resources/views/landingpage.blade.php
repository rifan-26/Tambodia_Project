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

    /* Gambar kiri */
    .left-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 90%;
      height: 100%;
      background: url('img/danau_toba.svg') no-repeat center center;
      background-size: cover;
      z-index: 1;
    }

    /* Gambar kanan yang di-blur */
    .right-bg {
      position: absolute;
      top: 0;
      right: 0;
      width: 20%;
      height: 100%;
      background: url('img/danau_toba.svg') no-repeat center center;
      background-size: cover;
      filter: blur(15px);
      z-index: 1;
    }

    /* Gradasi pembatas kanan */
    .gradient-overlay-right {
      position: absolute;
      top: 0;
      left: 80%;
      width: 20%;
      height: 100%;
      background: linear-gradient(
        to right,
        rgba(20, 20, 20, 0.8) 0%,
        rgba(20, 20, 20, 0.4) 40%,
        rgba(20, 20, 20, 0) 100%
      );
      filter: blur(12px);
      mix-blend-mode: multiply;
      z-index: 2;
    }

    /* Gradasi pembatas kiri */
    .gradient-overlay-left {
      position: absolute;
      top: 0;
      left: 75%;
      width: 20%;
      height: 100%;
      background: linear-gradient(
        to left,
        rgba(20, 20, 20, 0.8) 0%,
        rgba(20, 20, 20, 0.4) 40%,
        rgba(20, 20, 20, 0) 100%
      );
      filter: blur(12px);
      mix-blend-mode: multiply;
      z-index: 2;
    }

    /* Konten teks */
    .text-content {
      position: relative;
      z-index: 3;
      color: white;
      padding: 3rem;
      max-width: 45%;
      margin-top: 15rem;
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

    .photo-column {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
      max-width: 50%;
    }

    .photo-column img {
      width: 100%;
      border-radius: 12px;
      object-fit: cover;
    }

    @media (max-width: 768px) {
      .hero {
        flex-direction: column;
        justify-content: flex-start;
        padding-top: 5rem;
        height: auto;
      }

      .text-content, .photo-column {
        max-width: 100%;
      }

      .text-content h1 {
        font-size: 2.5rem;
      }

      .text-content h2 {
        font-size: 1.5rem;
      }

      .text-content h3 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="hero">
    <div class="hero-container">
      <div class="left-bg"></div>
      <div class="right-bg"></div>
      <div class="gradient-overlay-left"></div>
      <div class="gradient-overlay-right"></div>
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
    <div class="photo-column">
      <img src="IMAGE1_URL" alt="Foto 1" />
      <img src="IMAGE2_URL" alt="Foto 2" />
      <img src="IMAGE3_URL" alt="Foto 3" />
      <img src="IMAGE4_URL" alt="Foto 4" />
    </div>
  </div>
</body>
</html>
