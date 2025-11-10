<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Layout Manager - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
  :root {
    --brand-blue: #2c3a67;
    --primary: #1f9e76;
    --primary-2: #58cbaa;
    --accent-blue: #0071BC;
    --accent-lime: #8CC63F;
    --accent-orange: #F7931E;
    --bg-soft: #f8f9fa;
    --border-soft: #e9ecef;
  }

  

  body {
    background-color: #405672;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #2f3a55;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }

  /* ===== CUSTOM SCROLLBAR ===== */
  ::-webkit-scrollbar {
    width: 10px;
    height: 10px;
  }

  ::-webkit-scrollbar-track {
    background: #f1f3f4;
    border-radius: 10px;
  }

  ::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #1f9e76, #58cbaa);
    border-radius: 10px;
    transition: background 0.3s ease;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, #1a8563, #4ab599);
  }

  /* Firefox scrollbar */
  * {
    scrollbar-width: thin;
    scrollbar-color: #1f9e76 #f1f3f4;
  }

  .sidebar {
    background: linear-gradient( 180deg,#E7FFEA 0%,#ffffff 50%,#dcedff 100%);
    border-right: none;
    min-height: 100vh;
    width: 250px;
    display: flex;
    flex-direction: column;
    position: fixed;
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

  .title-text {
      display: inline-block;
  }

  .tam { color: #0084d6; }
  .bo { color: #a0d5d2; }
  .dia { color: #1f9e76; }

  .sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 0;
  }

  .nav-link.active {
    background-color: #1f9e76;
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    position: relative;
    overflow: hidden;
  }

  .nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: #1f9e76;
    transform: scaleY(0);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .nav-link:hover:not(.active) {
    background-color: #bcddc9;
    color: #1f9e76;
    cursor: pointer;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(31, 158, 118, 0.2);
  }

  .nav-link:hover:not(.active)::before {
    transform: scaleY(1);
  }

  /* Main Content */
  .main-content {
    margin-left: 250px;
    padding: 1.75rem 2rem 2rem 2rem;
    min-height: 100vh;
    background: #f8f9fa;
    position: relative;
  }

  .layout-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    overflow: hidden;
    max-width: 1200px;
    transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-card:hover {
    box-shadow: 0 15px 50px rgba(0,0,0,0.15);
  }

  .layout-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .layout-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: shimmer 3s ease-in-out infinite;
  }

  @keyframes shimmer {
    0%, 100% {
      transform: translate(0, 0);
    }
    50% {
      transform: translate(-30%, -30%);
    }
  }

  .layout-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 1;
  }

  .layout-title i {
    animation: rotate 3s ease-in-out infinite;
  }

  @keyframes rotate {
    0%, 100% {
      transform: rotate(0deg);
    }
    25% {
      transform: rotate(-5deg);
    }
    75% {
      transform: rotate(5deg);
    }
  }

  .layout-body {
    padding: 1rem 1.5rem;
    max-height: calc(100vh - 180px);
    overflow-y: auto;
  }

  .layout-container {
    display: flex;
    gap: 1.5rem;
    min-height: auto;
    justify-content: center;
  }

  .layout-left {
    display: none; /* Hidden - not needed for layout grid */
  }

  .upload-area {
    border: 2px dashed var(--accent-orange);
    border-radius: 6px;
    padding: 0.75rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(135deg, rgba(247, 147, 30, 0.05) 0%, rgba(255, 159, 58, 0.05) 100%);
    position: relative;
    overflow: hidden;
  }

  .upload-area::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(247, 147, 30, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .upload-area:hover::before {
    width: 300px;
    height: 300px;
  }

  .upload-area:hover {
    border-color: #ff9f3a;
    background: linear-gradient(135deg, rgba(247, 147, 30, 0.1) 0%, rgba(255, 159, 58, 0.1) 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(247, 147, 30, 0.2);
  }

  .upload-icon {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
    opacity: 0.8;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    color: var(--accent-orange);
  }

  .upload-area:hover .upload-icon {
    transform: translateY(-2px) scale(1.05);
  }

  /* Preview section removed - not needed */

  .description-area {
    margin-top: 1rem;
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .description-area:hover {
    border-color: var(--primary-2);
    box-shadow: 0 6px 20px rgba(31, 158, 118, 0.1);
  }

  .description-input {
    width: 100%;
    height: 60px;
    border: 2px solid var(--border-soft);
    border-radius: 6px;
    padding: 0.5rem;
    resize: vertical;
    font-family: inherit;
    font-size: 0.85rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .description-input:hover {
    border-color: var(--primary-2);
  }

  .description-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(31, 158, 118, 0.15);
    transform: translateY(-1px);
  }

  .background-upload-section {
    margin-top: 1rem;
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .background-upload-section:hover {
    border-color: var(--accent-orange);
    box-shadow: 0 6px 20px rgba(247, 147, 30, 0.1);
  }

  .layout-right {
    width: 100%;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    transform: scale(0.85);
    transform-origin: top center;
  }

  .grid-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--brand-blue);
    margin-bottom: 0.75rem;
    text-align: center;
    padding: 0.5rem;
    background: linear-gradient(135deg, rgba(31, 158, 118, 0.05) 0%, rgba(88, 203, 170, 0.05) 100%);
    border-radius: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .grid-title:hover {
    background: linear-gradient(135deg, rgba(31, 158, 118, 0.1) 0%, rgba(88, 203, 170, 0.1) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(31, 158, 118, 0.1);
  }

  /* ===== LAYOUT GRID SYSTEM ===== */
  .layout-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto auto auto;
    gap: 0.75rem;
    margin-bottom: 1rem;
    min-height: auto;
  }

  .layout-grid .layout-box {
    animation: fadeInScale 0.5s cubic-bezier(0.4, 0, 0.2, 1) backwards;
  }

  .layout-grid .layout-box:nth-child(1) { animation-delay: 0.1s; }
  .layout-grid .layout-box:nth-child(2) { animation-delay: 0.15s; }
  .layout-grid .layout-box:nth-child(3) { animation-delay: 0.2s; }
  .layout-grid .layout-box:nth-child(4) { animation-delay: 0.25s; }
  .layout-grid .layout-box:nth-child(5) { animation-delay: 0.3s; }
  .layout-grid .layout-box:nth-child(6) { animation-delay: 0.35s; }

  @keyframes fadeInScale {
    from {
      opacity: 0;
      transform: scale(0.8);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  /* ===== GRID POSITIONING & ASPECT RATIOS ===== */
  /* Position 1: Top Left - Square (1:1) */
  .layout-box:nth-child(1) {
    grid-column: 1;
    grid-row: 1;
    width: 100%;
    aspect-ratio: 1/1;
  }

  /* Position 2: Top Right - Portrait (9:16) */
  .layout-box:nth-child(2) {
    grid-column: 2;
    grid-row: 1 / 3;
    width: 100%;
    aspect-ratio: 9/16;
  }

  /* Position 3: Middle Left - Portrait (9:16) */
  .layout-box:nth-child(3) {
    grid-column: 1;
    grid-row: 2 / 4;
    width: 100%;
    aspect-ratio: 9/16;
  }

  /* Position 4: Middle Right - Square (1:1) */
  .layout-box:nth-child(4) {
    grid-column: 2;
    grid-row: 3;
    width: 100%;
    aspect-ratio: 1/1;
  }

  /* Position 5: Bottom Left - Landscape (16:9) */
  .layout-box:nth-child(5) {
    grid-column: 1;
    grid-row: 4;
    width: 100%;
    aspect-ratio: 16/9;
  }

  /* Position 6: Bottom Right - Landscape (16:9) */
  .layout-box:nth-child(6) {
    grid-column: 2;
    grid-row: 4;
    width: 100%;
    aspect-ratio: 16/9;
  }

  .section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: linear-gradient(135deg, var(--bg-soft) 0%, #ffffff 100%);
    border-radius: 8px;
    border-left: 4px solid var(--primary);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .section-header:hover {
    transform: translateX(3px);
    box-shadow: 0 4px 12px rgba(31, 158, 118, 0.1);
  }

  .background-section .section-header {
    border-left: 4px solid var(--accent-orange);
  }

  .gallery-section .section-header {
    border-left: 4px solid var(--accent-blue);
  }

  .section-title {
    font-weight: 600;
    color: var(--brand-blue);
    font-size: 1rem;
  }

  .section-subtitle {
    color: #6c757d;
    font-size: 0.85rem;
    margin-left: auto;
  }

  /* ===== LAYOUT BOX STYLING ===== */
  .layout-box {
    background: white;
    border: 3px solid var(--border-soft);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .layout-box::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(31, 158, 118, 0.05) 0%, rgba(88, 203, 170, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
  }

  .layout-box:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 25px rgba(31, 158, 118, 0.25);
    transform: translateY(-3px) scale(1.02);
  }

  .layout-box:hover::after {
    opacity: 1;
  }

  .layout-box.has-image {
    border-color: var(--primary);
    padding: 0;
  }

  .layout-box-current-media {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }

  .layout-box-current-media::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
    z-index: 1;
  }

  .layout-box-current-media:hover {
    transform: scale(1.03);
    filter: brightness(1.08);
  }

  .layout-box-current-media:hover::before {
    opacity: 1;
  }

  /* ===== MEDIA CONTENT STYLING ===== */
  .layout-box-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .layout-box-image.youtube-video {
    border: none;
    border-radius: 8px;
  }

  /* Video elements */
  .layout-box video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  /* YouTube iframes */
  .layout-box iframe.youtube-video {
    width: 100%;
    height: 100%;
    display: block;
  }

  .layout-box-current-media {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .layout-box-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.85);
    color: white;
    padding: 6px;
    font-size: 0.7rem;
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-box:hover .layout-box-info {
    transform: translateY(0);
  }

  .layout-box-name {
    font-weight: 600;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .layout-box-user {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.7rem;
    opacity: 0.9;
  }

  .layout-box-user.own-media {
    color: #28a745;
  }

  .layout-box-user.other-admin-media {
    color: #ffc107;
  }

  .layout-box-user i {
    font-size: 0.8rem;
  }

  .video-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.85);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    gap: 4px;
    z-index: 2;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-box:hover .video-overlay {
    transform: translate(-50%, -50%) scale(1.1);
    background: rgba(0, 0, 0, 0.95);
  }

  .layout-box .video-overlay {
    background: rgba(0, 0, 0, 0.9);
    font-size: 0.65rem;
    padding: 4px 10px;
  }

  .layout-box-placeholder {
    color: #6c757d;
    font-size: 0.75rem;
    text-align: center;
    padding: 0.75rem;
    font-weight: 500;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-box:hover .layout-box-placeholder {
    color: var(--primary);
    transform: scale(1.05);
  }

  .layout-box-placeholder i {
    font-size: 1.25rem;
    opacity: 0.7;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-box:hover .layout-box-placeholder i {
    opacity: 1;
    transform: translateY(-2px);
  }

  .background-box {
    border-left: 4px solid var(--accent-orange);
  }

  .background-box:hover {
    border-color: var(--accent-orange);
    box-shadow: 0 8px 25px rgba(247, 147, 30, 0.25);
  }

  .background-box .layout-box-number {
    background: linear-gradient(135deg, var(--accent-orange), #ff9f3a);
  }

  .gallery-box {
    border-left: 4px solid var(--accent-blue);
  }

  .gallery-box:hover {
    border-color: var(--accent-blue);
    box-shadow: 0 8px 25px rgba(0, 113, 188, 0.25);
  }

  .gallery-box .layout-box-number {
    background: linear-gradient(135deg, var(--accent-blue), #0084d6);
  }

  .layout-box-number {
    position: absolute;
    top: 6px;
    left: 6px;
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(31, 158, 118, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-box:hover .layout-box-number {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 3px 12px rgba(31, 158, 118, 0.4);
  }

  .layout-box-remove {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #dc3545;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    cursor: pointer;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .layout-box-remove:hover {
    background: #c82333;
    transform: scale(1.15) rotate(90deg);
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.4);
  }

  .layout-box-remove:active {
    transform: scale(1.05) rotate(90deg);
  }

  .layout-box.has-image:hover .layout-box-remove {
    display: flex;
  }

  .layout-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    background: var(--bg-soft);
    border-top: 1px solid var(--border-soft);
  }

  .layout-info {
    color: #6c757d;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .layout-actions {
    display: flex;
    gap: 1rem;
  }

  .btn-layout {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    overflow: hidden;
  }

  .btn-layout::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .btn-layout:hover::before {
    width: 300px;
    height: 300px;
  }

  .btn-layout-save {
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: white;
  }

  .btn-layout-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(31, 158, 118, 0.4);
  }

  .btn-layout-save:active {
    transform: translateY(0);
    box-shadow: 0 5px 15px rgba(31, 158, 118, 0.3);
  }

  .btn-layout-preview {
    background: linear-gradient(135deg, var(--accent-blue), #0056b3);
    color: white;
  }

  .btn-layout-preview:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 113, 188, 0.4);
  }

  .btn-layout-preview:active {
    transform: translateY(0);
    box-shadow: 0 5px 15px rgba(0, 113, 188, 0.3);
  }

  .btn-layout-back {
    background: #6c757d;
    color: white;
  }

  .btn-layout-back:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
  }

  .btn-layout-back:active {
    transform: translateY(0);
  }

  /* Image Selector Modal */
  .image-selector-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1060;
    backdrop-filter: blur(5px);
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
  }

  .image-selector-modal.show {
    display: flex;
    opacity: 1;
  }

  .image-selector-content {
    background: white;
    border-radius: 16px;
    max-width: 90vw;
    max-height: 90vh;
    width: 800px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    transform: scale(0.9) translateY(20px);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .image-selector-modal.show .image-selector-content {
    transform: scale(1) translateY(0);
  }

  .image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    padding: 1rem;
    max-height: 400px;
    overflow-y: auto;
  }

  .image-grid .image-card {
    animation: slideInUp 0.4s cubic-bezier(0.4, 0, 0.2, 1) backwards;
  }

  .image-grid .image-card:nth-child(1) { animation-delay: 0.05s; }
  .image-grid .image-card:nth-child(2) { animation-delay: 0.1s; }
  .image-grid .image-card:nth-child(3) { animation-delay: 0.15s; }
  .image-grid .image-card:nth-child(4) { animation-delay: 0.2s; }
  .image-grid .image-card:nth-child(5) { animation-delay: 0.25s; }
  .image-grid .image-card:nth-child(6) { animation-delay: 0.3s; }

  @keyframes slideInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .image-card {
    background: white;
    border: 2px solid var(--border-soft);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    position: relative;
  }

  .image-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(31, 158, 118, 0.1) 0%, rgba(88, 203, 170, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
  }

  .image-card:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 20px rgba(31, 158, 118, 0.25);
    transform: translateY(-4px) scale(1.02);
  }

  .image-card:hover::before {
    opacity: 1;
  }

  .image-card-img {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .image-card:hover .image-card-img {
    transform: scale(1.05);
  }

  .image-card-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .image-card-body {
    padding: 0.75rem;
  }

  .image-card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--brand-blue);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    color: #6c757d;
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
    animation: pulse 2s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
      opacity: 0.5;
    }
    50% {
      transform: scale(1.05);
      opacity: 0.7;
    }
  }

  /* ===== RESPONSIVE DESIGN ===== */
  @media (max-width: 768px) {
    .layout-container {
      flex-direction: column;
    }
    
    .layout-right {
      width: 100%;
    }
    
    .layout-grid {
      grid-template-columns: repeat(3, 1fr);
    }

    /* Maintain aspect ratios on mobile */
    .layout-box:nth-child(1),
    .layout-box:nth-child(4) {
      aspect-ratio: 1/1;
      height: auto;
    }
    
    .layout-box:nth-child(2),
    .layout-box:nth-child(3) {
      aspect-ratio: 9/16;
      height: auto;
    }
    
    .layout-box:nth-child(5),
    .layout-box:nth-child(6) {
      aspect-ratio: 16/9;
      height: auto;
    }
  }
</style>

<body>
  <!-- Sidebar Navigation -->
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
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard.pegawai') }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('media.input') }}">
            <i class="bi bi-pencil-square"></i> <span>Input Media</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('layout.index') }}">
            <i class="bi bi-grid-3x3-gap"></i> <span>Layout Manager</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar3"></i> <span>Penjadwalan</span>
          </a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">
            @csrf
          </form>
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> <span>Log Out</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="layout-card">
      <div class="layout-header">
        <h3 class="layout-title">
          <i class="bi bi-palette"></i>
          Atur Tata Letak Gambar Landing Page
        </h3>
      </div>
      
      <div class="layout-body">
        <div class="layout-container">
          <div class="layout-right">
            <div class="grid-title">
              <i class="bi bi-grid-3x2"></i> Layout Grid (6 Posisi)
            </div>
            <div class="layout-grid" id="layoutGrid">
              @for($i = 1; $i <= 6; $i++)
                @php
                  $currentMedia = isset($positionMap[$i]) ? $positionMap[$i] : null;
                  $isOwnMedia = $currentMedia && $currentMedia->user_id == Auth::id();
                  $videoPath = $currentMedia ? $currentMedia->file_path : '';
                  $isYouTube = $currentMedia && (str_contains($videoPath, 'youtube.com') || str_contains($videoPath, 'youtu.be'));
                  $videoId = '';
                  if ($isYouTube) {
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoPath, $matches);
                    $videoId = $matches[1] ?? '';
                  }
                @endphp
                <div class="layout-box" 
                     data-position="{{ $i }}" 
                     onclick="selectLayoutBox({{ $i }})"
                     @if($currentMedia)
                       data-media-type="{{ $currentMedia->type }}"
                       data-media-path="{{ $currentMedia->file_path }}"
                       data-media-name="{{ $currentMedia->name }}"
                       data-youtube-id="{{ $videoId }}"
                       style="cursor: pointer;"
                     @endif>
                  <div class="layout-box-number">{{ $i }}</div>
                  @if($currentMedia)
                    <div class="layout-box-current-media" 
                         @if($currentMedia)
                           onclick="previewLayoutMedia(event, {{ $i }})"
                           style="cursor: pointer;"
                         @endif>
                      @if($currentMedia->type === 'Gambar')
                        <img src="{{ asset('storage/' . $currentMedia->file_path) }}" alt="{{ $currentMedia->name }}" class="layout-box-image">
                      @elseif($currentMedia->type === 'Video')
                        @if($isYouTube && $videoId)
                          <div class="video-overlay">
                            <i class="bi bi-play-circle"></i>
                            YouTube
                          </div>
                          <iframe 
                            src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
                            title="{{ $currentMedia->name }}"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="layout-box-image youtube-video">
                          </iframe>
                        @else
                          <video autoplay muted loop class="layout-box-image">
                            <source src="{{ asset('storage/' . $currentMedia->file_path) }}" type="video/mp4">
                          </video>
                        @endif
                      @endif
                      <div class="layout-box-info">
                        <div class="layout-box-name">{{ Str::limit($currentMedia->name, 20) }}</div>
                        <div class="layout-box-user {{ $isOwnMedia ? 'own-media' : 'other-admin-media' }}">
                          @if($isOwnMedia)
                            <i class="bi bi-person-check-fill"></i> Media Anda
                          @else
                            <i class="bi bi-person-x-fill"></i> Admin Lain
                          @endif
                        </div>
                      </div>
                    </div>
                  @else
                    <div class="layout-box-placeholder">Klik untuk pilih media</div>
                  @endif
                </div>
              @endfor
            </div>
            
            <!-- Description Section -->
            <div class="description-area">
              <label class="form-label fw-semibold mb-2">
                <i class="bi bi-text-paragraph"></i> Deskripsi Landing Page
              </label>
              <textarea class="description-input" id="layoutDescription" placeholder="Masukkan deskripsi yang akan ditampilkan di landing page...">{{ $description }}</textarea>
            </div>
            
            <!-- Background Upload Section -->
            <div class="background-upload-section">
              <label class="form-label fw-semibold mb-3">
                <i class="bi bi-image-fill"></i> Background Landing Page
              </label>
              <div class="upload-area" id="backgroundUploadArea" onclick="showBackgroundSelector()">
                <div class="upload-icon" id="backgroundUploadIcon">
                  <i class="bi bi-cloud-upload"></i>
                </div>
                <div id="backgroundUploadText">
                  <strong>Klik untuk pilih gambar background</strong>
                </div>
                <div class="background-preview" id="backgroundPreview" style="display: none; margin-top: 1rem;">
                  <img id="backgroundPreviewImg" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;">
                  <div style="margin-top: 0.5rem; font-size: 0.9rem; color: var(--primary); font-weight: 500;" id="backgroundPreviewName"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="layout-controls">
        <div class="layout-info">
          <i class="bi bi-info-circle"></i>
          <div>
            <div><strong>Media akan ditampilkan di gallery landing page.</strong></div>
            <div style="font-size: 0.9rem; margin-top: 4px;">
              <span class="text-success"><i class="bi bi-person-check-fill"></i> Media Anda</span> | 
              <span class="text-warning"><i class="bi bi-person-x-fill"></i> Admin Lain</span>
            </div>
            <div style="font-size: 0.85rem; margin-top: 4px; color: #6c757d;">
              Foto yang ditambahkan akan menggantikan foto yang sudah ada di posisi yang sama.
            </div>
          </div>
        </div>
        <div class="layout-actions">
          <button class="btn-layout btn-layout-preview" onclick="previewLayout()">
            <i class="bi bi-eye"></i> Preview
          </button>
          <button class="btn-layout btn-layout-save" onclick="saveLayoutChanges()">
            <i class="bi bi-check-circle"></i> Simpan & Terapkan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Selector Modal -->
  <div class="image-selector-modal" id="imageSelectorModal">
    <div class="image-selector-content">
      <div class="layout-header">
        <h3 class="layout-title">
          <i class="bi bi-images"></i>
          Pilih Gambar untuk Layout
        </h3>
        <button class="btn btn-outline-light btn-sm" onclick="closeImageSelector()">
          <i class="bi bi-x"></i>
        </button>
      </div>
      <div id="imageGrid" class="image-grid">
        <!-- Images will be populated here -->
      </div>
      <div class="modal-footer" id="backgroundModalFooter" style="display: none; padding: 1rem; border-top: 1px solid var(--border-soft); background: var(--bg-soft);">
        <button class="btn btn-outline-danger" onclick="clearBackground()">
          <i class="bi bi-trash"></i> Hapus Background
        </button>
        <button class="btn btn-secondary" onclick="closeImageSelector()">
          <i class="bi bi-x"></i> Batal
        </button>
      </div>
    </div>
  </div>

  <!-- Media Preview Modal (Layout Manager) -->
  <div class="modal fade" id="lmMediaPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-transparent border-0">
        <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0 d-flex justify-content-center align-items-center">
          <div id="lmMediaPreviewContainer" style="width:100%; max-width: 90vw; max-height: 85vh; display:flex; align-items:center; justify-content:center;"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const media = @json($media);
    const layoutImages = @json($layoutImages);
    
    const layoutState = {
      images: @json($media),
      layoutBoxes: {},
      selectedBox: null,
      description: @json($description),
      isBackgroundMode: false
    };

    // Initialize layout on page load
    document.addEventListener('DOMContentLoaded', function() {
      loadExistingLayout();
      loadExistingBackground();
    });

    function loadExistingBackground() {
      // Check if there's an existing background image
      fetch('/api/layout/background')
        .then(response => response.json())
        .then(data => {
          if (data.success && data.background) {
            updateBackgroundPreview(data.background);
          }
        })
        .catch(error => {
          console.log('No existing background or error loading:', error);
        });
    }

    function loadExistingLayout() {
      // Load existing layout images into boxes
      layoutImages.forEach(img => {
        if (img.layout_order && img.layout_order >= 1 && img.layout_order <= 6) {
          layoutState.layoutBoxes[img.layout_order] = img;
          // Don't call updateLayoutBox here since the layout is already rendered in PHP
        }
      });
    }

    function selectLayoutBox(position) {
      layoutState.selectedBox = position;
      showImageSelector();
    }

    function showImageSelector() {
      renderImageSelector();
      document.getElementById('imageSelectorModal').classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    function showBackgroundSelector() {
      // Set a special flag to indicate this is for background
      layoutState.isBackgroundMode = true;
      
      // Update modal title for background selection
      const modalTitle = document.querySelector('#imageSelectorModal .layout-title');
      if (modalTitle) {
        modalTitle.innerHTML = '<i class="bi bi-image-fill"></i> Pilih Gambar Background';
      }
      
      // Show background modal footer
      const footer = document.getElementById('backgroundModalFooter');
      if (footer) {
        footer.style.display = 'flex';
        footer.style.justifyContent = 'space-between';
        footer.style.alignItems = 'center';
      }
      
      renderImageSelector();
      document.getElementById('imageSelectorModal').classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    function closeImageSelector() {
      document.getElementById('imageSelectorModal').classList.remove('show');
      document.body.style.overflow = '';
      layoutState.selectedBox = null;
      layoutState.isBackgroundMode = false;
      
      // Reset modal title
      const modalTitle = document.querySelector('#imageSelectorModal .layout-title');
      if (modalTitle) {
        modalTitle.innerHTML = '<i class="bi bi-images"></i> Pilih Gambar untuk Layout';
      }
      
      // Hide background modal footer
      const footer = document.getElementById('backgroundModalFooter');
      if (footer) {
        footer.style.display = 'none';
      }
    }

    function renderImageSelector() {
      const grid = document.getElementById('imageGrid');
      
      if (layoutState.images.length === 0) {
        grid.innerHTML = `
          <div class="empty-state">
            <i class="bi bi-images"></i>
            <h5>Tidak ada media yang tersedia</h5>
            <p>Silakan tambahkan media terlebih dahulu di halaman Input Media</p>
          </div>
        `;
        return;
      }
      
      grid.innerHTML = layoutState.images.map(media => {
        const isVideo = String(media.type).toLowerCase()==='video';
        const src = fileUrl(media.file_path);
        if(!isVideo){
          return `
            <div class="image-card" onclick="selectImage(${media.id})">
              <img src="${src}" alt="${escapeHtml(media.name)}" class="image-card-img"/>
              <div class="image-card-body">
                <h6 class="image-card-title">${escapeHtml(media.name)}</h6>
              </div>
            </div>`;
        }
        const thumb = videoThumb(src);
        const content = thumb
          ? `<img src="${thumb}" alt="${escapeHtml(media.name)}" class="image-card-img"/>`
          : `<div class="image-card-img d-flex align-items-center justify-content-center" style="background:#f5f5f5;color:#666;font-size:48px;"><i class=\"bi bi-play-btn\"></i></div>`;
        return `
          <div class="image-card" onclick="selectImage(${media.id})">
            <div class="position-relative">
              ${content}
              <span class="badge bg-dark position-absolute" style="top:8px; left:8px; opacity:0.85;">Video</span>
              <button class="btn btn-sm btn-light position-absolute" style="top:8px; right:8px;" onclick="previewMedia(event, ${media.id})" title="Preview">
                <i class="bi bi-play-circle"></i>
              </button>
            </div>
            <div class="image-card-body">
              <h6 class="image-card-title">${escapeHtml(media.name)}</h6>
            </div>
          </div>`;
      }).join('');
    }

    function selectImage(imageId) {
      const image = layoutState.images.find(img => img.id === imageId);
      if (!image) return;
      
      // Check if this is background mode (from upload area)
      if (layoutState.isBackgroundMode) {
        // Update the landing page background
        updateLandingBackground(image);
        layoutState.isBackgroundMode = false;
      } else if (layoutState.selectedBox) {
        // Normal layout box selection
        layoutState.layoutBoxes[layoutState.selectedBox] = image;
        updateLayoutBox(layoutState.selectedBox, image);
      }
      
      closeImageSelector();
    }

    function updateLandingBackground(image) {
      // Send AJAX request to save background image
      fetch('/api/layout/background', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({
          background_image_id: image.id
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          toast(`Background "${image.name}" berhasil disimpan`, 'success');
          updateBackgroundPreview(image);
        } else {
          toast(data.message || 'Gagal menyimpan background', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        toast('Terjadi kesalahan saat menyimpan background', 'error');
      });
    }

    function clearBackground() {
      // Clear preview immediately for better UX
      clearBackgroundPreview();
      
      // Send AJAX request to clear background image
      fetch('/api/layout/background', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({
          background_image_id: null
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          toast('Background berhasil dihapus', 'success');
          closeImageSelector();
        } else {
          toast(data.message || 'Gagal menghapus background', 'error');
          // If API fails, we might want to restore the preview
          // But for now, keep it cleared since user wanted to delete
        }
      })
      .catch(error => {
        console.error('Error:', error);
        toast('Terjadi kesalahan saat menghapus background', 'error');
      });
    }

    function updateBackgroundPreview(image) {
      const preview = document.getElementById('backgroundPreview');
      const previewImg = document.getElementById('backgroundPreviewImg');
      const previewName = document.getElementById('backgroundPreviewName');
      const uploadIcon = document.getElementById('backgroundUploadIcon');
      const uploadText = document.getElementById('backgroundUploadText');
      const uploadSubtitle = document.getElementById('backgroundUploadSubtitle');
      
      if (preview && previewImg && previewName) {
        previewImg.src = fileUrl(image.file_path);
        previewName.textContent = image.name;
        preview.style.display = 'block';
        
        // Hide upload elements
        if (uploadIcon) uploadIcon.style.display = 'none';
        if (uploadText) uploadText.style.display = 'none';
        if (uploadSubtitle) uploadSubtitle.style.display = 'none';
      }
    }

    function clearBackgroundPreview() {
      const preview = document.getElementById('backgroundPreview');
      const uploadIcon = document.getElementById('backgroundUploadIcon');
      const uploadText = document.getElementById('backgroundUploadText');
      const uploadSubtitle = document.getElementById('backgroundUploadSubtitle');
      
      if (preview) preview.style.display = 'none';
      
      // Show upload elements
      if (uploadIcon) uploadIcon.style.display = 'block';
      if (uploadText) uploadText.style.display = 'block';
      if (uploadSubtitle) uploadSubtitle.style.display = 'block';
    }

    function updateLayoutBox(position, image) {
      const box = document.querySelector(`[data-position="${position}"]`);
      if (!box) return;
      
      box.classList.add('has-image');
      const isVideo = String(image.type).toLowerCase()==='video';
      if(!isVideo){
        box.innerHTML = `
          <div class="layout-box-number">${position}</div>
          <div class="layout-box-remove" onclick="removeImageFromBox(${position}, event)">
            <i class="bi bi-x"></i>
          </div>
          <img src="${fileUrl(image.file_path)}" alt="${escapeHtml(image.name)}" class="layout-box-image">
        `;
        return;
      }
      const src = fileUrl(image.file_path);
      const isYouTube = src.includes('youtube.com') || src.includes('youtu.be');
      
      let content;
      if (isYouTube) {
        // Extract YouTube video ID
        const videoId = src.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/)?.[1];
        if (videoId) {
          content = `
            <div class="video-overlay">
              <i class="bi bi-play-circle"></i>
              YouTube
            </div>
            <iframe 
              src="https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&loop=1&playlist=${videoId}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1" 
              title="${escapeHtml(image.name)}"
              frameborder="0" 
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
              allowfullscreen
              class="layout-box-image youtube-video">
            </iframe>
          `;
        } else {
          content = `<div class="layout-box-image d-flex align-items-center justify-content-center" style="background:#000;color:#fff;"><i class="bi bi-play-btn" style="font-size:48px;"></i></div>`;
        }
      } else {
        // Local video
        const thumb = videoThumb(src);
        content = thumb
          ? `<video autoplay muted loop class="layout-box-image"><source src="${src}" type="video/mp4"></video>`
          : `<div class="layout-box-image d-flex align-items-center justify-content-center" style="background:#000;color:#fff;"><i class="bi bi-play-btn" style="font-size:48px;"></i></div>`;
      }
      
      box.innerHTML = `
        <div class="layout-box-number">${position}</div>
        <div class="layout-box-remove" onclick="removeImageFromBox(${position}, event)">
          <i class="bi bi-x"></i>
        </div>
        ${content}
      `;
    }

    function removeImageFromBox(position, event) {
      event.stopPropagation();
      
      delete layoutState.layoutBoxes[position];
      
      const box = document.querySelector(`[data-position="${position}"]`);
      if (box) {
        box.classList.remove('has-image');
        box.innerHTML = `
          <div class="layout-box-number">${position}</div>
          <div class="layout-box-placeholder">Klik untuk pilih media</div>
        `;
      }
    }

    function previewLayout() {
      const description = document.getElementById('layoutDescription')?.value || '';
      const layoutImages = Object.values(layoutState.layoutBoxes);
      
      // Allow preview even without images
      toast('Membuka preview landing page...', 'success');
      
      // Open landing page in new tab for preview
      window.open('{{ url("/") }}', '_blank');
    }

    async function saveLayoutChanges() {
      try {
        const description = document.getElementById('layoutDescription')?.value || '';
        const layoutData = {
          description: description,
          images: Object.entries(layoutState.layoutBoxes).map(([position, image]) => ({
            position: parseInt(position),
            image_id: image.id,
            order: parseInt(position)
          }))
        };
        
        // Allow saving even without images
        if (layoutData.images.length === 0) {
          toast('Menyimpan layout tanpa media...', 'info');
        }
        
        const response = await fetch('/api/layout/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(layoutData)
        });
        
        const result = await response.json();
        
        if (result.success) {
          const message = layoutData.images.length === 0 
            ? 'Layout berhasil disimpan (tanpa media)!' 
            : 'Layout berhasil disimpan dan diterapkan ke landing page!';
          toast(message);
          setTimeout(() => {
            window.location.href = '{{ route("dashboard.pegawai") }}';
          }, 2000);
        } else {
          throw new Error(result.message || 'Gagal menyimpan layout');
        }
      } catch (error) {
        console.error('Error saving layout:', error);
        toast('Terjadi kesalahan saat menyimpan layout', 'error');
      }
    }

    function fileUrl(path) {
      let p = String(path || '');
      if (/^(?:https?:)?\/\//i.test(p)) return p; // keep absolute URL (YouTube/CDN)
      p = p.replace(/^\/+/, '');
      p = p.replace(/^public\//, '');
      return `${window.location.origin}/storage/${p}`;
    }

    function isYouTube(url){
      return /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)/i.test(String(url||''));
    }
    function youtubeId(url){
      const m = String(url||'').match(/(?:youtube\.com\/.*[?&]v=|youtu\.be\/)([\w-]{11})/i); return m?m[1]:null;
    }
    function videoThumb(url){
      if(isYouTube(url)){
        const id = youtubeId(url); if(id) return `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
      }
      return null; // fallback handled by caller
    }

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    function toast(message, type = 'success') {
      const colors = {
        'success': '#1f9e76',
        'error': '#dc3545',
        'info': '#0071BC',
        'warning': '#F7931E'
      };
      
      Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: 'top',
        position: 'right',
        backgroundColor: colors[type] || colors.success,
      }).showToast();
    }

    // Media Preview for Layout Manager (image + video)
    const lmPreview = {
      modalEl: null,
      container: null,
      bsModal: null,
      init(){
        this.modalEl = document.getElementById('lmMediaPreviewModal');
        this.container = document.getElementById('lmMediaPreviewContainer');
        if(this.modalEl){ this.bsModal = new bootstrap.Modal(this.modalEl); }
        if(this.modalEl){
          this.modalEl.addEventListener('hidden.bs.modal', ()=>{
            if(this.container) this.container.innerHTML = '';
          });
        }
      },
      open(media){
        if(!this.bsModal || !this.container) return;
        const src = fileUrl(media.file_path);
        const name = escapeHtml(media.name || '');
        let html = '';
        const isVid = String(media.type).toLowerCase()==='video';
        if(!isVid){
          html = `<img src="${src}" alt="${name}" style="max-width:100%; max-height:85vh; object-fit:contain;"/>`;
        } else {
          const yt = isYouTube(src) ? youtubeId(src) : null;
          if(yt){
            html = `<div class="ratio ratio-16x9" style="width:100%; max-width:1000px;"><iframe src="https://www.youtube.com/embed/${yt}?autoplay=1" title="${name}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
          } else {
            html = `<video controls autoplay playsinline style="width:100%; max-width:1000px; max-height:85vh;"><source src="${src}">Browser Anda tidak mendukung pemutar video.</video>`;
          }
        }
        this.container.innerHTML = html;
        this.bsModal.show();
      }
    };

    function previewMedia(e, id){
      e.stopPropagation();
      const m = layoutState.images.find(x=>x.id===id);
      if(!m){ return; }
      if(!lmPreview.bsModal){ lmPreview.init(); }
      lmPreview.open(m);
    }

    // Preview media in layout boxes
    function previewLayoutMedia(e, position) {
      e.stopPropagation();
      const box = document.querySelector(`[data-position="${position}"]`);
      if (!box) return;
      
      const mediaType = box.getAttribute('data-media-type');
      const mediaPath = box.getAttribute('data-media-path');
      const mediaName = box.getAttribute('data-media-name');
      const isYouTube = box.getAttribute('data-youtube-id');
      
      if (mediaType && mediaPath) {
        if (!lmPreview.bsModal) { lmPreview.init(); }
        
        const media = {
          type: mediaType,
          file_path: mediaPath,
          name: mediaName
        };
        
        lmPreview.open(media);
      }
    }

    // Close modal when clicking outside
    document.getElementById('imageSelectorModal').addEventListener('click', (e) => {
      if (e.target.id === 'imageSelectorModal') {
        closeImageSelector();
      }
    });
  </script>
</body>
</html>
