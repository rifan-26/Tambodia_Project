<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Master Layout - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('components.sweetalert2')
  @include('components.global-audio-system')
  <style>
    :root {
      --primary: #1f9e76;
      --primary-light: #58cbaa;
      --text-dark: #2c3a67;
      --text-muted: #6c757d;
      --bg-light: #f8f9fa;
      --border-light: #e9ecef;
    }
    
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* Sidebar Styles */
    .sidebar {
      background: linear-gradient(180deg, #E7FFEA 0%, #ffffff 50%, #dcedff 100%);
      border-right: none;
      height: 100vh;
      width: 250px;
      display: flex;
      flex-direction: column;
      position: fixed !important;
      left: 0;
      top: 0;
      bottom: 0;
      z-index: 1000;
      overflow: hidden;
    }

    .sidebar-header {
      padding: 1.5rem 1.5rem 1rem;
      border-bottom: 1px solid #f1f3f4;
      flex-shrink: 0;
    }

    .sidebar-content {
      flex: 1;
      overflow-y: auto;
      padding: 1rem 0;
      height: calc(100vh - 120px);
      overflow-x: hidden;
    }

    .sidebar-header img {
      width: 50px;
      height: 50px;
    }

    .sidebar-title {
      font-weight: 600;
      font-size: 1.25rem;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .tam { color: #0084d6; }
    .bo { color: #a0d5d2; }
    .dia { color: #1f9e76; }

    .nav-link.active {
      background-color: var(--primary);
      color: white;
      font-weight: 500;
      border-radius: 0.375rem;
    }
    
    .nav-link {
      color: #4b596a;
      padding: 0.5rem 1rem;
      margin: 0.25rem 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1rem;
      border-radius: 0.375rem;
      transition: all 0.2s ease;
      text-decoration: none;
    }
    
    .nav-link:hover:not(.active) {
      background-color: #bcddc9;
      color: #1f9e76;
      cursor: pointer;
      transform: translateX(5px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.2);
    }

    .nav-link i {
      font-size: 1.1rem;
      width: 20px;
      text-align: center;
    }

    /* Content Area */
    .content-area {
      margin-left: 250px;
      padding: 2rem;
      min-height: 100vh;
      background-color: #f5f5f5;
    }
    
    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border-light);
    }
    
    .header-top h2 {
      margin: 0;
      font-weight: 600;
      font-size: 1.75rem;
      color: var(--text-dark);
    }
    
    .user-badge {
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
    }
    .user-badge .status-indicator {
      width: 16px;
      height: 16px;
      background-color: #44d69e;
      border-radius: 50%;
    }
    .grid-item {
      position: relative;
      width: 100%;
      background: #f8f9fa;
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      border: 2px solid #e9ecef;
      transition: all 0.2s ease;
    }
    
    .grid-item::before {
      content: '';
      display: block;
      padding-bottom: 100%;
    }
    
    .grid-item > * {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    
    .grid-item:hover {
      border-color: #667eea;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .grid-item.has-media {
      border-color: #10b981;
    }
    .card-header {
      background: linear-gradient(135deg, #f8fafb 0%, #ffffff 100%) !important;
      border-bottom: 1px solid rgba(0,0,0,0.06);
      color: var(--text-dark) !important;
      padding: 1.25rem 1.75rem;
    }
    
    .card-header h5 {
      color: var(--text-dark) !important;
      font-weight: 700;
      margin: 0;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .card-header h5 i {
      color: var(--primary);
      font-size: 1.3rem;
    }
    
    .card-body {
      padding: 1.75rem;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #1f9e76, #58cbaa);
      color: white;
      border: none;
      transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.3);
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
      border: none;
      transition: all 0.2s ease;
    }
    
    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    
    .btn-success {
      background: linear-gradient(135deg, #1f9e76, #58cbaa);
      color: white;
      border: none;
      transition: all 0.2s ease;
    }
    
    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.3);
    }
    
    .btn-secondary {
      background: #6c757d;
      color: white;
      border: none;
      transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
      background: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    
    /* Background Selection Area */
    .background-selector {
      border: 2px dashed #e2e8f0;
      border-radius: 16px;
      padding: 3.5rem 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(135deg, #f8fafb 0%, #ffffff 50%, #f0fdf4 100%);
      min-height: 300px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    
    .background-selector::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(31, 158, 118, 0.03) 0%, transparent 70%);
      transition: all 0.6s ease;
      opacity: 0;
    }
    
    .background-selector:hover::before {
      opacity: 1;
      transform: scale(1.1);
    }
    
    .background-selector:hover {
      border-color: var(--primary);
      background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 50%, #dcfce7 100%);
      box-shadow: 0 8px 25px rgba(31, 158, 118, 0.12);
      transform: translateY(-4px);
    }
    
    .background-selector i {
      transition: all 0.4s ease;
    }
    
    .background-selector.has-image {
      padding: 0 !important;
      border-style: solid !important;
      border-color: var(--primary) !important;
      position: relative !important;
    }
    
    .background-selector.has-image::before {
      display: none !important;
    }
    
    .background-selector img,
    .background-selector video,
    .background-selector iframe {
      width: 100% !important;
      height: 300px !important;
      object-fit: cover !important;
      border-radius: 14px !important;
      display: block !important;
    }
    
    .remove-bg {
      position: absolute !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%) !important;
      background: rgba(220, 38, 38, 0.95) !important;
      color: white !important;
      border: 3px solid white !important;
      border-radius: 50% !important;
      width: 50px !important;
      height: 50px !important;
      font-size: 1.5rem !important;
      cursor: pointer !important;
      z-index: 100 !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4) !important;
      transition: all 0.3s ease !important;
      opacity: 0 !important;
    }
    
    .background-selector:hover .remove-bg {
      opacity: 1 !important;
    }
    
    .background-selector .remove-bg:hover {
      background: rgba(185, 28, 28, 1) !important;
      transform: translate(-50%, -50%) scale(1.2) rotate(90deg) !important;
      box-shadow: 0 6px 20px rgba(220, 38, 38, 0.6) !important;
    }
    
    .background-selector .remove-bg:active {
      transform: translate(-50%, -50%) scale(1.1) rotate(90deg) !important;
      box-shadow: 0 3px 10px rgba(220, 38, 38, 0.5) !important;
    }
    
    /* Grid Layout - SAMA dengan Landing Page (6 posisi) */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      grid-template-rows: repeat(2, 1fr);
      gap: 0.75rem;
      max-width: 900px;
      height: 400px;
      margin: 0 auto;
    }
    
    .grid-item {
      position: relative;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100px;
    }

    /* Position 1: Kebijakan - Kiri, Panjang ke Bawah (2 rows) */
    .grid-item[data-position="1"] {
      grid-column: 1 / 4 !important;
      grid-row: 1 / 3 !important;
    }

    /* Position 2: Sosialisasi - Kanan Atas Landscape Besar */
    .grid-item[data-position="2"] {
      grid-column: 4 / 13 !important;
      grid-row: 1 / 2 !important;
    }

    /* Position 3: Gratifikasi - Kanan Bawah Kiri */
    .grid-item[data-position="3"] {
      grid-column: 4 / 8 !important;
      grid-row: 2 / 3 !important;
    }

    /* Position 4: Release - Kanan Bawah Kanan */
    .grid-item[data-position="4"] {
      grid-column: 8 / 13 !important;
      grid-row: 2 / 3 !important;
    }
    
    .grid-item::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, transparent 0%, rgba(31, 158, 118, 0.05) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .grid-item:hover::after {
      opacity: 1;
    }
    
    .grid-item:hover {
      border-color: var(--primary);
      box-shadow: 0 8px 25px rgba(31, 158, 118, 0.15);
      transform: translateY(-4px) scale(1.02);
    }
    
    .grid-item.has-media {
      border-color: var(--primary);
      background: white;
      box-shadow: 0 4px 15px rgba(31, 158, 118, 0.1);
    }
    
    .grid-item.has-media::after {
      display: none;
    }
    
    .grid-item img,
    .grid-item video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
    
    .grid-item:hover img,
    .grid-item:hover video {
      transform: scale(1.05);
    }
    
    .remove-item {
      position: absolute !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%) !important;
      background: rgba(220, 38, 38, 0.95) !important;
      color: white !important;
      border: 3px solid white !important;
      border-radius: 50% !important;
      width: 50px !important;
      height: 50px !important;
      cursor: pointer !important;
      z-index: 100 !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 1.5rem !important;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4) !important;
      transition: all 0.3s ease !important;
      opacity: 0 !important;
    }
    
    .grid-item:hover .remove-item {
      opacity: 1 !important;
    }

    .remove-item:hover {
      background: rgba(185, 28, 28, 1) !important;
      transform: translate(-50%, -50%) scale(1.2) rotate(90deg) !important;
      box-shadow: 0 6px 20px rgba(220, 38, 38, 0.6) !important;
    }
    
    .remove-item:active {
      transform: translate(-50%, -50%) scale(1.1) rotate(90deg) !important;
      box-shadow: 0 3px 10px rgba(220, 38, 38, 0.5) !important;
    }

    .remove-item i {
      font-size: 1.5rem !important;
      pointer-events: none !important;
    }
    
    .position-badge {
      position: absolute !important;
      top: 10px !important;
      left: 10px !important;
      background: rgba(0, 0, 0, 0.7) !important;
      color: white !important;
      width: 32px !important;
      height: 32px !important;
      border-radius: 50% !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-weight: 700 !important;
      font-size: 1rem !important;
      z-index: 5 !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
    }
    
    /* Always show delete button on mobile/touch devices */
    @media (hover: none) {
      .grid-item .remove-item {
        display: flex !important;
      }
    }
    
    .placeholder {
      position: absolute !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 1rem !important;
      padding: 2rem !important;
      z-index: 1 !important;
      text-align: center !important;
      color: #a0aec0 !important;
    }
    
    .placeholder i {
      font-size: 2.5rem !important;
      opacity: 0.5 !important;
    }
    
    .placeholder p {
      margin: 0 !important;
      font-size: 0.9rem !important;
      font-weight: 500 !important;
    }
    
    .preview-section {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafb 100%);
      border: none;
      border-radius: 16px;
      padding: 2.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 10px 40px rgba(0,0,0,0.03);
      position: relative;
      overflow: hidden;
    }
    
    .preview-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
    }
    
    .preview-title {
      font-size: 1.75rem;
      font-weight: 800;
      margin-bottom: 0.75rem;
      background: linear-gradient(135deg, #2c3a67 0%, #1f9e76 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .preview-title .bps {
      color: #0066cc;
    }
    
    .preview-subtitle {
      font-size: 1.35rem;
      color: #4b5563;
      margin-bottom: 1.5rem;
      font-weight: 600;
    }
    
    .description-label {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.25rem;
      padding-bottom: 0.75rem;
      border-bottom: 2px solid #e5e7eb;
    }
    
    .description-label i {
      color: var(--primary);
      font-size: 1.2rem;
    }
    
    .description-label strong {
      font-weight: 700;
      color: var(--text-dark);
      font-size: 1.05rem;
    }
    
    .description-content {
      line-height: 1.9;
      color: #6b7280;
      font-size: 0.95rem;
      padding: 1rem;
      background: white;
      border-radius: 12px;
      border-left: 4px solid var(--primary);
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    /* Success notification */
    .success-notification {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      padding: 1rem 1.75rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      display: none;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.25);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
    }
    
    .success-notification::before {
      content: '✓';
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      background: rgba(255,255,255,0.25);
      border-radius: 8px;
      margin-right: 0.75rem;
      font-weight: bold;
      font-size: 1.1rem;
    }
    
    .success-notification.show {
      display: flex;
      animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes slideDown {
      0% {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
      }
      50% {
        transform: translateY(5px) scale(1.02);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    
    .success-notification .close-btn {
      background: rgba(255,255,255,0.2);
      border: none;
      color: white;
      width: 28px;
      height: 28px;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      margin-left: 1rem;
      font-size: 1.2rem;
    }
    
    .success-notification .close-btn:hover {
      background: rgba(255,255,255,0.3);
      transform: rotate(90deg);
    }

    /* Loading Overlay */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 23, 42, 0.75);
      backdrop-filter: blur(8px);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    .loading-overlay.show {
      display: flex;
    }
    
    .loading-overlay .spinner-border {
      width: 4rem;
      height: 4rem;
      border-width: 4px;
    }
    
    /* Modal Improvements */
    .modal-content {
      border: none;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    
    .modal-header {
      padding: 1.5rem 1.75rem;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .modal-body {
      padding: 1.75rem;
    }
    
    .modal-footer {
      padding: 1.25rem 1.75rem;
      border-top: 1px solid #e5e7eb;
      background: #f9fafb;
    }
    
    /* Form Controls */
    .form-control {
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      padding: 0.65rem 1rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(31, 158, 118, 0.1);
      outline: none;
    }
    
    textarea.form-control {
      resize: vertical;
      min-height: 120px;
    }
    
    .form-text {
      color: #9ca3af;
      font-size: 0.85rem;
      margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      
      .sidebar-title,
      .nav-link span {
        display: none;
      }
      
      .content-area {
        margin-left: 70px;
        padding: 1rem;
      }
      
      .nav-link {
        justify-content: center;
        padding: 0.75rem 0.5rem;
        margin: 0 0.25rem;
      }
      
      .grid-container {
        grid-template-columns: 1fr;
      }
    }

    /* Custom Confirm Modal Styling */
    #confirmModal .modal-dialog {
      animation: modalSlideDown 0.3s ease-out;
    }
    
    @keyframes modalSlideDown {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    
    #confirmModal .btn-danger {
      background: linear-gradient(135deg, #dc3545, #c82333) !important;
      border: none !important;
      transition: all 0.2s ease;
    }
    
    #confirmModal .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3) !important;
    }
    
    #confirmModal .btn-secondary {
      background: #6c757d !important;
      color: white !important;
      border: none !important;
      transition: all 0.2s ease;
    }
    
    #confirmModal .btn-secondary:hover {
      background: #5a6268 !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3) !important;
    }

    /* Entrance Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes scaleIn {
      from {
        opacity: 0;
        transform: scale(0.9);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* Apply animations to elements */
    .sidebar {
      animation: slideInLeft 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .header-top {
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s both;
    }

    .card {
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    }

    .card:nth-child(2) {
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
    }

    .preview-section {
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
    }

    .grid-item {
      animation: scaleIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) both;
    }

    .grid-item:nth-child(1) { animation-delay: 0.1s; }
    .grid-item:nth-child(2) { animation-delay: 0.15s; }
    .grid-item:nth-child(3) { animation-delay: 0.2s; }
    .grid-item:nth-child(4) { animation-delay: 0.25s; }
    .grid-item:nth-child(5) { animation-delay: 0.3s; }
    .grid-item:nth-child(6) { animation-delay: 0.35s; }

    .user-badge {
      animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    }

    /* Smooth page load */
    body {
      animation: fadeIn 0.3s ease-in;
    }
    

  </style>
</head>
<body>
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="sidebar-header d-flex align-items-center gap-2">
      <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" />
      <h1 class="sidebar-title">
        <span class="title-text">
          <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
        </span>
      </h1>
    </div>
    
    <div class="sidebar-content">
      <ul class="nav flex-column px-1">
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('dashboard.pegawai') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('media.input') }}">
            <i class="bi bi-pencil-square"></i> Input Media
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar3"></i> Penjadwalan
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ route('layout') }}">
            <i class="bi bi-grid-3x3"></i> Master Layout
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ route('staff.index') }}">
            <i class="bi bi-people"></i> Master Profil
          </a>
        </li>
        <li class="nav-item mt-auto">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">
            @csrf
          </form>
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Log Out
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content Area -->
  <main class="content-area">
    <!-- Header -->
    <div class="header-top">
      <h2>Master Layout</h2>
      <div class="user-badge" title="Logged in">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name ?? 'User' }}</span>
      </div>
    </div>
    
    <!-- Gallery Content -->
    <div class="row">
      <!-- Grid Layout -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5>
              <i class="fas fa-th me-2"></i>Layout Grid (6 Posisi)
            </h5>
          </div>
          <div class="card-body">
            <!-- Error/Info Banner -->
            <div id="errorBanner" class="alert alert-danger d-none mb-3" role="alert">
              <h6 class="alert-heading">❌ Error Saat Menyimpan!</h6>
              <p class="mb-2" id="errorMessage"></p>
              <hr>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-danger" onclick="location.reload()">
                  <i class="bi bi-arrow-clockwise"></i> Refresh Halaman
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="$('#errorBanner').addClass('d-none')">
                  <i class="bi bi-x"></i> Tutup
                </button>
              </div>
            </div>
            
            <div class="grid-container" id="gridContainer">
              <!-- Grid items will be generated dynamically -->
            </div>
            <div class="d-flex gap-2 mt-3">
              <button class="btn btn-outline-danger" onclick="clearAllGridMedia()" style="flex: 0 0 auto;">
                <i class="bi bi-trash me-2"></i>Hapus Semua Grid
              </button>
              <button class="btn btn-success w-100" onclick="saveLayout()">
                <i class="fas fa-save me-2"></i>Simpan Layout
              </button>
            </div>
            <div class="mt-2">
              <small class="text-success fw-bold">
                <i class="bi bi-check-circle-fill me-1"></i> 
                Auto-Save: Hapus media otomatis update landing page
              </small>
              <br>
              <small class="text-muted mt-1 d-block">
                <i class="bi bi-info-circle me-1"></i> 
                Media hanya dihapus dari layout, file tetap tersimpan dan bisa ditambahkan lagi
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div>
      <!-- End Gallery Content -->
    </div>
  </main>

