<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Layout Manager - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      border: none;
      padding: 0.65rem 1.5rem;
      font-weight: 600;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.25);
      transition: all 0.3s ease;
      letter-spacing: 0.3px;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
      box-shadow: 0 6px 20px rgba(31, 158, 118, 0.35);
      transform: translateY(-2px);
    }
    
    .btn-primary:active {
      transform: translateY(0);
    }
    
    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      border: none;
      padding: 0.65rem 1.5rem;
      font-weight: 600;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
      transition: all 0.3s ease;
      letter-spacing: 0.3px;
    }
    
    .btn-success:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
      transform: translateY(-2px);
    }
    
    .btn-success:active {
      transform: translateY(0);
    }
    
    .btn-secondary {
      background: #f3f4f6;
      border: none;
      color: #6b7280;
      padding: 0.65rem 1.5rem;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
      background: #e5e7eb;
      color: #4b5563;
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
    
    /* Grid Layout - Rapih & Proporsional */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(2, minmax(300px, 1fr));
      grid-template-rows: repeat(3, minmax(150px, 1fr));
      grid-template-columns: 1fr 1fr;
      grid-template-rows: 150px 150px 150px 100px;
      gap: 0.75rem;
      max-width: 900px;
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

    /* Position 1: Top Left - Square */
    .grid-item[data-position="1"] {
      grid-column: 1 / 2;
      grid-row: 1 / 2;
    }

    /* Position 2: Top Right - Portrait (2 rows) */
    .grid-item[data-position="2"] {
      grid-column: 2 / 3;
      grid-row: 1 / 3;
    }

    /* Position 3: Middle Left - Portrait (2 rows) */
    .grid-item[data-position="3"] {
      grid-column: 1 / 2;
      grid-row: 2 / 4;
    }

    /* Position 4: Middle Right - Square */
    .grid-item[data-position="4"] {
      grid-column: 2 / 3;
      grid-row: 3 / 4;
    }

    /* Position 5: Bottom Left - Landscape */
    .grid-item[data-position="5"] {
      grid-column: 1 / 2;
      grid-row: 4 / 5;
    }

    /* Position 6: Bottom Right - Landscape */
    .grid-item[data-position="6"] {
      grid-column: 2 / 3;
      grid-row: 4 / 5;
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
    
    /* Tab Navigation Styling */
    .nav-tabs {
      border-bottom: 2px solid #e5e7eb;
    }
    
    .nav-tabs .nav-link {
      border: none;
      color: #6b7280;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      border-radius: 0;
      border-bottom: 3px solid transparent;
      transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link:hover {
      color: var(--primary);
      border-bottom-color: var(--primary-light);
      background: transparent;
    }
    
    .nav-tabs .nav-link.active {
      color: var(--primary);
      background: transparent;
      border-bottom-color: var(--primary);
    }
    
    /* Staff Card Styling */
    .staff-card {
      background: white;
      border-radius: 12px;
      padding: 1.25rem;
      border: 2px solid #e5e7eb;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    
    .staff-card:hover {
      border-color: var(--primary);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.15);
      transform: translateY(-2px);
    }
    
    .staff-card img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      border: 2px solid #e5e7eb;
    }
    
    .staff-card-body {
      flex: 1;
    }
    
    .staff-card-name {
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--text-dark);
      margin-bottom: 0.25rem;
    }
    
    .staff-card-position {
      color: #6b7280;
      font-size: 0.9rem;
    }
    
    .staff-card-actions {
      display: flex;
      gap: 0.5rem;
    }
    
    .staff-card-actions .btn {
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
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
    
    #confirmModal .btn-danger:hover {
      background: #c82333 !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4) !important;
      transition: all 0.2s ease;
    }
    
    #confirmModal .btn-secondary:hover {
      background: #5a6268 !important;
      transform: translateY(-2px);
      transition: all 0.2s ease;
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
            <i class="bi bi-grid-3x3"></i> Layout Manager
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
      <h2>Layout Manager</h2>
      <div class="user-badge" title="Logged in">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name ?? 'User' }}</span>
      </div>
    </div>
    
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="layoutTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-content" 
                type="button" role="tab" aria-controls="gallery-content" aria-selected="true">
          <i class="fas fa-images me-2"></i>Gallery
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff-content" 
                type="button" role="tab" aria-controls="staff-content" aria-selected="false">
          <i class="fas fa-users me-2"></i>Petugas
        </button>
      </li>
    </ul>

    <!-- Success Notification -->
    <div class="success-notification" id="successNotification">
      <span id="successMessage"></span>
      <button class="close-btn" onclick="hideNotification()">×</button>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="layoutTabContent">
      <!-- Gallery Tab Content -->
      <div class="tab-pane fade show active" id="gallery-content" role="tabpanel" aria-labelledby="gallery-tab">
        <div class="row">
      <!-- Left Column: Background & Preview -->
      <div class="col-lg-7">
        <!-- Background Selector -->
        <div class="card mb-4">
          <div class="card-header">
            <h5>
              <i class="fas fa-image me-2"></i>Pilih Gambar Background
            </h5>
          </div>
          <div class="card-body">
            <div class="background-selector" id="backgroundSelector" onclick="openBackgroundModal()">
              <i class="fas fa-cloud-upload-alt fa-4x text-primary mb-3"></i>
              <p class="text-dark fw-bold mb-1">Klik area lalu pilih media yang ingin ditampilkan</p>
              <p class="text-muted small">Untuk menambahkan gambar background</p>
            </div>
            <div class="mt-2">
              <small class="text-success fw-bold">
                <i class="bi bi-check-circle-fill me-1"></i> 
                Auto-Save: Hapus background otomatis update landing page
              </small>
              <br>
              <small class="text-muted mt-1 d-block">
                <i class="bi bi-info-circle me-1"></i> 
                Klik tombol "✕" pada background untuk menghapus, file tetap tersimpan
              </small>
            </div>
          </div>
        </div>

        <!-- Preview Section -->
        <div class="preview-section">
          <div class="preview-title">
            Selamat Datang Di <span class="bps">B</span><span style="color: #ff9933;">P</span><span style="color: #00cc66;">S</span> Provinsi
          </div>
          <div class="preview-subtitle">Sumatera Utara</div>
          
          <div class="description-label">
            <i class="fas fa-align-left"></i>
            <strong>Deskripsi Landing Page</strong>
          </div>
          <div class="description-content" id="previewDescription">
            <em class="text-muted">Belum ada deskripsi. Klik tombol edit untuk menambahkan deskripsi.</em>
          </div>
          
          <button class="btn btn-primary mt-3" onclick="openDescriptionModal()">
            <i class="fas fa-edit me-2"></i>Edit Deskripsi
          </button>
        </div>
      </div>

      <!-- Right Column: Grid Layout -->
      <div class="col-lg-5">
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
      <!-- End Gallery Tab Content -->

      <!-- Staff Tab Content -->
      <div class="tab-pane fade" id="staff-content" role="tabpanel" aria-labelledby="staff-tab">
        <div class="row">
          <!-- Staff Management Section -->
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>
                  <i class="fas fa-users me-2"></i>Manajemen Petugas
                </h5>
              </div>
              <div class="card-body">
                <!-- Add Staff Form -->
                <div class="mb-4 p-4" style="background: #f8f9fa; border-radius: 12px;">
                  <h6 class="mb-3"><i class="fas fa-user-plus me-2"></i>Tambah Petugas Baru</h6>
                  <form id="addStaffForm" enctype="multipart/form-data">
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label class="form-label">Nama Petugas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="staffName" name="name" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Foto Petugas <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="staffPhoto" name="photo" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, GIF. Max: 5MB</small>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Posisi <span class="text-danger">*</span></label>
                        <select class="form-control" id="staffPosition" name="position" required>
                          <option value="1">1 (Kiri)</option>
                          <option value="2">2 (Kanan)</option>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                          <i class="fas fa-plus me-2"></i>Tambah
                        </button>
                      </div>
                    </div>
                    <!-- Image Preview -->
                    <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                      <label class="form-label">Preview:</label>
                      <div>
                        <img id="imagePreview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
                      </div>
                    </div>
                  </form>
                </div>

                <!-- Staff List -->
                <div>
                  <h6 class="mb-3"><i class="fas fa-list me-2"></i>Daftar Petugas</h6>
                  <div id="staffList" class="row g-3">
                    <!-- Staff cards will be loaded here -->
                  </div>
                  <div id="emptyStaffState" class="text-center py-5" style="display: none;">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data petugas</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Staff Tab Content -->
    </div>
    <!-- End Tab Content -->
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
        <div id="confirmModalDetails" style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #0d6efd;">
          <!-- Details will be inserted here -->
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 15px 25px; gap: 10px;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 25px; border-radius: 8px;">
          <i class="bi bi-x-circle me-1"></i> Tidak
        </button>
        <button type="button" class="btn btn-danger" id="confirmModalYes" style="padding: 10px 30px; border-radius: 8px;">
          <i class="bi bi-check-circle me-1"></i> Ya, Hapus
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

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Petugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editStaffForm" enctype="multipart/form-data">
        <input type="hidden" id="editStaffId">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Petugas <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="editStaffName" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Foto Petugas</label>
            <input type="file" class="form-control" id="editStaffPhoto" name="photo" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG, GIF. Max: 5MB</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Posisi <span class="text-danger">*</span></label>
            <select class="form-control" id="editStaffPosition" name="position" required>
              <option value="1">1 (Kiri)</option>
              <option value="2">2 (Kanan)</option>
            </select>
          </div>
          <!-- Current Photo Preview -->
          <div class="mb-3" id="currentPhotoContainer">
            <label class="form-label">Foto Saat Ini:</label>
            <div>
              <img id="currentPhoto" src="" alt="Current Photo" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
            </div>
          </div>
          <!-- New Photo Preview -->
          <div class="mb-3" id="editImagePreviewContainer" style="display: none;">
            <label class="form-label">Preview Foto Baru:</label>
            <div>
              <img id="editImagePreview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Staff Confirmation Modal -->
