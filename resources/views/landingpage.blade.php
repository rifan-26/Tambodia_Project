<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BPS Sumatera Utara - Digital Signage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <style>
    /* Override Bootstrap defaults to preserve custom design */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
      background: #f5f5f5;
      color: #333;
      height: 100vh;
      overflow: hidden;
    }

    .container-left {
      position: relative;
      height: 100vh;
      width: 100vw;
      overflow: hidden;
      background: url('{{ asset('img/batikmerah.png') }}') center center;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      flex-direction: column;
    }

    /* Left Section Wrapper - default untuk portrait */
    .left-section-wrapper {
      position: relative;
      width: 100%;
    }

    /* Header Wrapper */
    .header-wrapper {
      position: relative;
      overflow: visible;
      z-index: 5;
    }

    /* Header Section with Blue Gradient */
    .header {
      position: relative;
      background: linear-gradient(to bottom, #092058 45%, #1345BE 100%);
      color: white;
      text-align: center;
      padding: 40px 20px;
      overflow: visible;
      z-index: 2;
    }

    /* Lengkungan bawah header - dihapus */
    .header::after {
      display: none;
    }

    .header > * {
      position: relative;
      z-index: 3;
    }

    /* Lengkungan emas - dihapus */
    .curve-gold {
      display: none;
    }

    .block-gold {
      position: absolute;
      bottom: -15px;
      left: 0;
      width: 100%;
      height: 15px;
      background: #FFC67C;
      z-index: 1;
    }

    /* Header content styling */
    .logos {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40px;
    }

    .logo {
      width: 70px;
      height: auto;
    }

    .title h1 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: bold;
    }

    .title p {
      margin: 4px 0 0;
      font-size: 1rem;
    }

    /* Welcome Section with Staff */
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
      z-index: 0;
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
      margin: 45px 20px 0 0;
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
      gap: 10px;
      justify-content: center;
      margin: 0 auto 5px auto;
    }

    .staff-photo {
      width: 130px;
      height: 160px;
      background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
      border-radius: 8px;
      margin-bottom: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: #666;
      overflow: hidden;
    }

    .staff-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .staff-info-kiri,
    .staff-info-kanan {
      display: inline-block;
      background: rgba(0, 0, 0, 0.3);
      padding: 5px 10px;
      font-size: 11px;
      font-weight: 500;
      width: 120px;
      vertical-align: middle;
      text-align: center;
    }

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

    .staff-name-kiri,
    .staff-name-kanan {
      margin-top: 5px;
      font-size: 16px;
      font-weight: 600;
      text-shadow: 2px 3px 1px rgba(0, 0, 0, 0.5);
      width: 120px;
      text-align: center;
    }

    .staff-name-wrapper {
      display: inline-flex;
      gap: 10px;
      justify-content: center;
      margin: 0 auto 5px auto;
    }

    /* Gallery Section */
    .gallery {
      flex: 1;
      padding: 20px 80px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: repeat(4, minmax(80px, 120px));
      gap: 15px;
      overflow: hidden;
      align-content: center;
      max-height: 100%;
      max-width: 80%;
      margin: 0 auto;
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

    .gallery-item {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
      cursor: pointer;
      position: relative;
    }

    .gallery-item:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    }

    /* Grid positioning for 6 items */
    .gallery-item:nth-child(1) {
      grid-column: 1 / 3;
      grid-row: 1 / 3;
    }

    .gallery-item:nth-child(2) {
      grid-column: 3 / 5;
      grid-row: 1 / 2;
    }

    .gallery-item:nth-child(3) {
      grid-column: 1 / 2;
      grid-row: 3 / 4;
    }

    .gallery-item:nth-child(4) {
      grid-column: 2 / 3;
      grid-row: 3 / 4;
    }

    .gallery-item:nth-child(5) {
      grid-column: 3 / 5;
      grid-row: 2 / 5;
    }

    .gallery-item:nth-child(6) {
      grid-column: 1 / 3;
      grid-row: 4 / 5;
    }

    .gallery-item img,
    .gallery-item video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .gallery-item iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    /* Gallery item with text overlay */
    .gallery-item-text {
      position: relative;
    }

    .gallery-item-text .text-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: white;
      padding: 15px;
      font-size: 11px;
      line-height: 1.4;
      color: #333;
    }

    .gallery-item-text .text-overlay h3 {
      font-size: 13px;
      font-weight: 700;
      margin: 0 0 8px 0;
      color: #1a2c5b;
    }

    .gallery-item-text .text-overlay p {
      margin: 0;
      font-size: 10px;
      line-height: 1.3;
    }

    .gallery-item-text .text-overlay .logo-bps {
      position: absolute;
      bottom: 10px;
      right: 15px;
      font-weight: 700;
      color: #1a2c5b;
      font-size: 10px;
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
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .layout-item video {
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .layout-item .youtube-video {
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      width: 100%;
      height: 100%;
      border: none;
    }

    /* ===== ASPECT RATIO CONTROL ===== */
    /* Ensure all media fills container properly */
    .layout-item img,
    .layout-item video,
    .layout-item .youtube-video {
      object-fit: cover;
      object-position: center;
    }

    /* Prevent media overflow */
    .layout-item * {
      max-width: 100%;
      max-height: 100%;
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
      display: none; /* Hide position numbers in production */
    }

    /* Empty slot styling */
    .layout-item.empty-slot {
      visibility: hidden;
      opacity: 0;
      pointer-events: none;
      background: transparent;
      border: none;
    }

    /* ===== SCROLLBAR STYLING ===== */
    .right-section::-webkit-scrollbar {
      width: 6px;
    }

    .right-section::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 3px;
    }

    .right-section::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 3px;
    }

    .right-section::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.3);
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 1400px) {
      .right-section {
        width: 32%;
        min-width: 320px;
      }
      
      .left-section {
        width: 63%;
        padding: 50px 60px;
      }
    }

    @media (max-width: 1200px) {
      .right-section {
        width: 35%;
        min-width: 300px;
        padding: 1.25rem 0.75rem;
      }
      
      .left-section {
        width: 60%;
        padding: 40px 50px;
      }
      
      .layout-grid {
        gap: 0.6rem;
      }
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
      }
      
      .left-section {
        position: relative;
        width: 100%;
        height: 50vh;
        padding: 30px 20px;
      }
      
      .right-section {
        position: relative;
        width: 100%;
        height: 50vh;
        max-width: none;
        min-width: auto;
        padding: 20px;
        border-left: none;
        border-top: 1px solid rgba(255,255,255,0.15);
      }
      
      .layout-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
      }
      
      .left-section h1 {
        font-size: 2rem;
      }
      
      .left-section p {
        font-size: 1rem;
      }
    }

    @media (max-width: 768px) {
      .layout-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: auto;
        gap: 0.5rem;
      }
      
      /* Optimize item positioning for portrait grid */
      .layout-item:nth-child(1) {
        grid-column: 1 !important;
        grid-row: 1 !important;
        aspect-ratio: 1/1 !important;
      }

      .layout-item:nth-child(2) {
        grid-column: 2 !important;
        grid-row: 1 !important;
        aspect-ratio: 1/1 !important;
      }

      .layout-item:nth-child(3) {
        grid-column: 1 !important;
        grid-row: 2 !important;
        aspect-ratio: 1/1 !important;
      }

      .layout-item:nth-child(4) {
        grid-column: 2 !important;
        grid-row: 2 !important;
        aspect-ratio: 1/1 !important;
      }

      .layout-item:nth-child(5) {
        grid-column: 1 !important;
        grid-row: 3 !important;
        aspect-ratio: 16/9 !important;
      }

      .layout-item:nth-child(6) {
        grid-column: 2 !important;
        grid-row: 3 !important;
        aspect-ratio: 16/9 !important;
      }
    }

    /* ===== LANDSCAPE RESPONSIVE DESIGN ===== */
    @media (orientation: landscape) and (max-height: 700px) {
      .container-left {
        display: flex;
        flex-direction: row;
      }

      .left-section-wrapper {
        flex: 0 0 40%;
        width: 40%;
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
      }

      .header-wrapper {
        flex: 0 0 auto;
        width: 100%;
        background: url('{{ asset('img/batikmerah.png') }}') center center;
        background-size: cover;
      }

      .header {
        padding: 20px 15px;
        flex: 0 0 auto;
      }

      .logo {
        width: 50px;
      }

      .title h1 {
        font-size: 1.3rem;
      }

      .title p {
        font-size: 0.85rem;
      }

      .welcome-section {
        padding: 15px 30px;
        height: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: url('{{ asset('img/batikbiru.png') }}') center center;
        background-size: cover;
      }

      .welcome-text h2 {
        font-size: 14px;
      }

      .staff-container {
        margin-top: 25px;
        flex-direction: column;
        gap: 15px;
      }

      .staff-photo {
        width: 65px;
        height: 85px;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 9px;
        padding: 4px 8px;
        width: 75px;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 13px;
      }

      .gallery {
        width: 60%;
        height: 100vh;
        padding: 30px 70px;
        gap: 20px;
        grid-template-rows: repeat(4, minmax(120px, 180px));
        background: url('{{ asset('img/batikmerah.png') }}') center center;
        background-size: cover;
      }

      .gallery::before {
        display: none;
      }

      .gallery-item-text .text-overlay {
        padding: 10px;
        font-size: 9px;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 11px;
        margin-bottom: 5px;
      }

      .gallery-item-text .text-overlay p {
        font-size: 8px;
      }

      .gallery-item-text .text-overlay .logo-bps {
        font-size: 8px;
        bottom: 8px;
      }
    }

    /* Extra compact for very small landscape screens */
    @media (orientation: landscape) and (max-height: 500px) {
      .container-left {
        display: flex;
        flex-direction: row;
      }

      .left-section-wrapper {
        flex: 0 0 10%;
        width: 10%;
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
      }

      .header-wrapper {
        flex: 0 0 auto;
        width: 100%;
        background: url('{{ asset('img/batikmerah.png') }}') center center;
        background-size: cover;
      }

      .header {
        padding: 15px 10px;
        flex: 0 0 auto;
      }

      .logo {
        width: 40px;
      }

      .logos {
        gap: 20px;
      }

      .title h1 {
        font-size: 1.1rem;
      }

      .title p {
        font-size: 0.75rem;
      }

      .welcome-section {
        padding: 10px 20px;
        height: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: url('{{ asset('img/batikbiru.png') }}') center center;
        background-size: cover;
      }

      .welcome-text h2 {
        font-size: 12px;
        margin: 0 0 0 10px;
      }

      .staff-container {
        margin-top: 15px;
        flex-direction: column;
        gap: 10px;
      }

      .staff-photo {
        width: 55px;
        height: 70px;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 8px;
        padding: 3px 6px;
        width: 65px;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 11px;
      }

      .gallery {
        width: 90%;
        height: 100vh;
        padding: 20px 60px;
        gap: 18px;
        grid-template-rows: repeat(4, minmax(90px, 130px));
        background: url('{{ asset('img/batikmerah.png') }}') center center;
        background-size: cover;
      }

      .gallery::before {
        display: none;
      }

      .gallery-item-text .text-overlay {
        padding: 8px;
        font-size: 7px;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 9px;
        margin-bottom: 4px;
      }

      .gallery-item-text .text-overlay p {
        font-size: 7px;
        line-height: 1.2;
      }

      .gallery-item-text .text-overlay .logo-bps {
        font-size: 7px;
        bottom: 6px;
      }
    }

    /* ===== PORTRAIT MODE RESPONSIVE - ALL DEVICES ===== */
    /* Base portrait mode - applies to all portrait orientations */
    @media (orientation: portrait) {
      body, html {
        overflow: auto;
        height: auto;
      }

      .container-left {
        height: auto;
        min-height: 100vh;
        overflow: visible;
        display: flex;
        flex-direction: column;
      }

      .left-section-wrapper {
        width: 100%;
        flex: 0 0 auto;
      }

      /* Gallery always full width in portrait */
      .gallery {
        width: 100%;
        height: auto;
        min-height: 50vh;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: auto;
      }

      /* Reset grid positioning for portrait - 2 column layout */
      .gallery-item:nth-child(1) {
        grid-column: 1 / 2 !important;
        grid-row: 1 / 2 !important;
        aspect-ratio: 1/1 !important;
      }

      .gallery-item:nth-child(2) {
        grid-column: 2 / 3 !important;
        grid-row: 1 / 2 !important;
        aspect-ratio: 1/1 !important;
      }

      .gallery-item:nth-child(3) {
        grid-column: 1 / 2 !important;
        grid-row: 2 / 3 !important;
        aspect-ratio: 1/1 !important;
      }

      .gallery-item:nth-child(4) {
        grid-column: 2 / 3 !important;
        grid-row: 2 / 3 !important;
        aspect-ratio: 1/1 !important;
      }

      .gallery-item:nth-child(5) {
        grid-column: 1 / 3 !important;
        grid-row: 3 / 4 !important;
        aspect-ratio: 16/9 !important;
      }

      .gallery-item:nth-child(6) {
        grid-column: 1 / 3 !important;
        grid-row: 4 / 5 !important;
        aspect-ratio: 16/9 !important;
      }

      /* Ensure media fits properly */
      .gallery-item img,
      .gallery-item video,
      .gallery-item iframe {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
      }

      .gallery-item {
        overflow: hidden;
        position: relative;
      }
    }

    /* Portrait - Large screens (TV, Large monitors) 1920px+ */
    @media (orientation: portrait) and (min-width: 1920px) {
      .header {
        padding: 8vh 4vw;
      }

      .logo {
        width: 10vw;
        max-width: 150px;
      }

      .logos {
        gap: 6vw;
      }

      .title h1 {
        font-size: 4vw;
      }

      .title p {
        font-size: 2vw;
      }

      .welcome-section {
        padding: 5vh 6vw;
        min-height: 25vh;
      }

      .welcome-text h2 {
        font-size: 2.5vw;
        margin-bottom: 3vh;
      }

      .staff-photo {
        width: 8vw;
        height: 10vh;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 1.5vw;
        padding: 1vh 2vw;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 2vw;
      }

      .gallery {
        padding: 4vh 4vw;
        gap: 2vw;
      }

      .gallery-item-text .text-overlay {
        padding: 2vh 2vw;
        font-size: 1.5vw;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 2vw;
        margin-bottom: 1vh;
      }

      .gallery-item-text .text-overlay p {
        font-size: 1.3vw;
      }
    }

    /* Portrait - Desktop/PC (1200px - 1919px) */
    @media (orientation: portrait) and (min-width: 1200px) and (max-width: 1919px) {
      .header {
        padding: 6vh 3vw;
      }

      .logo {
        width: 8vw;
        max-width: 120px;
      }

      .logos {
        gap: 5vw;
      }

      .title h1 {
        font-size: 3.5vw;
      }

      .title p {
        font-size: 1.8vw;
      }

      .welcome-section {
        padding: 4vh 5vw;
        min-height: 22vh;
      }

      .welcome-text h2 {
        font-size: 2.2vw;
        margin-bottom: 2.5vh;
      }

      .staff-photo {
        width: 7vw;
        height: 9vh;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 1.3vw;
        padding: 0.8vh 1.5vw;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 1.8vw;
      }

      .gallery {
        padding: 3vh 3vw;
        gap: 1.5vw;
      }

      .gallery-item-text .text-overlay {
        padding: 1.5vh 1.5vw;
        font-size: 1.3vw;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 1.8vw;
        margin-bottom: 0.8vh;
      }

      .gallery-item-text .text-overlay p {
        font-size: 1.1vw;
      }
    }

    /* Portrait - Tablet (768px - 1199px) */
    @media (orientation: portrait) and (min-width: 768px) and (max-width: 1199px) {
      .header {
        padding: 4vh 2.5vw;
      }

      .logo {
        width: 10vw;
        max-width: 90px;
      }

      .logos {
        gap: 4vw;
      }

      .title h1 {
        font-size: 4vw;
      }

      .title p {
        font-size: 2.2vw;
      }

      .welcome-section {
        padding: 3vh 4vw;
        min-height: 20vh;
      }

      .welcome-text h2 {
        font-size: 2.8vw;
        margin-bottom: 2vh;
      }

      .staff-container {
        flex-direction: row;
        justify-content: center;
        gap: 4vw;
        flex-wrap: wrap;
      }

      .staff-photo {
        width: 12vw;
        height: 8vh;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 1.8vw;
        padding: 0.6vh 2vw;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 2.5vw;
      }

      .gallery {
        padding: 2.5vh 2.5vw;
        gap: 2vw;
      }

      .gallery-item-text .text-overlay {
        padding: 1.2vh 1.5vw;
        font-size: 1.8vw;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 2.3vw;
        margin-bottom: 0.6vh;
      }

      .gallery-item-text .text-overlay p {
        font-size: 1.5vw;
      }
    }

    /* Portrait - Mobile (600px - 767px) */
    @media (orientation: portrait) and (min-width: 600px) and (max-width: 767px) {
      .header {
        padding: 3vh 3vw;
      }

      .logo {
        width: 12vw;
        max-width: 70px;
      }

      .logos {
        gap: 5vw;
      }

      .title h1 {
        font-size: 5vw;
      }

      .title p {
        font-size: 3vw;
      }

      .welcome-section {
        padding: 2.5vh 4vw;
        min-height: 18vh;
      }

      .welcome-text h2 {
        font-size: 3.5vw;
        margin-bottom: 1.5vh;
      }

      .staff-container {
        flex-direction: row;
        justify-content: center;
        gap: 5vw;
        flex-wrap: wrap;
      }

      .staff-photo {
        width: 15vw;
        height: 7vh;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 2.2vw;
        padding: 0.5vh 2.5vw;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 3vw;
      }

      .gallery {
        padding: 2vh 3vw;
        gap: 2.5vw;
      }

      .gallery-item-text .text-overlay {
        padding: 1vh 2vw;
        font-size: 2.2vw;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 2.8vw;
        margin-bottom: 0.5vh;
      }

      .gallery-item-text .text-overlay p {
        font-size: 1.8vw;
      }
    }

    /* Portrait - Small Mobile (< 600px) */
    @media (orientation: portrait) and (max-width: 599px) {
      .header {
        padding: 2.5vh 4vw;
      }

      .logo {
        width: 15vw;
        max-width: 60px;
      }

      .logos {
        gap: 6vw;
      }

      .title h1 {
        font-size: 6vw;
      }

      .title p {
        font-size: 3.5vw;
      }

      .welcome-section {
        padding: 2vh 5vw;
        min-height: 16vh;
      }

      .welcome-text h2 {
        font-size: 4vw;
        margin-bottom: 1.5vh;
      }

      .staff-container {
        flex-direction: row;
        justify-content: center;
        gap: 6vw;
        flex-wrap: wrap;
      }

      .staff-photo {
        width: 18vw;
        height: 6vh;
      }

      .staff-info-kiri,
      .staff-info-kanan {
        font-size: 2.8vw;
        padding: 0.4vh 3vw;
      }

      .staff-name-kiri,
      .staff-name-kanan {
        font-size: 3.5vw;
      }

      .gallery {
        padding: 1.5vh 4vw;
        gap: 3vw;
      }

      .gallery-item-text .text-overlay {
        padding: 0.8vh 2.5vw;
        font-size: 2.8vw;
      }

      .gallery-item-text .text-overlay h3 {
        font-size: 3.5vw;
        margin-bottom: 0.4vh;
      }

      .gallery-item-text .text-overlay p {
        font-size: 2.3vw;
      }
    }
  </style>