<!-- Custom Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
      <div class="modal-header" style="border-bottom: 1px solid #e9ecef; padding: 20px 25px;">
        <h5 class="modal-title" id="confirmModalTitle" style="font-weight: 600; color: #dc3545;">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          Konfirmasi Hapus
        </h5>
      </div>
      <div class="modal-body" style="padding: 25px;">
        <div id="confirmModalMessage" style="font-size: 1rem; color: #495057; margin-bottom: 20px;">
          <!-- Message will be inserted here -->
        </div>
        <div id="confirmModalDetails" style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
          <!-- Details will be inserted here -->
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 15px 25px; gap: 10px;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 25px; border-radius: 8px;">
          <i class="bi bi-x-circle me-1"></i> Batal
        </button>
        <button type="button" class="btn btn-danger" id="confirmModalYes" style="padding: 10px 30px; border-radius: 8px;">
          <i class="bi bi-trash me-1"></i> Ya, Hapus!
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Media Selection Modal (Background) -->
<div class="modal fade" id="backgroundModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: var(--bg-light); border-bottom: 1px solid var(--border-light);">
        <h5 class="modal-title" style="color: var(--text-dark); font-weight: 600;">
          <i class="fas fa-image me-2 text-primary"></i>Pilih Media untuk Background
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3" id="backgroundMediaList">
          <!-- Media items will be loaded here -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Media Selection Modal (Grid Position) -->