<div class="modal fade" id="deleteStaffModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus petugas ini?</p>
        <div class="alert alert-warning">
          <i class="fas fa-info-circle me-2"></i>
          <strong>Perhatian:</strong> Data yang dihapus tidak dapat dikembalikan.
        </div>
        <div id="deleteStaffInfo" class="p-3" style="background: #f8f9fa; border-radius: 8px;">
          <!-- Staff info will be inserted here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteStaff">
          <i class="fas fa-trash me-2"></i>Ya, Hapus
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
    
    // Tab switching with localStorage
    initializeTabs();
    
    // Load staff data when staff tab is shown
    $('button[data-bs-target="#staff-content"]').on('shown.bs.tab', function() {
        loadStaffList();
    });
    
    // Image preview for add staff form
    $('#staffPhoto').on('change', function() {
        previewImage(this, '#imagePreview', '#imagePreviewContainer');
    });
    
    // Image preview for edit staff form
    $('#editStaffPhoto').on('change', function() {
        previewImage(this, '#editImagePreview', '#editImagePreviewContainer');
    });
    
    // Add staff form submit
    $('#addStaffForm').on('submit', function(e) {
        e.preventDefault();
        addStaff();
    });
    
    // Edit staff form submit
    $('#editStaffForm').on('submit', function(e) {
        e.preventDefault();
        updateStaff();
    });
});

