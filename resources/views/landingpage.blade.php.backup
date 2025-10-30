<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BPS Sumatera Utara - Digital Signage</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Override Bootstrap defaults to preserve custom design */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    

    body {
      font-family: 'Roboto', sans-serif !important;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }
    
    /* Prevent Bootstrap from affecting custom elements */
    .main-container,
    .header,
    .header-wrapper,
    .welcome-section,
    .gallery {
      max-width: none !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
    }

    .main-container {
      width: 100vw;
      height: 100vh;
      background: white;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      position: relative;
      z-index: 0;
    }

    .header-wrapper {
      position: relative;
      overflow: visible;
    }

    .header {
      position: relative;
      background: linear-gradient(to bottom, #092058 45%, #1345BE 100%);
      color: white;
      padding: 40px 40px;
      overflow: visible;
      z-index: 1;
      text-align: center;
    }

    .header > * {
      position: relative;
      z-index: 3;
    }

    /* Garis emas di bawah header */
    .header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: linear-gradient(to right, #FFA726 0%, #FFB74D 50%, #FFA726 100%);
      z-index: 4;
    }

    /* Posisi logo kiri-kanan */
    .logos {
      position: relative;
    }

    .logo {
      width: 70px;
      height: auto;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
    }

    .logo-left {
      left: 20px !important;
    }

    .logo-right {
      right: 20px !important;
    }

    .title h1 {
      font-size: 25px;
    }

    .title p {
      font-size: 15px;
    }

    /* Responsif agar tetap di ujung dan proporsional */
    @media (min-width: 640px) {
      .logo {
        width: 90px;
      }

      .title h1 {
        font-size: 30px
      }

      .title p {
        font-size: 20px;
      }
    }



    /* Welcome Section */
    .welcome-section {
      background: url('{{ asset('img/batikbiru.png') }}') center center;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      color: white;
      padding: 25px 40px;
      position: relative;
      overflow: visible;
      z-index: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
      height: 260px;
    }

    .welcome-section::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
      background-size: 20px 20px;
      animation: none;
      z-index: 0;
    }

    @keyframes float {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .welcome-text {
      position: relative;
      z-index: 1;
      flex: 0 0 auto;
    }

    .welcome-text h2 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 0;
      line-height: 1.3;
      margin: 0 0 0 20px;
      white-space: nowrap;
      text-shadow: -1px 3px 1px rgba(0, 0, 0, 0.5);
    }

    .staff-container {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      margin: 20px 20px 0 0;
      position: relative;
      z-index: 1;
      flex: 1;
    }

    .staff-member {
      text-align: center;
      position: relative;
    }

    .staff-photo-wrapper {
      display: inline-flex;
      gap: 15px;
      justify-content: center;
      margin: 0 auto 5px auto;
    }

    .staff-photo {
      width: 80px;
      height: 100px;
      background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
      border-radius: 8px;
      margin-bottom: 8px;
      border: 3px solid white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: #666;
      margin-left: auto;
      margin-right: auto;
      overflow: hidden;
    }

    .staff-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Container info kiri & kanan menjadi satu baris */
    .staff-info-kiri,
    .staff-info-kanan {
      display: inline-block;
      background: rgba(0, 0, 0, 0.3);
      padding: 5px 10px;
      font-size: 10px;
      font-weight: 500;
      width: 90px;
      vertical-align: middle;
      text-align: left;
    }

    /* Radius sesuai sisi */
    .staff-info-kiri {
      border-radius: 10px 0 0 10px;
    }

    .staff-info-kanan {
      border-radius: 0 10px 10px 0;
    }

    .staff-info-wrapper {
      display: inline-flex;
      gap: 0;
      justify-content: center;
      margin: 0 auto 5px auto;
    }


    .staff-name-kiri {
      margin-top: 5px;
      font-size: 15px;
      font-weight: 500;
      margin-right: 30px;
      text-shadow: 2px 3px 1px rgba(0, 0, 0, 0.5);
    }

    .staff-name-kanan {
      margin-top: 5px;
      font-size: 15px;
      font-weight: 500;
      text-shadow: 2px 3px 1px rgba(0, 0, 0, 0.5);
    }

    .staff-name-wrapper {
      display: inline-flex;
      gap: 15px;
      justify-content: center;
      margin: 0 auto 5px auto;
    }


    @media (min-width: 490px) {
      .welcome-text h2 {
        font-size: 18px;
        margin-left: 60px !important;
      }

      .staff-container {
        margin-right: 70px !important;
      }
    }

    /* Gallery Section */
    .gallery {
      flex: 1;
      padding: 20px 60px 80px 60px;
      overflow: hidden;
      position: relative;
    }

    .gallery::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('{{ asset('img/batikmerah.png') }}') center center;
      background-size: cover;
      background-repeat: no-repeat;
      z-index: -1;
    }

    .gallery .container {
      max-width: 100%;
      height: 100%;
      gap: 15px;
      padding: 0 15px;
    }

    .gallery .row {
      display: flex !important;
      flex-wrap: nowrap;
      gap: 15px;
      margin-bottom: 15px;
      position: relative;
    }

    .gallery .row-custom {
      display: flex;
      align-items: flex-end; /* biar item besar di bawah sejajar */
      gap: 15px;
      position: relative;
      margin-left: 0 !important;
      margin-right: 0 !important;
    }


    /* Semua col-3 di row-custom ukuran sama */
    .gallery .row-custom .col-3 {
      flex: 0 0 calc(25% - 11.25px);
      max-width: calc(25% - 11.25px);
    }

    /* Biar jarak antar kolom rapat */
    .gallery .col-3,
    .gallery .col-9 {
      padding: 0;
    }

    /* Styling item */
    .gallery-item {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
      height: 100%;
    }

    .gallery-item:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    }

    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* Aspect ratio poster untuk item 1 (row 1, col-3) - Kebijakan memanjang */
    .gallery .row:first-child .col-3 {
      position: absolute;
      left: 0;
      top: 0;
      z-index: 2;
      width: calc(25% - 11.25px);
    }

    .gallery .row:first-child .col-3 .gallery-item {
      aspect-ratio: 11/27;
      height: auto;
    }

    /* Sosialisasi mengambil ruang sisa */
    .gallery .row:first-child .col-9 {
      margin-left: calc(25% + 3.75px);
      flex: 0 0 calc(75% - 11.25px);
      max-width: calc(75% - 11.25px);
    }

    /* Row kedua: No Tip dan PST portrait di bawah Kebijakan */
    .gallery .row:last-child .col-3:nth-child(1) {
      flex: 0 0 calc(12.5% - 11.25px);
      max-width: calc(12.5% - 11.25px);
    }

    .gallery .row:last-child .col-3:nth-child(1) .gallery-item {
      aspect-ratio: 4/6;
      height: auto;
    }

    .gallery .row:last-child .col-3:nth-child(2) {
      flex: 0 0 calc(12.5% - 11.25px);
      max-width: calc(12.5% - 11.25px);
    }

    .gallery .row:last-child .col-3:nth-child(2) .gallery-item {
      aspect-ratio: 4/6;
      height: auto;
    }

    /* Gratifikasi dan Release lebih besar */
    .gallery .row:last-child .col-3:nth-child(3) {
      flex: 0 0 calc(37.5% - 11.25px);
      max-width: calc(37.5% - 11.25px);
    }

    .gallery .row:last-child .col-3:nth-child(3) .gallery-item {
      aspect-ratio: 3/4;
      height: auto;
    }

    .gallery .row:last-child .col-3:nth-child(4) {
      flex: 0 0 calc(37.5% - 11.25px);
      max-width: calc(37.5% - 11.25px);
    }

    .gallery .row:last-child .col-3:nth-child(4) .gallery-item {
      aspect-ratio: 3/4;
      height: auto;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .gallery {
        padding: 15px 30px;
      }

      .gallery .row:first-child,
      .gallery .row:last-child {
        height: auto;
        min-height: 200px;
      }

      .gallery-item {
        min-height: 180px;
      }

      .gallery .container {
        transform: scale(0.9);
        transform-origin: center;
      }

      .gallery .row-custom {
        margin-left: 0 !important;
        margin-right: 0 !important;
        gap: 15px !important;
      }

      .gallery .row-custom .col-3,
      .gallery .row-custom .small-item,
      .gallery .row-custom .big-item {
        flex: 0 0 calc(25% - 11.25px);
        max-width: calc(25% - 11.25px);
      }
    }

    @media (max-width: 576px) {
      .gallery {
        padding: 10px 20px;
      }

      .gallery .container {
        gap: 10px;
        transform: scale(0.9);
        transform-origin: center;
      }

      .gallery .row {
        gap: 10px !important;
      }

      .gallery .row:first-child,
      .gallery .row:last-child {
        min-height: 150px;
      }

      .gallery .row:last-child{
        transform: scale(0.9);
        transform-origin: center;
      }

      .gallery .row-custom {
        gap: 25px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        justify-content: center;
      }

      .gallery .row-custom .col-3 .gallery-item {
        transform: scale(1.1);
        transition: transform 0.3s ease;
      }


      .gallery .row-custom .col-3,
      .gallery .row-custom .small-item,
      .gallery .row-custom .big-item {
        flex: 0 0 calc(25% - 7.5px);
        max-width: calc(25% - 7.5px);
      }

      .gallery-item {
        min-height: 150px;
        border-radius: 10px;
      }
    }

    @media (max-width: 450px) {
      .gallery .row-custom {
        gap: 15px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        justify-content: center;
      }

      .gallery .row-custom .col-3 .gallery-item {
        transform: scale(0.9);
        transition: transform 0.3s ease;
      }
    }
      

    @media (max-width: 400px) {
      .gallery {
        padding: 10px 15px;
      }

      .gallery .container {
        padding: 0 10px;
      }

      .gallery-item {
        min-height: 120px;
      }

      .gallery .row:first-child .col-3,
      .gallery .row:first-child .col-9 {
        flex: 0 0 100%;
        max-width: 100%;
      }

      .gallery .row-custom .col-3,
      .gallery .row-custom .small-item,
      .gallery .row-custom .big-item {
        flex: 0 0 calc(50% - 7.5px) !important;
        max-width: calc(50% - 7.5px) !important;
      }

      .gallery .row-custom {
        gap: 10px;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }

      /* Pertahankan aspect ratio poster di mobile */
      .gallery .row:first-child .col-3 .gallery-item,
      .gallery .row:last-child .col-3:nth-child(3) .gallery-item,
      .gallery .row:last-child .col-3:nth-child(4) .gallery-item {
        aspect-ratio: 2/3;
        height: auto;
        min-height: unset;
      }
    }

    /* Footer Section */
    .footer {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: #092058;
      padding: 15px 0;
      z-index: 10;
      box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .social-icons a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-style: italic; /* buat teks miring */
    }
    /* Kotak icon */
    .social-icons i {
      background-color: white;
      color: #092058;
      border-radius: 4px; /* bisa ubah ke 0 kalau mau kotak tegas */
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      transition: all 0.3s ease;
    }

    /* Teks akun */
    .social-icons span {
      font-style: italic;
      color: white;
      font-size: 16px;
    }

    @media (max-width: 768px) {
      .social-icons {
        flex-wrap: wrap;
        font-size: 16px !important;
        gap: 15px !important;
      }

      .social-icons a {
        font-size: 16px;
      }

      .social-icons i {
        font-size: 20px;
      }
    }

    @media (max-width: 576px) {
      .social-icons {
        flex-wrap: wrap;
        font-size: 10px !important;
        gap: 5px !important;
      }

      .social-icons a {
        font-size: 10px;
      }

      .social-icons i {
        font-size: 15px;
        width: 22px;
        height: 22px;
      }

      .social-icons a[href*="facebook.com"] span,
      .social-icons a[href*="instagram.com"] span {
        margin-right: 6px; /* bisa ubah sesuai selera (contoh: 8px atau 10px) */
      }
    }

    /* ===== LANDSCAPE ORIENTATION LAYOUT ===== */
    @media (orientation: landscape) and (min-width: 768px) {
      .main-container {
        flex-direction: row;
      }

      /* Left Section: Header + Welcome + No Tip & PST */
      .left-content {
        width: 45%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
      }

      .header {
        padding: 15px 20px;
      }

      .header::after {
        height: 4px;
      }

      .logo {
        width: 45px;
      }

      .logo-left {
        left: 10px !important;
      }

      .logo-right {
        right: 10px !important;
      }

      .title h1 {
        font-size: 18px;
      }

      .title p {
        font-size: 11px;
      }

      .welcome-section {
        flex: 1;
        height: auto;
        padding: 15px 20px;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
        gap: 30px;
        padding-top: 40px;
      }

      /* Container untuk tulisan dan No Tip/PST */
      .welcome-section > div:first-child {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        padding-left: 40px;
      }

      .welcome-text {
        flex: 0 0 auto;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 20px;
      }

      .welcome-text h2 {
        font-size: 20px;
        margin-left: 0 !important;
        margin-bottom: 0;
        text-align: center;
        writing-mode: horizontal-tb;
      }

      /* Sembunyikan No Tip & PST dari gallery di landscape */
      .gallery .row:last-child .col-3:nth-child(1),
      .gallery .row:last-child .col-3:nth-child(2) {
        display: none;
      }

      /* Style untuk No Tip & PST container di welcome section */
      .notip-pst-container {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 20px;
      }

      .notip-pst-container .col-3 {
        width: 100px !important;
        height: 100px !important;
      }

      .notip-pst-container .gallery-item {
        width: 100%;
        height: 100%;
      }

      .staff-container {
        margin: 0;
        width: auto;
        justify-content: center;
        gap: 15px;
        flex: 1;
      }

      .staff-photo-wrapper {
        gap: 25px;
      }

      .staff-photo {
        width: 150px;
        height: 190px;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        width: 160px;
        font-size: 14px;
        padding: 8px 12px;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 18px;
      }

      /* Right Section: Gallery */
      .gallery {
        width: 55%;
        height: 100vh;
        padding: 20px 20px 80px 20px;
        display: flex;
        flex-direction: column;
      }

      .gallery .container {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: 1.5fr 1fr;
        gap: 15px;
        height: 100%;
        padding: 0;
      }

      /* Reset row styles for landscape */
      .gallery .row {
        display: contents !important;
      }

      .gallery .row-custom {
        display: contents !important;
      }

      /* Sosialisasi - Top, full width dengan padding untuk centered */
      .gallery .row:first-child .col-9 {
        grid-column: 1 / 7;
        grid-row: 1;
        margin-left: 0;
        flex: none;
        max-width: none;
        padding: 0 40px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .gallery .row:first-child .col-9 .gallery-item {
        aspect-ratio: 16/9;
        height: 100%;
        width: 100%;
      }

      /* Kebijakan - Bottom left, spans 2 columns */
      .gallery .row:first-child .col-3 {
        position: static;
        grid-column: 1 / 3;
        grid-row: 2;
        width: auto;
        flex: none;
        max-width: none;
      }

      .gallery .row:first-child .col-3 .gallery-item {
        aspect-ratio: 3/4;
        height: 100%;
      }

      /* Gratifikasi - Bottom center, spans 2 columns (sama dengan Kebijakan) */
      .gallery .row:last-child .col-3:nth-child(3) {
        grid-column: 3 / 5;
        grid-row: 2;
        flex: none;
        max-width: none;
        position: static;
      }

      .gallery .row:last-child .col-3:nth-child(3) .gallery-item {
        aspect-ratio: 3/4;
        height: 100%;
      }

      /* Release - Bottom right, spans 2 columns (sama dengan Kebijakan) */
      .gallery .row:last-child .col-3:nth-child(4) {
        grid-column: 5 / 7;
        grid-row: 2;
        flex: none;
        max-width: none;
        display: block;
      }

      .gallery .row:last-child .col-3:nth-child(4) .gallery-item {
        aspect-ratio: 3/4;
        height: 100%;
      }

      /* Footer adjustments for landscape */
      .footer {
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
        width: 100%;
        padding: 8px 0;
      }

      .social-icons {
        gap: 12px;
      }

      .social-icons a {
        font-size: 12px;
      }

      .social-icons i {
        width: 26px;
        height: 26px;
        font-size: 14px;
      }

      .social-icons span {
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="left-content">
      <!-- Header -->
      <div class="header-wrapper">
        <div class="header">
          <div class="logos position-relative text-center">
            <!-- Logo kiri -->
            <img src="{{ asset('img/Group 25.png') }}" alt="Logo BPS" class="logo logo-left position-absolute start-0 top-50 translate-middle-y">

            <!-- Judul tengah -->
            <div class="title d-inline-block">
              <h1 class="mb-0">SELAMAT DATANG</h1>
              <p class="mb-0">Di Kantor BPS Provinsi Sumatera Utara</p>
            </div>

            <!-- Logo kanan -->
            <img src="{{ asset('img/Group 19.png') }}" alt="Logo Sumut" class="logo logo-right position-absolute end-0 top-50 translate-middle-y">
          </div>
        </div>
      </div>
      

      <!-- Welcome Section -->
      <div class="welcome-section">
      <div class="welcome-text">
        <h2>HARI INI ANDA AKAN<br>DI LAYANI OLEH :</h2>
      </div>
      
      <div class="container staff-container justify-content-end">
        <!-- Staff Kiri -->
        <div class="staff-member">
          @php
            $staffLeft = $staff->where('position', 1)->first();
            $staffRight = $staff->where('position', 2)->first();
          @endphp
          <div class="row">
            <div class="col">
              <div class="staff-photo-wrapper">
                <div class="staff-photo">
                  @if($staffLeft && $staffLeft->photo_path)
                    <img src="{{ asset('storage/' . $staffLeft->photo_path) }}" alt="{{ $staffLeft->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                  @endif
                </div>
                <div class="staff-photo">
                  @if($staffRight && $staffRight->photo_path)
                    <img src="{{ asset('storage/' . $staffRight->photo_path) }}" alt="{{ $staffRight->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="staff-info-wrapper">
                <div class="staff-info-kiri">{{ $staffLeft ? 'PETUGAS PST' : 'PETUGAS PST' }}</div>
                <div class="staff-info-kanan">{{ $staffRight ? 'PETUGAS PPID' : 'PETUGAS PPID' }}</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="staff-name-wrapper">
                <div class="staff-name-kiri">{{ $staffLeft->name ?? 'Nama' }}</div>
                <div class="staff-name-kanan">{{ $staffRight->name ?? 'Nama' }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <!-- Gallery -->
    <div class="gallery">
      <div class="container">
        <div class="row">
          <div class="col-3">
            <!-- Item 1: Portrait kiri atas (Kebijakan MUTU) -->            <div class="gallery-item">              @php $item1 = $media->where('layout_order', 1)->first(); @endphp              @if($item1)                @if($item1->type === 'Gambar')                  <img src="{{ asset('storage/' . $item1->file_path) }}" alt="{{ $item1->name }}" loading="lazy">                @elseif($item1->type === 'Video')                  <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset('storage/' . $item1->file_path) }}" type="video/mp4"></video>                @endif              @endif            </div>
          </div>
          <div class="col-9">
            <!-- Item 2: Landscape besar kanan atas (Sosialisasi) -->        
            <div class="gallery-item">
              @php $item2 = $media->where('layout_order', 2)->first(); @endphp
              @if($item2)
                @if($item2->type === 'Gambar')
                  <img src="{{ asset('storage/' . $item2->file_path) }}" alt="{{ $item2->name }}" loading="lazy">
                @elseif($item2->type === 'Video')
                  <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset('storage/' . $item2->file_path) }}" type="video/mp4"></video>
                @endif
              @endif
            </div>
          </div>
        </div>

        <div class="row row-custom">
          <div class="col-3 small-item">
            <!-- Item 3: Square kiri bawah (No Tips) - STATIC -->
            <div class="gallery-item">
              <!-- Static content for No Tips -->
            </div>
          </div>
          <div class="col-3 small-item">
            <!-- Item 4: Square tengah (Pelayanan Statistik) - STATIC -->
            <div class="gallery-item">
              <!-- Static content for Pelayanan Statistik -->
            </div>
          </div>
          <div class="col-3 big-item">
            <!-- Item 5: Square (Release) - DYNAMIC Position 3 -->
            <div class="gallery-item">
              @php $item5 = $media->where('layout_order', 3)->first(); @endphp
              @if($item5)
                @if($item5->type === 'Gambar')
                  <img src="{{ asset('storage/' . $item5->file_path) }}" alt="{{ $item5->name }}" loading="lazy">
                @elseif($item5->type === 'Video')
                  <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset('storage/' . $item5->file_path) }}" type="video/mp4"></video>
                @endif
              @endif
            </div>
          </div>
          <div class="col-3 big-item">
            <!-- Item 6: Square (Gratifikasi) - DYNAMIC Position 4 -->
            <div class="gallery-item gallery-item-text">
              @php $item6 = $media->where('layout_order', 4)->first(); @endphp
              @if($item6)
                @if($item6->type === 'Gambar')
                  <img src="{{ asset('storage/' . $item6->file_path) }}" alt="{{ $item6->name }}" loading="lazy">
                @elseif($item6->type === 'Video')
                  <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset('storage/' . $item6->file_path) }}" type="video/mp4"></video>
                @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="social-icons d-flex justify-content-center align-items-center gap-4 flex-wrap">
            <a href="https://www.tiktok.com/@bps_sumut" target="_blank" class="d-flex align-items-center">
              <i class="fab fa-tiktok"></i>
            </a>
            <a href="https://www.tiktok.com/@bps_sumut" target="_blank" class="d-flex align-items-center">
              <i class="fa-brands fa-threads"></i>
            </a>
            <a href="https://www.instagram.com/bps_sumut" target="_blank" class="d-flex align-items-center">
              <i class="fab fa-instagram"></i>
              <span class="ms-2">bps_sumut</span>
            </a>
            <a href="https://www.facebook.com/bpssumut" target="_blank" class="d-flex align-items-center">
              <i class="fab fa-facebook"></i>
              <span class="ms-2">bpssumut</span>
            </a>
            <a href="https://www.youtube.com/@BPSumut" target="_blank" class="d-flex align-items-center">
              <i class="fab fa-youtube"></i>
              <span class="ms-2">@BPSumut</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Font Awesome CDN -->
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Bootstrap 5 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- Script untuk memindahkan No Tip & PST ke welcome section di landscape -->
  <script>
    function moveNoTipPSTToWelcome() {
      const isLandscape = window.matchMedia("(orientation: landscape) and (min-width: 768px)").matches;
      const noTip = document.querySelector('.gallery .row:last-child .col-3:nth-child(1)');
      const pst = document.querySelector('.gallery .row:last-child .col-3:nth-child(2)');
      const welcomeSection = document.querySelector('.welcome-section');

      if (isLandscape && noTip && pst && welcomeSection) {
        // Cek apakah sudah ada container untuk No Tip & PST
        let noTipPstContainer = document.querySelector('.notip-pst-container');
        
        if (!noTipPstContainer) {
          // Cari atau buat wrapper untuk welcome-text dan no tip/pst
          let leftWrapper = welcomeSection.querySelector('.welcome-left-wrapper');
          
          if (!leftWrapper) {
            // Buat wrapper baru untuk welcome-text
            leftWrapper = document.createElement('div');
            leftWrapper.className = 'welcome-left-wrapper';
            leftWrapper.style.display = 'flex';
            leftWrapper.style.flexDirection = 'column';
            leftWrapper.style.alignItems = 'center';
            leftWrapper.style.gap = '20px';
            leftWrapper.style.paddingLeft = '40px';
            
            // Pindahkan welcome-text ke dalam wrapper
            const welcomeText = welcomeSection.querySelector('.welcome-text');
            if (welcomeText) {
              welcomeSection.insertBefore(leftWrapper, welcomeSection.firstChild);
              leftWrapper.appendChild(welcomeText);
            }
          }
          
          // Buat container untuk No Tip & PST
          noTipPstContainer = document.createElement('div');
          noTipPstContainer.className = 'notip-pst-container';
          noTipPstContainer.style.display = 'flex';
          noTipPstContainer.style.gap = '15px';
          noTipPstContainer.style.justifyContent = 'center';
          
          // Clone elemen No Tip & PST
          const noTipClone = noTip.cloneNode(true);
          const pstClone = pst.cloneNode(true);
          
          noTipClone.style.width = '100px';
          noTipClone.style.height = '100px';
          noTipClone.style.display = 'block';
          pstClone.style.width = '100px';
          pstClone.style.height = '100px';
          pstClone.style.display = 'block';
          
          noTipPstContainer.appendChild(noTipClone);
          noTipPstContainer.appendChild(pstClone);
          
          // Masukkan ke dalam leftWrapper (di bawah welcome-text)
          leftWrapper.appendChild(noTipPstContainer);
        }
      } else {
        // Hapus wrapper jika ada (kembali ke portrait)
        const leftWrapper = document.querySelector('.welcome-left-wrapper');
        if (leftWrapper) {
          const welcomeText = leftWrapper.querySelector('.welcome-text');
          const welcomeSection = document.querySelector('.welcome-section');
          if (welcomeText && welcomeSection) {
            welcomeSection.insertBefore(welcomeText, welcomeSection.firstChild);
          }
          leftWrapper.remove();
        }
      }
    }

    // Jalankan saat halaman load
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(moveNoTipPSTToWelcome, 100);
    });

    // Jalankan saat resize/orientasi berubah
    window.addEventListener('resize', function() {
      setTimeout(moveNoTipPSTToWelcome, 300);
    });
  </script>
</body>
</html>