<div class="modal fade" id="gridMediaModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: var(--bg-light); border-bottom: 1px solid var(--border-light);">
        <h5 class="modal-title" style="color: var(--text-dark); font-weight: 600;">
          <i class="fas fa-th me-2 text-primary"></i>Pilih Media untuk Posisi <span id="currentPosition"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3" id="gridMediaList">
          <!-- Media items will be loaded here -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Description Edit Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: var(--bg-light); border-bottom: 1px solid var(--border-light);">
        <h5 class="modal-title" style="color: var(--text-dark); font-weight: 600;">
          <i class="fas fa-edit me-2 text-primary"></i>Edit Deskripsi Landing Page
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" id="descriptionTextarea" rows="10" maxlength="1000" 
                  placeholder="Masukkan deskripsi untuk landing page..."></textarea>
        <div class="form-text mt-2">
          <span id="modalCharCount">0</span>/1000 karakter
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="saveDescription()">
          <i class="fas fa-save me-2"></i>Simpan Deskripsi
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="text-center">
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-white mt-3">Memproses...</div>
    </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Global variables
let allMedia = [];
let layoutData = {
  background: null,
  description: '',
  gridItems: {}
};
let currentGridPosition = null;

$(document).ready(function() {
    // Initialize
    initializeGrid();
    
    // Load media first, then load layout settings after media is loaded
    loadMedia().then(() => {
        loadLayoutSettings();
    });
    
    // Description textarea character counter
    $('#descriptionTextarea').on('input', function() {
        $('#modalCharCount').text($(this).val().length);
    });
});