</head>
<body>
  <div class="container-left" role="main" aria-label="BPS Sumatera Utara Digital Signage">
    
    <!-- Left Section: Header + Welcome -->
    <div class="left-section-wrapper">
      <!-- Header -->
      <div class="header-wrapper">
      <div class="header">
        <div class="curve-gold"></div>  
        <div class="block-gold"></div> 
        <div class="logos d-flex align-items-center justify-content-center">
          <img src="{{ asset('logo-bps.png') }}" alt="Logo BPS" class="logo img-fluid">
          <div class="title text-center">
            <h1 class="mb-0">SELAMAT DATANG</h1>
            <p class="mb-0">Di Kantor BPS Provinsi Sumatera Utara</p>
          </div>
          <img src="{{ asset('logo-sumut.png') }}" alt="Logo Sumut" class="logo img-fluid">
        </div>
      </div> 
      </div>

      <!-- Welcome Section -->
      <div class="welcome-section">
      <div class="welcome-text">
        <h2>HARI INI ANDA AKAN<br>DI LAYANI OLEH :</h2>
      </div>
      
      <div class="staff-container" id="staffContainer">
        <!-- Staff Member -->
        <div class="staff-member">
          <div class="staff-photo-wrapper" id="staffPhotoWrapper">
            <!-- Staff photos will be loaded dynamically -->
          </div>
          <div class="staff-info-wrapper" id="staffInfoWrapper">
            <!-- Staff info labels will be loaded dynamically -->
          </div>
          <div class="staff-name-wrapper" id="staffNameWrapper">
            <!-- Staff names will be loaded dynamically -->
          </div>
        </div>
      </div>
      </div>
    </div>

    <!-- Gallery -->
    <div class="gallery">
      @if($media && $media->count() > 0)
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
            <div class="gallery-item @if($position == 6) gallery-item-text @endif" 
                 data-order="{{ $mediaItem->layout_order }}"
                 data-media-type="{{ $mediaItem->type }}"
                 data-media-path="{{ $mediaItem->file_path }}"
                 data-media-name="{{ $mediaItem->name }}"
                 data-youtube-id="{{ $videoId }}">
            @if($mediaItem->type === 'Gambar')
              <img src="{{ asset('storage/' . $mediaItem->file_path) }}" alt="{{ $mediaItem->name }}">
              @if($position == 6 && $mediaItem->description)
                <div class="text-overlay">
                  <h3>{{ $mediaItem->name }}</h3>
                  <p>{{ $mediaItem->description }}</p>
                  <span class="logo-bps">bps.go.id</span>
                </div>
              @endif
            @elseif($mediaItem->type === 'Video')
              @if($isYouTube && $videoId)
                <iframe 
                  src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
                  title="{{ $mediaItem->name }}"
                  frameborder="0" 
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                  allowfullscreen>
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
            <div class="gallery-item" data-order="{{ $position }}" style="visibility: hidden;"></div>
          @endif
        @endfor
      @else
        <!-- Default images when no media configured -->
        <div class="gallery-item">
          <img src="{{ asset('img/1.jpg') }}" alt="Kegiatan BPS">
        </div>
        
        <div class="gallery-item">
          <img src="{{ asset('img/2.jpg') }}" alt="Gedung BPS">
        </div>
        
        <div class="gallery-item">
          <img src="{{ asset('img/3.jpg') }}" alt="Kegiatan">
        </div>
        
        <div class="gallery-item">
          <img src="{{ asset('img/4.jpg') }}" alt="Meeting">
        </div>
        
        <div class="gallery-item">
          <img src="{{ asset('img/5.jpg') }}" alt="Gedung Kantor">
        </div>
        
        <div class="gallery-item gallery-item-text">
          <img src="{{ asset('img/6.jpg') }}" alt="Berita BPS">
          <div class="text-overlay">
            <h3>BPS MELAKUKAN SERAH TERIMA HIBAH DARI PEMERINTAH KABUPATEN BANGGAI LAUT</h3>
            <p>Kepala BPS RI, Amalia Adininggar Widyasanti, menerima hibah dari Pemerintah Kabupaten Banggai Laut, Sulawesi Tengah. Hibah diberikan dalam rangka Memperingati Hari Statistik Nasional dan Hari Ulang Tahun BPS RI yang Ke-77. Serah terima berlangsung di Kantor BPS RI, Jakarta, Kamis (26/9/2024).</p>
            <span class="logo-bps">bps.go.id</span>
          </div>
        </div>
      @endif
    </div>
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

  <!-- Bootstrap 5 JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  
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
      
      // Add click event to all gallery items
      document.querySelectorAll('.gallery-item').forEach(function(item) {
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
      
      // Load staff data
      loadStaffData();
    });

    // Load staff data from API
    async function loadStaffData() {
      try {
        const response = await fetch('/api/staff');
        const data = await response.json();
        
        if (data.success && data.staff && data.staff.length > 0) {
          renderStaffData(data.staff);
        } else {
          // Show default placeholders if no staff data
          renderDefaultStaff();
        }
      } catch (error) {
        console.error('Error loading staff data:', error);
        renderDefaultStaff();
      }
    }

    // Render staff data to the page
    function renderStaffData(staffList) {
      // Filter active staff and sort by position
      const activeStaff = staffList.filter(s => s.is_active).sort((a, b) => a.position - b.position);
      
      if (activeStaff.length === 0) {
        renderDefaultStaff();
        return;
      }
      
      const photoWrapper = document.getElementById('staffPhotoWrapper');
      const infoWrapper = document.getElementById('staffInfoWrapper');
      const nameWrapper = document.getElementById('staffNameWrapper');
      
      // Clear existing content
      photoWrapper.innerHTML = '';
      infoWrapper.innerHTML = '';
      nameWrapper.innerHTML = '';
      
      // Render up to 2 staff members (position 1 and 2)
      activeStaff.slice(0, 2).forEach(staff => {
        const photoUrl = staff.photo_path ? `/storage/${staff.photo_path}` : '/images/default-avatar.png';
        const positionClass = staff.position === 1 ? 'kiri' : 'kanan';
        
        // Add photo
        const photoDiv = document.createElement('div');
        photoDiv.className = 'staff-photo';
        photoDiv.style.backgroundImage = `url('${photoUrl}')`;
        photoDiv.style.backgroundSize = 'cover';
        photoDiv.style.backgroundPosition = 'center';
        photoWrapper.appendChild(photoDiv);
        
        // Add info label
        const infoDiv = document.createElement('div');
        infoDiv.className = `staff-info-${positionClass}`;
        infoDiv.textContent = 'PETUGAS';
        infoWrapper.appendChild(infoDiv);
        
        // Add name
        const nameDiv = document.createElement('div');
        nameDiv.className = `staff-name-${positionClass}`;
        nameDiv.textContent = staff.name;
        nameWrapper.appendChild(nameDiv);
      });
      
      // If only 1 staff, add placeholder for second position
      if (activeStaff.length === 1) {
        const photoDiv = document.createElement('div');
        photoDiv.className = 'staff-photo';
        photoDiv.textContent = 'FOTO';
        photoWrapper.appendChild(photoDiv);
        
        const infoDiv = document.createElement('div');
        infoDiv.className = 'staff-info-kanan';
        infoDiv.textContent = 'PETUGAS';
        infoWrapper.appendChild(infoDiv);
        
        const nameDiv = document.createElement('div');
        nameDiv.className = 'staff-name-kanan';
        nameDiv.textContent = 'Nama';
        nameWrapper.appendChild(nameDiv);
      }
    }

    // Render default staff placeholders
    function renderDefaultStaff() {
      const photoWrapper = document.getElementById('staffPhotoWrapper');
      const infoWrapper = document.getElementById('staffInfoWrapper');
      const nameWrapper = document.getElementById('staffNameWrapper');
      
      photoWrapper.innerHTML = `
        <div class="staff-photo">FOTO</div>
        <div class="staff-photo">FOTO</div>
      `;
      
      infoWrapper.innerHTML = `
        <div class="staff-info-kiri">PETUGAS</div>
        <div class="staff-info-kanan">PETUGAS</div>
      `;
      
      nameWrapper.innerHTML = `
        <div class="staff-name-kiri">Nama</div>
        <div class="staff-name-kanan">Nama</div>
      `;
    }

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