// Initialize grid with 6 positions
function initializeGrid() {
    const gridContainer = $('#gridContainer');
    for (let i = 1; i <= 6; i++) {
        const gridItem = $(`
            <div class="grid-item" data-position="${i}" onclick="openGridMediaModal(${i})">
                <div class="position-badge">${i}</div>
                <div class="placeholder">
                    <i class="fas fa-plus-circle"></i>
                    <p>Klik untuk pilih media</p>
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
                
                // Load grid media from default_media
                if (response.default_media && response.default_media.length > 0) {
                    console.log('📊 Loading', response.default_media.length, 'media from database:');
                    response.default_media.forEach((mediaData) => {
                        // Find full media object from allMedia
                        const fullMedia = allMedia.find(m => m.id == mediaData.id);
                        if (fullMedia && mediaData.layout_order) {
                            setGridMedia(mediaData.layout_order, fullMedia);
                            console.log(`  ✅ Position ${mediaData.layout_order}: ${fullMedia.name} (${fullMedia.type}, ID: ${fullMedia.id})`);
                        } else {
                            console.warn(`  ⚠️ Position ${mediaData.layout_order}: Media ID ${mediaData.id} not found in allMedia`);
                        }
                    });
                    console.log('✅ All grid media loaded from database');
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
    console.log('🗑️ Clearing all grid media from layout');
    
    // Clear all grid items
    for (let i = 1; i <= 6; i++) {
        if (layoutData.gridItems[i]) {
            delete layoutData.gridItems[i];
            
            const gridItem = $(`.grid-item[data-position="${i}"]`);
            gridItem.html(`
                <div class="position-badge">${i}</div>
                <div class="placeholder">
                    <i class="fas fa-plus-circle"></i>
                    <p>Klik untuk pilih media</p>
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
    const mediaIds = [];
    for (let i = 1; i <= 6; i++) {
        if (layoutData.gridItems[i]) {
            mediaIds.push(layoutData.gridItems[i].id);
        }
    }
    
    // IMPORTANT: Always send layout update with media_ids field (even if empty array)
    console.log('Saving grid with', mediaIds.length, 'media items:', mediaIds);
    
    const layoutPromise = $.ajax({
        url: '/layout/update',
        method: 'POST',
        data: { media_ids: mediaIds },  // Always send media_ids field
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8'
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
                <i class="bi bi-check-circle-fill me-2" style="color: #0d6efd; font-size: 1.1rem; flex-shrink: 0;"></i>
                <span>${detail}</span>
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

// ========================================
// TAB MANAGEMENT FUNCTIONS
// ========================================

function initializeTabs() {
    // Restore last active tab from localStorage
    const lastTab = localStorage.getItem('layoutManagerActiveTab');
    if (lastTab) {
        const tabButton = document.querySelector(`button[data-bs-target="${lastTab}"]`);
        if (tabButton) {
            const tab = new bootstrap.Tab(tabButton);
            tab.show();
        }
    }
    
    // Save active tab to localStorage when changed
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(button => {
        button.addEventListener('shown.bs.tab', function(e) {
            localStorage.setItem('layoutManagerActiveTab', e.target.getAttribute('data-bs-target'));
        });
    });
}

// ========================================
// STAFF MANAGEMENT FUNCTIONS
// ========================================

function loadStaffList() {
    $.ajax({
        url: '/api/staff',
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(response) {
        if (response.success) {
            renderStaffList(response.staff);
        }
    })
    .fail(function() {
        alert('Gagal memuat data petugas');
    });
}

function renderStaffList(staffList) {
    const container = $('#staffList');
    const emptyState = $('#emptyStaffState');
    
    if (staffList.length === 0) {
        container.empty();
        emptyState.show();
        return;
    }
    
    emptyState.hide();
    container.empty();
    
    staffList.forEach(staff => {
        const photoUrl = staff.photo_path ? `/storage/${staff.photo_path}` : '/images/default-avatar.png';
        const positionText = staff.position === 1 ? 'Kiri' : 'Kanan';
        
        const card = $(`
            <div class="col-md-6 col-lg-4">
                <div class="staff-card">
                    <img src="${photoUrl}" alt="${staff.name}">
                    <div class="staff-card-body">
                        <div class="staff-card-name">${staff.name}</div>
                        <div class="staff-card-position">Posisi: ${positionText}</div>
                    </div>
                    <div class="staff-card-actions">
                        <button class="btn btn-sm btn-primary" onclick="openEditStaffModal(${staff.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="openDeleteStaffModal(${staff.id}, '${staff.name}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `);
        
        container.append(card);
    });
}

// Initialize tabs with localStorage persistence
function initializeTabs() {
    // Get saved tab from localStorage
    const savedTab = localStorage.getItem('activeLayoutTab');
    
    if (savedTab) {
        // Activate saved tab
        const tabTrigger = document.querySelector(`button[data-bs-target="${savedTab}"]`);
        if (tabTrigger) {
            const tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }
    
    // Save tab state when switching
    const tabButtons = document.querySelectorAll('#layoutTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            const targetTab = event.target.getAttribute('data-bs-target');
            localStorage.setItem('activeLayoutTab', targetTab);
        });
    });
}

function previewImage(input, previewSelector, containerSelector) {
    const file = input.files[0];
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF');
            input.value = '';
            return;
        }
        
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 5MB');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            $(previewSelector).attr('src', e.target.result);
            $(containerSelector).show();
        };
        reader.readAsDataURL(file);
    } else {
        $(containerSelector).hide();
    }
}

function addStaff() {
    const formData = new FormData($('#addStaffForm')[0]);
    
    $('#loadingOverlay').addClass('show');
    
    $.ajax({
        url: '/api/staff',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(response) {
        $('#loadingOverlay').removeClass('show');
        if (response.success) {
            showNotification('Petugas berhasil ditambahkan!');
            $('#addStaffForm')[0].reset();
            $('#imagePreviewContainer').hide();
            loadStaffList();
        }
    })
    .fail(function(xhr) {
        $('#loadingOverlay').removeClass('show');
        let errorMsg = 'Gagal menambahkan petugas';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
        }
        alert(errorMsg);
    });
}

function openEditStaffModal(staffId) {
    $.ajax({
        url: '/api/staff',
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(response) {
        if (response.success) {
            const staff = response.staff.find(s => s.id === staffId);
            if (staff) {
                $('#editStaffId').val(staff.id);
                $('#editStaffName').val(staff.name);
                $('#editStaffPosition').val(staff.position);
                
                const photoUrl = staff.photo_path ? `/storage/${staff.photo_path}` : '/images/default-avatar.png';
                $('#currentPhoto').attr('src', photoUrl);
                $('#currentPhotoContainer').show();
                $('#editImagePreviewContainer').hide();
                $('#editStaffPhoto').val('');
                
                const modal = new bootstrap.Modal(document.getElementById('editStaffModal'));
                modal.show();
            }
        }
    });
}

function updateStaff() {
    const staffId = $('#editStaffId').val();
    const formData = new FormData($('#editStaffForm')[0]);
    
    $('#loadingOverlay').addClass('show');
    
    $.ajax({
        url: `/api/staff/${staffId}`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-HTTP-Method-Override': 'PUT'
        }
    })
    .done(function(response) {
        $('#loadingOverlay').removeClass('show');
        if (response.success) {
            showNotification('Petugas berhasil diupdate!');
            bootstrap.Modal.getInstance(document.getElementById('editStaffModal')).hide();
            loadStaffList();
        }
    })
    .fail(function(xhr) {
        $('#loadingOverlay').removeClass('show');
        let errorMsg = 'Gagal mengupdate petugas';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
        }
        alert(errorMsg);
    });
}

function openDeleteStaffModal(staffId, staffName) {
    $('#deleteStaffInfo').html(`
        <strong>Nama:</strong> ${staffName}<br>
        <strong>ID:</strong> ${staffId}
    `);
    
    $('#confirmDeleteStaff').off('click').on('click', function() {
        deleteStaff(staffId);
    });
    
    const modal = new bootstrap.Modal(document.getElementById('deleteStaffModal'));
    modal.show();
}

function deleteStaff(staffId) {
    $('#loadingOverlay').addClass('show');
    
    $.ajax({
        url: `/api/staff/${staffId}`,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })
    .done(function(response) {
        $('#loadingOverlay').removeClass('show');
        if (response.success) {
            showNotification('Petugas berhasil dihapus!');
            bootstrap.Modal.getInstance(document.getElementById('deleteStaffModal')).hide();
            loadStaffList();
        }
    })
    .fail(function(xhr) {
        $('#loadingOverlay').removeClass('show');
        let errorMsg = 'Gagal menghapus petugas';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
        }
        alert(errorMsg);
    });
}
</script>
</body>
</html>