// Initialize grid with 4 positions (mengikuti landing page)
function initializeGrid() {
    const gridContainer = $('#gridContainer');
    const positionLabels = {
        1: 'Kebijakan (Kiri)',
        2: 'Sosialisasi (Kanan Atas)',
        3: 'Gratifikasi (Kanan Bawah Kiri)',
        4: 'Release (Kanan Bawah Kanan)'
    };
    
    for (let i = 1; i <= 4; i++) {
        const gridItem = $(`
            <div class="grid-item" data-position="${i}" onclick="openGridMediaModal(${i})">
                <div class="position-badge">${i}</div>
                <div class="placeholder">
                    <i class="fas fa-plus-circle"></i>
                    <p>${positionLabels[i]}</p>
                    <small style="font-size: 0.75rem; color: #9ca3af;">Klik untuk pilih media</small>
                </div>
            </div>
        `);
        gridContainer.append(gridItem);
    }
}

// Load all media
function loadMedia() {
    console.log('Starting to load media from API...');
    return $.ajax({
        url: '/api/media/search',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done(function(response) {
        console.log('API Response received:', response);
        
        let mediaData = [];
        
        // Handle different response formats
        if (Array.isArray(response)) {
            // Direct array
            mediaData = response;
            console.log('Format: Direct array');
        } else if (response.data && Array.isArray(response.data)) {
            // Object with 'data' property
            mediaData = response.data;
            console.log('Format: Object with data property');
        } else if (response.media && Array.isArray(response.media)) {
            // Object with 'media' property
            mediaData = response.media;
            console.log('Format: Object with media property');
        } else {
            console.error('Unknown response format:', response);
            alert('Format response API tidak dikenali. Cek console.');
            return;
        }
        
        // Filter only Gambar and Video
        allMedia = mediaData.filter(m => m.type === 'Gambar' || m.type === 'Video');
        console.log('Media loaded and filtered:', allMedia.length, 'items');
        console.log('Sample media:', allMedia.slice(0, 3));
        
        if (allMedia.length === 0) {
            console.warn('No Gambar/Video media found in database');
        }
    })
    .fail(function(xhr, status, error) {
        console.error('Failed to load media:', error);
        console.error('Status:', status);
        console.error('Response:', xhr.responseText);
        alert('Gagal memuat media dari server. Cek console untuk detail error.');
    });
}

// Load current layout settings
function loadLayoutSettings() {
    console.log('📥 Loading layout settings from database...');
    $.get('/layout/settings')
        .done(function(response) {
            console.log('📦 Layout settings response:', response);
            
            if (response.success) {
                // Load background
                if (response.background_media) {
                    const bgMedia = allMedia.find(m => m.id == response.background_media.id);
                    if (bgMedia) {
                        setBackground(bgMedia);
                        console.log('🖼️ Background loaded from DB:', bgMedia.name, '(ID:', bgMedia.id, ')');
                    }
                } else {
                    console.log('📭 No background in database');
                }
                
                // Load description
                if (response.description) {
                    layoutData.description = response.description;
                    updateDescriptionPreview();
                    console.log('📝 Description loaded');
                }
                
                // Load grid media from default_media - 1:1 mapping
                // Landing Page Position = Manager Position (SAMA)
                const reverseMapping = {
                    1: 1,  // Kebijakan
                    2: 2,  // Sosialisasi
                    3: 3,  // Gratifikasi
                    4: 4   // Release
                };
                
                if (response.default_media && response.default_media.length > 0) {
                    console.log('📊 Loading', response.default_media.length, 'media from database:');
                    response.default_media.forEach((mediaData) => {
                        const landingPagePos = mediaData.layout_order;
                        const managerPos = reverseMapping[landingPagePos];
                        
                        if (managerPos) {
                            // Find full media object from allMedia
                            const fullMedia = allMedia.find(m => m.id == mediaData.id);
                            if (fullMedia) {
                                setGridMedia(managerPos, fullMedia);
                                console.log(`  ✅ Landing Position ${landingPagePos} → Manager Position ${managerPos}: ${fullMedia.name} (${fullMedia.type})`);
                            } else {
                                console.warn(`  ⚠️ Position ${landingPagePos}: Media ID ${mediaData.id} not found in allMedia`);
                            }
                        } else {
                            console.log(`  ⏭️ Skipping landing page position ${landingPagePos} (not mapped to manager)`);
                        }
                    });
                    console.log('✅ All grid media loaded from database (4 positions mapped)');
                } else {
                    console.log('📭 No grid media in database - starting with empty grid');
                }
            }
        })
        .fail(function(xhr, status, error) {
            console.error('❌ Failed to load layout settings:', error);
            console.error('Response:', xhr.responseText);
        });
}

// Open background selection modal
function openBackgroundModal() {
    console.log('Opening background modal');
    console.log('Available media:', allMedia.length, allMedia);
    
    const mediaList = $('#backgroundMediaList');
    mediaList.empty();
    
    if (allMedia.length === 0) {
        mediaList.html(`
            <div class="col-12 text-center p-4">
                <p class="text-muted">Tidak ada media tersedia.</p>
                <p class="small">Silakan upload media terlebih dahulu di menu "Input Media"</p>
            </div>
        `);
        console.warn('No media available for background');
    } else {
        console.log('Adding', allMedia.length, 'media cards to background modal');
        allMedia.forEach((media, index) => {
            console.log(`Creating background card ${index + 1}:`, media.name);
            const mediaCard = createMediaCard(media, 'selectBackground');
            mediaList.append(mediaCard);
        });
    }
    
    new bootstrap.Modal($('#backgroundModal')).show();
}

// Open grid media selection modal
function openGridMediaModal(position) {
    console.log('Opening grid media modal for position:', position);
    console.log('Available media:', allMedia.length, allMedia);
    
    currentGridPosition = position;
    $('#currentPosition').text(position);
    
    const mediaList = $('#gridMediaList');
    mediaList.empty();
    
    if (allMedia.length === 0) {
        mediaList.html(`
            <div class="col-12 text-center p-4">
                <p class="text-muted">Tidak ada media tersedia.</p>
                <p class="small">Silakan upload media terlebih dahulu di menu "Input Media"</p>
            </div>
        `);
        console.warn('No media available to display');
    } else {
        console.log('Adding', allMedia.length, 'media cards to modal');
        allMedia.forEach((media, index) => {
            console.log(`Creating card ${index + 1}:`, media.name);
            const mediaCard = createMediaCard(media, 'selectGridMedia');
            mediaList.append(mediaCard);
        });
    }
    
    new bootstrap.Modal($('#gridMediaModal')).show();
}

// Open description edit modal
function openDescriptionModal() {
    $('#descriptionTextarea').val(layoutData.description);
    $('#modalCharCount').text(layoutData.description.length);
    new bootstrap.Modal($('#descriptionModal')).show();
}

// Create media card for selection
function createMediaCard(media, callback) {
    const isVideo = media.type === 'Video';
    const isYouTube = media.file_path && (media.file_path.includes('youtube.com') || media.file_path.includes('youtu.be'));
    
    let mediaElement;
    
    if (isYouTube) {
        // YouTube video - show thumbnail
        mediaElement = `
            <div style="width:100%; height:150px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                <i class="bi bi-youtube" style="font-size:3rem; color:#ff0000;"></i>
            </div>
        `;
    } else if (isVideo) {
        // Local video file
        const videoPath = `/storage/${media.file_path}`;
        mediaElement = `
            <video style="width:100%; height:150px; object-fit:cover; background:#000;" muted>
                <source src="${videoPath}" type="video/mp4">
                <div style="display:flex; align-items:center; justify-content:center; height:100%; background:#333;">
                    <i class="bi bi-play-circle" style="font-size:3rem; color:#fff;"></i>
                </div>
            </video>
        `;
    } else {
        // Image file
        const imagePath = `/storage/${media.file_path}`;
        
        mediaElement = `
            <div class="img-preview-container" style="width:100%; height:150px; background:#f8f9fa; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative;">
                <img src="${imagePath}" 
                     class="img-preview"
                     style="max-width:100%; max-height:150px; object-fit:contain;" 
                     alt="${media.name}"
                     onload="this.style.opacity='1'"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="img-fallback" style="display:none; flex-direction:column; align-items:center; gap:10px; position:absolute;">
                    <i class="bi bi-image" style="font-size:3rem; color:#ccc;"></i>
                    <small style="color:#999; text-align:center;">Preview tidak tersedia</small>
                </div>
            </div>
        `;
    }
    
    console.log('Creating card for:', media.name, 'Type:', media.type, 'Path:', `/storage/${media.file_path}`);
    
    // Create card element
    const card = $(`
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm media-select-card" data-media-id="${media.id}" style="cursor:pointer; transition: transform 0.2s;">
                <div class="card-body p-2">
                    ${mediaElement}
                    <p class="mb-0 mt-2 small text-truncate fw-bold" title="${media.name}">${media.name}</p>
                    <small class="text-muted"><i class="bi bi-${media.type === 'Video' ? 'play-circle' : 'image'}"></i> ${media.type}</small>
                </div>
            </div>
        </div>
    `);
    
    // Attach click handler using jQuery
    card.find('.media-select-card').on('click', function() {
        console.log('Card clicked, media ID:', media.id, 'callback:', callback);
        window[callback](media.id);
    });
    
    // Hover effects
    card.find('.media-select-card')
        .on('mouseenter', function() { $(this).css('transform', 'translateY(-5px)'); })
        .on('mouseleave', function() { $(this).css('transform', 'translateY(0)'); });
    
    return card;
}

// Select background media
function selectBackground(mediaId) {
    console.log('selectBackground called with mediaId:', mediaId);
    console.log('Available media count:', allMedia.length);
    
    const media = allMedia.find(m => m.id == mediaId);
    console.log('Found media:', media);
    
    if (media) {
        console.log('Setting background to:', media.name);
        setBackground(media);
        
        // Close modal
        const modalInstance = bootstrap.Modal.getInstance($('#backgroundModal'));
        if (modalInstance) {
            modalInstance.hide();
        }
        console.log('Background modal closed');
    } else {
        console.error('Media not found for ID:', mediaId);
    }
}

// Select grid media
function selectGridMedia(mediaId) {
    console.log('selectGridMedia called with mediaId:', mediaId, 'position:', currentGridPosition);
    
    const media = allMedia.find(m => m.id == mediaId);
    console.log('Found media:', media);
    
    if (media && currentGridPosition) {
        console.log('Setting grid media at position', currentGridPosition, 'to:', media.name);
        setGridMedia(currentGridPosition, media);
        
        // Close modal
        const modalInstance = bootstrap.Modal.getInstance($('#gridMediaModal'));
        if (modalInstance) {
            modalInstance.hide();
        }
        console.log('Grid media modal closed');
    } else {
        if (!media) {
            console.error('Media not found for ID:', mediaId);
        }
        if (!currentGridPosition) {
            console.error('No grid position set');
        }
    }
}

// Set background
function setBackground(media) {
    console.log('🎨 setBackground called for media:', media);
    console.log('📝 Media type:', media.type);
    console.log('📂 File path:', media.file_path);
    
    layoutData.background = media;
    const selector = $('#backgroundSelector');
    
    const isVideo = media.type === 'Video';
    const isYouTube = media.file_path && (media.file_path.includes('youtube.com') || media.file_path.includes('youtu.be'));
    
    console.log('🎬 Is Video?', isVideo);
    console.log('📺 Is YouTube?', isYouTube);
    
    let mediaElement;
    
    if (isYouTube) {
        console.log('✅ Using YouTube embed');
        // YouTube video - convert to embed
        let embedUrl = media.file_path;
        if (embedUrl.includes('youtu.be/')) {
            const videoId = embedUrl.split('youtu.be/')[1].split('?')[0];
            embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}`;
        } else if (embedUrl.includes('watch?v=')) {
            const videoId = embedUrl.split('watch?v=')[1].split('&')[0];
            embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}`;
        }
        mediaElement = `<iframe src="${embedUrl}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
    } else if (isVideo) {
        console.log('✅ Using Video tag');
        mediaElement = `<video src="/storage/${media.file_path}" autoplay muted loop></video>`;
    } else {
        console.log('✅ Using IMG tag for image');
        const imgPath = `/storage/${media.file_path}`;
        console.log('🖼️ Image path:', imgPath);
        mediaElement = `<img src="${imgPath}" alt="${media.name}" style="width: 100%; height: 300px; object-fit: cover; border-radius: 14px;">`;
    }
    
    console.log('📝 Generated mediaElement:', mediaElement);
    
    selector.html(`
        ${mediaElement}
        <button class="remove-bg" onclick="removeBackground(event)">
            <i class="fas fa-times"></i>
        </button>
    `).addClass('has-image');
    selector.attr('onclick', '');
    
    console.log('✅ Background set successfully');
    console.log('🔍 Selector HTML:', selector.html());
}

// Remove background
function removeBackground(event) {
    event.stopPropagation();
    
    const bgName = layoutData.background ? layoutData.background.name : 'Background';
    
    showConfirmModal(
        'Hapus Background',
        `Apakah Anda yakin ingin menghapus <strong>"${bgName}"</strong> dari background?`,
        [
            'Background hilang dari Landing Page',
            'File tetap tersimpan dan bisa ditambahkan lagi',
            'Perubahan akan langsung disimpan'
        ],
        function() {
            // Callback when user clicks "Ya, Hapus"
            executeRemoveBackground(bgName);
        }
    );
}

// Execute remove background (separated for modal callback)
function executeRemoveBackground(bgName) {
    console.log('🗑️ Removing background:', bgName);
    
    const removedBg = layoutData.background;
    layoutData.background = null;
    
    const selector = $('#backgroundSelector');
    selector.html(`
        <i class="fas fa-cloud-upload-alt fa-4x text-primary mb-3"></i>
        <p class="text-dark fw-bold mb-1">Klik area lalu pilih media yang ingin ditampilkan</p>
        <p class="text-muted small">Untuk menambahkan gambar background</p>
    `).removeClass('has-image');
    selector.attr('onclick', 'openBackgroundModal()');
    
    console.log('✅ Background removed from layout (file still exists)');
    
    // AUTO-SAVE: Update landing page immediately
    console.log('💾 Auto-saving background removal...');
    
    $('#loadingOverlay').addClass('show');
    
    $.ajax({
        url: '/layout/background',
        method: 'POST',
        data: { media_id: null },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(response) {
        $('#loadingOverlay').removeClass('show');
        console.log('✅ Background removal saved:', response);
        showNotification('Background dihapus dari landing page');
    })
    .fail(function(xhr, status, error) {
        $('#loadingOverlay').removeClass('show');
        console.error('❌ Failed to save background removal:', status, error);
        alert('Gagal menyimpan perubahan!\n\nError: ' + error + '\n\nSilakan coba lagi atau refresh halaman.');
    });
}

// Set grid media
function setGridMedia(position, media) {
    console.log('setGridMedia called for position:', position, 'media:', media);
    
    layoutData.gridItems[position] = media;
    const gridItem = $(`.grid-item[data-position="${position}"]`);
    
    const isVideo = media.type === 'Video';
    const isYouTube = media.file_path && (media.file_path.includes('youtube.com') || media.file_path.includes('youtu.be'));
    
    let mediaElement;
    
    if (isYouTube) {
        // YouTube video - convert to embed
        let embedUrl = media.file_path;
        if (embedUrl.includes('youtu.be/')) {
            const videoId = embedUrl.split('youtu.be/')[1].split('?')[0];
            embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}`;
        } else if (embedUrl.includes('watch?v=')) {
            const videoId = embedUrl.split('watch?v=')[1].split('&')[0];
            embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}`;
        }
        mediaElement = `<iframe src="${embedUrl}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width:100%; height:100%;"></iframe>`;
    } else if (isVideo) {
        mediaElement = `<video src="/storage/${media.file_path}" autoplay muted loop playsinline></video>`;
    } else {
        mediaElement = `<img src="/storage/${media.file_path}" alt="${media.name}">`;
    }
    
    // Update HTML with media and delete button
    gridItem.html(`
        <div class="position-badge">${position}</div>
        ${mediaElement}
    `).addClass('has-media');
    
    // Add delete button with jQuery event handler (more reliable than onclick)
    const deleteBtn = $(`
        <button class="remove-item">
            <i class="fas fa-times"></i>
        </button>
    `);
    
    deleteBtn.on('click', function(e) {
        e.stopPropagation();
        removeGridMedia(e, position);
    });
    
    gridItem.append(deleteBtn);
    
    // Autoplay video if it's a local video
    if (isVideo && !isYouTube) {
        const video = gridItem.find('video')[0];
        if (video) {
            video.play().catch(e => console.log('Autoplay prevented:', e));
        }
    }
    
    console.log('Grid media set successfully at position', position);
}

// Remove grid media
function removeGridMedia(event, position) {
    event.stopPropagation();
    
    const removedMedia = layoutData.gridItems[position];
    const mediaName = removedMedia ? removedMedia.name : 'Media';
    
    showConfirmModal(
        'Hapus Media dari Grid',
        `Apakah Anda yakin ingin menghapus <strong>"${mediaName}"</strong> dari posisi ${position}?`,
        [
            'Media hilang dari Landing Page',
            'Media hilang dari Grid Layout',
            'File tetap tersimpan dan bisa ditambahkan lagi',
            'Perubahan akan langsung disimpan'
        ],
        function() {
            // Callback when user clicks "Ya, Hapus"
            executeRemoveGridMedia(position, mediaName);
        }
    );
}

// Execute remove grid media (separated for modal callback)
function executeRemoveGridMedia(position, mediaName) {
    console.log('🗑️ Removing media from grid position:', position);
    
    // Remove from layoutData
    delete layoutData.gridItems[position];
    
    // Reset grid item UI
    const gridItem = $(`.grid-item[data-position="${position}"]`);
    gridItem.html(`
        <div class="position-badge">${position}</div>
        <div class="placeholder">
            <i class="fas fa-plus-circle"></i>
            <p>Klik untuk pilih media</p>
        </div>
    `).removeClass('has-media');
    
    // Re-attach click handler
    gridItem.attr('onclick', `openGridMediaModal(${position})`);
    
    console.log('✅ Media removed from layout (file still exists):', mediaName);
    
    // AUTO-SAVE: Update landing page immediately
    console.log('💾 Auto-saving to update landing page...');
    saveLayout();
}

// Clear all grid media
function clearAllGridMedia() {
    const mediaCount = Object.keys(layoutData.gridItems).length;
    
    if (mediaCount === 0) {
        showNotification('Grid sudah kosong!');
        return;
    }
    
    showConfirmModal(
        'Hapus Semua Media dari Grid',
        `Apakah Anda yakin ingin menghapus <strong>SEMUA ${mediaCount} media</strong> dari grid layout?`,
        [
            'Semua media hilang dari Landing Page',
            'Grid Layout dikosongkan',
            'File tetap tersimpan dan bisa ditambahkan lagi',
            'Perubahan akan langsung disimpan'
        ],
        function() {
            // Callback when user clicks "Ya, Hapus"
            executeClearAllGridMedia(mediaCount);
        }
    );
}

// Execute clear all grid media (separated for modal callback)
function executeClearAllGridMedia(mediaCount) {
    console.log('🗑️ Clearing all grid media from layout (4 positions)');
    
    const positionLabels = {
        1: 'Layout 1 (Kiri Atas)',
        2: 'Layout 2 (Kanan Atas)',
        3: 'Layout 3 (Kanan Bawah)',
        4: 'Layout 4 (Bawah)'
    };
    
    // Clear all grid items (4 positions)
    for (let i = 1; i <= 4; i++) {
        if (layoutData.gridItems[i]) {
            delete layoutData.gridItems[i];
            
            const gridItem = $(`.grid-item[data-position="${i}"]`);
            gridItem.html(`
                <div class="position-badge">${i}</div>
                <div class="placeholder">
                    <i class="fas fa-plus-circle"></i>
                    <p>${positionLabels[i]}</p>
                    <small style="font-size: 0.75rem; color: #9ca3af;">Klik untuk pilih media</small>
                </div>
            `).removeClass('has-media');
            gridItem.attr('onclick', `openGridMediaModal(${i})`);
        }
    }
    
    console.log(`✅ Cleared ${mediaCount} media from layout (files still exist)`);
    
    // AUTO-SAVE: Update landing page immediately
    console.log('💾 Auto-saving to update landing page...');
    saveLayout();
}

// Save description
function saveDescription() {
    const description = $('#descriptionTextarea').val();
    $.ajax({
        url: '/layout/description',
        method: 'POST',
        data: { description: description },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(response) {
        if (response.success) {
            layoutData.description = description;
            updateDescriptionPreview();
            bootstrap.Modal.getInstance($('#descriptionModal')).hide();
            showNotification('Deskripsi berhasil diperbarui!');
        }
    })
    .fail(function() {
        alert('Gagal menyimpan deskripsi');
    });
}

// Update description preview
function updateDescriptionPreview() {
    const preview = $('#previewDescription');
    if (layoutData.description) {
        preview.html(layoutData.description.replace(/\n/g, '<br>'));
    } else {
        preview.html('<em class="text-muted">Belum ada deskripsi. Klik tombol edit untuk menambahkan deskripsi.</em>');
    }
}

// Save complete layout
function saveLayout() {
    console.log('=== SAVING LAYOUT ===');
    $('#loadingOverlay').addClass('show');
    
    const promises = [];
    
    // Save background (or remove if null) - always send request to sync with backend
    const bgMediaId = layoutData.background ? layoutData.background.id : null;
    console.log('Saving background:', bgMediaId ? layoutData.background.name : 'CLEAR/REMOVE');
    
    const bgPromise = $.ajax({
        url: '/layout/background',
        method: 'POST',
        data: { media_id: bgMediaId },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    promises.push(bgPromise);
    // Map layout manager positions to landing page positions
    // Layout Manager → Landing Page mapping:
    // Position 1 → Landing Page Position 1 (nth-child 1)
    // Manager Position → Landing Page Position Mapping
    // Manager Pos 1 → Landing Pos 1 (Kebijakan)
    // Manager Pos 2 → Landing Pos 2 (Sosialisasi)
    // Manager Pos 3 → Landing Pos 3 (Gratifikasi)
    // Manager Pos 4 → Landing Pos 4 (Release)
    const positionMapping = {
        1: 1,  // Kebijakan
        2: 2,  // Sosialisasi
        3: 3,  // Gratifikasi
        4: 4   // Release
    };
    
    const mediaIds = new Array(6).fill(null); // Create array with 6 positions
    
    for (let managerPos = 1; managerPos <= 4; managerPos++) {
        if (layoutData.gridItems[managerPos]) {
            const landingPagePos = positionMapping[managerPos];
            mediaIds[landingPagePos - 1] = layoutData.gridItems[managerPos].id;
        }
    }
    
    // DON'T filter out nulls - keep positions intact!
    // Send full array with nulls to preserve position indices
    console.log('Saving grid with media at positions:', mediaIds);
    
    const layoutPromise = $.ajax({
        url: '/layout/update',
        method: 'POST',
        data: JSON.stringify({ media_ids: mediaIds }),  // Use JSON to preserve nulls
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .done(function(response) {
        console.log('✅ Layout update response:', response);
    })
    .fail(function(xhr, status, error) {
        console.error('❌ Layout update failed:', status, error);
        console.error('Response:', xhr.responseText);
    });
    promises.push(layoutPromise);
    
    // Wait for all promises to complete
    $.when.apply($, promises)
        .done(function(bgResponse, layoutResponse) {
            $('#loadingOverlay').removeClass('show');
            
            console.log('=== ALL REQUESTS COMPLETED ===');
            console.log('Background response:', bgResponse);
            console.log('Layout response:', layoutResponse);
            
            if (mediaIds.length === 0) {
                showNotification('Layout dikosongkan dan disimpan!');
                console.log('✅ Layout cleared successfully');
            } else {
                showNotification('Layout berhasil disimpan dan akan muncul di landing page!');
                console.log('✅ Layout saved successfully');
            }
        })
        .fail(function(xhr, status, error) {
            $('#loadingOverlay').removeClass('show');
            console.error('=== SAVE FAILED ===');
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('XHR:', xhr);
            
            let errorTitle = 'Gagal Menyimpan Layout!';
            let errorDetail = '';
            let solution = '';
            
            if (xhr && xhr.status) {
                if (xhr.status === 419) {
                    errorTitle = '⚠️ Session Expired!';
                    errorDetail = 'Token keamanan (CSRF) sudah kadaluarsa.';
                    solution = '<strong>SOLUSI:</strong> Klik tombol "Refresh Halaman" di bawah atau tekan F5.';
                } else if (xhr.status === 422) {
                    errorTitle = '⚠️ Data Tidak Valid!';
                    errorDetail = 'Data yang dikirim tidak sesuai format.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorDetail += '<br><small>' + JSON.stringify(xhr.responseJSON.errors) + '</small>';
                    }
                    solution = '<strong>SOLUSI:</strong> Coba refresh halaman dan ulangi.';
                } else if (xhr.status === 500) {
                    errorTitle = '⚠️ Server Error!';
                    errorDetail = 'Ada kesalahan di server Laravel.';
                    solution = '<strong>SOLUSI:</strong> Cek file log Laravel di storage/logs/laravel.log';
                } else if (xhr.status === 404) {
                    errorTitle = '⚠️ Endpoint Not Found!';
                    errorDetail = 'Route /layout/update tidak ditemukan.';
                    solution = '<strong>SOLUSI:</strong> Jalankan: php artisan route:clear';
                } else {
                    errorDetail = 'HTTP Status: ' + xhr.status;
                    solution = '<strong>SOLUSI:</strong> Refresh halaman dan coba lagi.';
                }
                
                if (xhr.responseText) {
                    console.error('Response Text:', xhr.responseText);
                }
            } else {
                errorTitle = '⚠️ Network Error!';
                errorDetail = 'Request tidak sampai ke server.';
                solution = '<strong>SOLUSI:</strong> Cek koneksi internet dan pastikan Laravel server berjalan.';
            }
            
            // Show error banner
            $('#errorMessage').html(`
                <strong>${errorTitle}</strong><br>
                ${errorDetail}<br><br>
                ${solution}
            `);
            $('#errorBanner').removeClass('d-none');
            
            // Scroll to error banner
            $('html, body').animate({
                scrollTop: $('#errorBanner').offset().top - 100
            }, 500);
            
            // Also show alert
            alert(errorTitle + '\n\n' + errorDetail.replace(/<[^>]*>/g, '') + '\n\n' + solution.replace(/<[^>]*>/g, ''));
        });
}

// Show notification
function showNotification(message) {
    $('#successMessage').text(message);
    $('#successNotification').addClass('show');
    setTimeout(() => {
        $('#successNotification').removeClass('show');
    }, 3000);
}

// Show custom confirmation modal
function showConfirmModal(title, message, details, onConfirm) {
    $('#confirmModalTitle').html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>${title}`);
    $('#confirmModalMessage').html(message);
    
    // Build details HTML
    let detailsHtml = '';
    if (Array.isArray(details)) {
        detailsHtml = details.map(detail => `
            <div style="display: flex; align-items: flex-start; margin-bottom: 8px;">
                <i class="bi bi-info-circle-fill me-2" style="color: #856404; font-size: 1.1rem; flex-shrink: 0;"></i>
                <span style="color: #856404;">${detail}</span>
            </div>
        `).join('');
    } else {
        detailsHtml = details;
    }
    
    $('#confirmModalDetails').html(detailsHtml);
    
    // Remove old event handlers and add new one
    $('#confirmModalYes').off('click').on('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        modal.hide();
        onConfirm();
    });
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

// Hide notification
function hideNotification() {
    $('#successNotification').removeClass('show');
}

// ═══════════════════════════════════════════════════════════════════════
// TEMPLATE MANAGEMENT FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════

// Track current background ID
let currentBackgroundId = null;

// Load templates on page load
document.addEventListener('DOMContentLoaded', function() {
    loadTemplateList();
});

/**
 * Load list of saved templates
 */
function loadTemplateList() {
    fetch('/api/layout/templates')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selector = document.getElementById('templateSelector');
                selector.innerHTML = '<option value="">-- Pilih Template --</option>';
                
                data.templates.forEach(template => {
                    const option = document.createElement('option');
                    option.value = template.id;
                    option.textContent = template.name;
                    selector.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading templates:', error);
        });
}

/**
 * Open save template modal
 */
function openSaveTemplateModal() {
    const modal = new bootstrap.Modal(document.getElementById('saveTemplateModal'));
    document.getElementById('templateName').value = '';
    modal.show();
}

/**
 * Save current layout as template
 */
function saveTemplate() {
    const templateName = document.getElementById('templateName').value.trim();
    
    if (!templateName) {
        Swal.fire('Error', 'Nama template harus diisi', 'error');
        return;
    }

    // Get current layout data
    const backgroundMediaId = currentBackgroundId || null;
    const gridPositions = {};
    
    // Collect grid positions
    for (let i = 1; i <= 6; i++) {
        const gridItem = document.querySelector(`[data-position="${i}"]`);
        if (gridItem) {
            const mediaId = gridItem.dataset.mediaId;
            if (mediaId) {
                gridPositions[i] = parseInt(mediaId);
            }
        }
    }

    const layoutDescription = document.getElementById('previewDescription').textContent.trim();

    // Save template
    fetch('/api/layout/save-template', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            name: templateName,
            background_media_id: backgroundMediaId,
            grid_positions: gridPositions,
            layout_description: layoutDescription !== 'Belum ada deskripsi. Klik tombol edit untuk menambahkan deskripsi.' ? layoutDescription : null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Template berhasil disimpan',
                icon: 'success',
                timer: 2000
            });
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('saveTemplateModal')).hide();
            
            // Reload template list
            loadTemplateList();
        } else {
            Swal.fire('Error', data.message || 'Gagal menyimpan template', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Gagal menyimpan template', 'error');
    });
}

/**
 * Load selected template
 */
function loadSelectedTemplate() {
    const templateId = document.getElementById('templateSelector').value;
    
    if (!templateId) {
        Swal.fire('Info', 'Pilih template terlebih dahulu', 'info');
        return;
    }

    Swal.fire({
        title: 'Load Template?',
        text: 'Layout saat ini akan diganti dengan template yang dipilih',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Load Template',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            loadTemplate(templateId);
        }
    });
}

/**
 * Load template by ID
 */
function loadTemplate(templateId) {
    Swal.fire({
        title: 'Loading...',
        text: 'Mohon tunggu',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`/api/layout/load-template/${templateId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const template = data.template;
                const gridMedia = data.grid_media;

                // Load background
                if (template.background_media_id && template.background_media) {
                    setBackgroundFromTemplate(template.background_media);
                } else {
                    clearBackgroundFromTemplate();
                }

                // Load grid positions
                clearAllGridMedia();
                if (gridMedia) {
                    Object.keys(gridMedia).forEach(position => {
                        const media = gridMedia[position];
                        setGridMediaFromTemplate(parseInt(position), media);
                    });
                }

                // Load description
                if (template.layout_description) {
                    document.getElementById('previewDescription').innerHTML = template.layout_description;
                } else {
                    document.getElementById('previewDescription').innerHTML = '<em class="text-muted">Belum ada deskripsi. Klik tombol edit untuk menambahkan deskripsi.</em>';
                }

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Template berhasil dimuat',
                    icon: 'success',
                    timer: 2000
                });
            } else {
                Swal.fire('Error', data.message || 'Gagal memuat template', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Gagal memuat template', 'error');
        });
}

/**
 * Delete selected template
 */
function deleteSelectedTemplate() {
    const templateId = document.getElementById('templateSelector').value;
    
    if (!templateId) {
        Swal.fire('Info', 'Pilih template terlebih dahulu', 'info');
        return;
    }

    Swal.fire({
        title: 'Hapus Template?',
        text: 'Template yang dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/layout/delete-template/${templateId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Template berhasil dihapus',
                        icon: 'success',
                        timer: 2000
                    });
                    
                    // Reload template list
                    loadTemplateList();
                } else {
                    Swal.fire('Error', data.message || 'Gagal menghapus template', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Gagal menghapus template', 'error');
            });
        }
    });
}

/**
 * Helper: Set background from template
 */
function setBackgroundFromTemplate(media) {
    const selector = document.getElementById('backgroundSelector');
    selector.classList.add('has-image');
    
    let mediaElement;
    if (media.type === 'Video') {
        mediaElement = `<video src="${media.file_path}" autoplay muted loop></video>`;
    } else {
        mediaElement = `<img src="${media.file_path}" alt="${media.name}">`;
    }
    
    selector.innerHTML = `
        ${mediaElement}
        <button class="remove-bg" onclick="clearBackground()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    currentBackgroundId = media.id;
}

/**
 * Helper: Clear background from template
 */
function clearBackgroundFromTemplate() {
    const selector = document.getElementById('backgroundSelector');
    selector.classList.remove('has-image');
    selector.innerHTML = `
        <i class="fas fa-cloud-upload-alt fa-4x text-primary mb-3"></i>
        <p class="text-dark fw-bold mb-1">Klik area lalu pilih media yang ingin ditampilkan</p>
        <p class="text-muted small">Untuk menambahkan gambar background</p>
    `;
    currentBackgroundId = null;
}

/**
 * Helper: Set grid media from template
 */
function setGridMediaFromTemplate(position, media) {
    const gridItem = document.querySelector(`[data-position="${position}"]`);
    if (!gridItem) return;

    gridItem.classList.add('has-media');
    gridItem.dataset.mediaId = media.id;
    
    let mediaElement;
    if (media.type === 'Video') {
        mediaElement = `<video src="${media.file_path}" autoplay muted loop></video>`;
    } else {
        mediaElement = `<img src="${media.file_path}" alt="${media.name}">`;
    }
    
    gridItem.innerHTML = `
        ${mediaElement}
        <div class="position-badge">${position}</div>
        <button class="remove-item" onclick="removeGridMedia(${position})">
            <i class="fas fa-times"></i>
        </button>
    `;
}


</script>

<!-- Save Template Modal -->
<div class="modal fade" id="saveTemplateModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-save me-2"></i>Simpan sebagai Template
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Template</label>
          <input type="text" class="form-control" id="templateName" placeholder="Contoh: Layout Default BPS">
        </div>
        <div class="alert alert-info">
          <i class="bi bi-info-circle me-2"></i>
          Template akan menyimpan:
          <ul class="mb-0 mt-2">
            <li>Background image yang dipilih</li>
            <li>Media di 6 posisi grid</li>
            <li>Deskripsi landing page</li>
          </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" onclick="saveTemplate()">
          <i class="fas fa-save me-2"></i>Simpan Template
        </button>
      </div>
    </div>
  </div>
</div>

</script>
</body>
</html>
