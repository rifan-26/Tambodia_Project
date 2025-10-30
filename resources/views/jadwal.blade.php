 <!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('components.sweetalert2')
  @include('components.global-audio-system')
  @include('components.confirm-delete-modal')
  <title>Jadwal Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('js/layout-management.js') }}"></script>
  <script src="{{ asset('js/schedule-management.js') }}"></script>
</head>

<style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden;
      height: 100vh;
      opacity: 0;
      animation: pageLoad 0.6s ease-out forwards;
    }

    /* Page Load Animation */
    @keyframes pageLoad {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Fade In Up Animation */
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

    /* Slide In Left Animation */
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

    /* Slide In Right Animation */
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

    /* Scale In Animation */
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

    /* Smooth transitions for all interactive elements */
    * {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Force dropdown to appear below select element */
    #namaFile {
      position: relative !important;
      z-index: 1 !important;
    }

    /* Ensure dropdown options appear below */
    #namaFile option {
      position: relative;
      z-index: 2;
    }

    /* Fix for Bootstrap select dropdown positioning */
    .form-section {
      position: relative;
      z-index: auto;
      overflow: visible;
    }

    /* Ensure dropdown menu appears below the select */
    select.form-select {
      position: relative;
      z-index: 1;
    }

    select.form-select:focus {
      z-index: 2;
    }

    /* Page transition overlay */
    .page-transition {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, #1f9e76, #58cbaa);
      z-index: 9999;
      opacity: 0;
      visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.4s ease;
    }

    .page-transition.active {
      opacity: 1;
      visibility: visible;
    }

    .transition-content {
      text-align: center;
      color: white;
    }

    .transition-spinner {
      width: 50px;
      height: 50px;
      border: 3px solid rgba(255,255,255,0.3);
      border-top: 3px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto 1rem;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

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
      z-index: 1000;
      overflow-y: auto;
      overflow-x: hidden;
      animation: slideInLeft 0.6s cubic-bezier(0.4, 0, 0.2, 1);
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

    .tam {
        color: #0084d6;
    }

    .bo {
        color: #a0d5d2;
    }

    .dia {
        color: #1f9e76;
    }

    .sidebar-content {
      flex: 1;
      overflow-y: auto;
      padding: 1rem 0;
      max-height: calc(100vh - 120px);
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
    .bi {
      font-size: 1.2rem;
    }
    
    .content-area {
      flex: 1;
      margin-left: 250px;
      padding: 1.25rem 1.5rem 1.5rem 1.5rem;
      min-height: 100vh;
      background: linear-gradient(90deg, #ffffff, #e9edfa);
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      position: relative;
      overflow-y: auto;
      overflow-x: hidden;
    }
    
    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      user-select: none;
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s both;
    }
    
    .header-top h2 {
      margin: 0;
      font-weight: 600;
      font-size: 1.25rem;
      color: #2c3a67;
    }
    
    .user-badge {
      background: linear-gradient(90deg, #58cbaa, #7cb8f4);
      padding: 0.3rem 0.85rem;
      border-radius: 2rem;
      color: white;
      font-weight: 600;
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
      user-select: none;
      animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    }
    
    .user-badge .status-indicator {
      width: 16px;
      height: 16px;
      background-color: #44d69e;
      border-radius: 50%;
      box-shadow: 0 0 6px #44d69eaa;
    }

    .content-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
      border: 1px solid #e9ecef;
      padding: 0.75rem;
      overflow: hidden;
      transition: all 0.3s ease;
      animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
    }

    .content-card:hover {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    }

    .content-card h5 {
      font-weight: 600;
      margin-bottom: 0.7rem;
      color: #2c3a67;
      font-size: 1.05rem;
      border-bottom: 2px solid #1f9e76;
      padding-bottom: 0.4rem;
      display: inline-block;
    }

    .form-section {
      margin-bottom: 0.6rem;
    }

    .form-label {
      font-weight: 500;
      color: #405672;
      margin-bottom: 0.35rem;
      font-size: 0.875rem;
    }

    .form-control, .form-select {
      border-radius: 6px;
      border: 1px solid #d1d5db;
      padding: 0.5rem 0.75rem;
      font-size: 0.875rem;
      transition: all 0.2s ease;
      background-color: #fff;
      line-height: 1.5;
    }

    .form-control:focus, .form-select:focus {
      outline: none;
      border-color: #1f9e76;
      box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1);
    }

    .form-control[readonly] {
      background-color: #f8f9fa;
      border-color: #e9ecef;
    }

    .search-container {
      position: relative;
      margin-bottom: 0.6rem;
    }

    .search-icon {
      position: absolute;
      left: 0.65rem;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 0.85rem;
    }

    .search-input {
      padding-left: 2.3rem !important;
      background-color: #f9fafb;
    }

    .table-container {
      border-radius: 8px;
      overflow-x: auto;
      overflow-y: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      border: 1px solid #e9ecef;
    }

    /* Scrollable table for media selection */
    .table-container.scrollable {
      max-height: 400px;
      overflow-y: auto;
      overflow-x: hidden;
      position: relative;
    }

    .table-container.scrollable::after {
      content: '';
      position: sticky;
      bottom: 0;
      left: 0;
      right: 0;
      height: 8px;
      background: linear-gradient(to top, rgba(233,236,239,0.5), transparent);
      pointer-events: none;
      z-index: 5;
    }

    .table-container.scrollable table {
      position: relative;
    }

    .table-container.scrollable thead {
      position: sticky;
      top: 0;
      z-index: 10;
      box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    /* Custom scrollbar for table */
    .table-container.scrollable::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    .table-container.scrollable::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }

    .table-container.scrollable::-webkit-scrollbar-thumb {
      background: #1f9e76;
      border-radius: 4px;
    }

    .table-container.scrollable::-webkit-scrollbar-thumb:hover {
      background: #16a085;
    }
    table {
      width: 100%;
      min-width: 600px;
      border-collapse: collapse;
      background-color: #ffffff;
      margin: 0;
    }

    /* Media selection table - full width, no horizontal scroll */
    .media-selection-table {
      width: 100%;
      min-width: 100%;
      table-layout: fixed;
    }

    thead {
      background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    }
    thead th {
      padding: 0.5rem 0.85rem;
      font-weight: 600;
      font-size: 0.875rem;
      text-align: left;
      color: #4c4f69;
      border-bottom: 2px solid #c7d2fe;
      white-space: nowrap;
      line-height: 1.4;
    }

    tbody td {
      padding: 0.5rem 0.85rem;
      font-size: 0.875rem;
      color: #5c5f77;
      border-bottom: 1px solid #e9ecef;
      vertical-align: middle;
      line-height: 1.5;
    }
    
    /* Media Selection Table - Column Widths */
    .media-selection-table th:nth-child(1),
    .media-selection-table td:nth-child(1) {
      width: 8%;
      text-align: center;
    }

    .media-selection-table th:nth-child(2),
    .media-selection-table td:nth-child(2) {
      width: 60%;
    }

    .media-selection-table th:nth-child(3),
    .media-selection-table td:nth-child(3) {
      width: 32%;
    }

    /* Allow text wrapping for media names */
    .media-selection-table tbody td:nth-child(2) {
      white-space: normal;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }
    
    .media-selection-table tbody td:nth-child(2) > div {
      max-width: 100%;
      overflow: visible;
    }
    
    /* Keep other columns nowrap */
    .media-selection-table tbody td:not(:nth-child(2)) {
      white-space: nowrap;
    }

    /* Specific column widths for better layout - Scheduled Media Table */
    #scheduledTable th:nth-child(1),
    #scheduledTable td:nth-child(1) { 
      width: 35%; /* Media Name */
    }
    
    #scheduledTable th:nth-child(2),
    #scheduledTable td:nth-child(2) { 
      width: 18%; /* Tanggal */
    }
    
    #scheduledTable th:nth-child(3),
    #scheduledTable td:nth-child(3) { 
      width: 15%; /* Hari */
    }
    
    #scheduledTable th:nth-child(4),
    #scheduledTable td:nth-child(4) { 
      width: 17%; /* Posisi */
    }
    #scheduledTable th:nth-child(5),
    #scheduledTable td:nth-child(5) { 
      width: 15%; /* Aksi */
    }

    tbody tr {
      transition: all 0.2s ease;
    }

    tbody tr:hover {
      background-color: #f8fafc;
      transform: translateY(-1px);
    }

    tbody tr:last-child td {
      border-bottom: none;
    }

    .icon-cell {
      width: 60px;
      text-align: center;
    }

    .checkbox-custom {
      width: 18px;
      height: 18px;
      accent-color: #1f9e76;
      cursor: pointer;
    }

    /* Button Styling */
    .button-section {
      display: flex;
      justify-content: flex-end;
      gap: 0.4rem;
      margin-top: 0.75rem;
      padding-top: 0.6rem;
      border-top: 1px solid #e9ecef;
    }

    .btn {
      padding: 0.5rem 1.1rem;
      border-radius: 6px;
      font-weight: 500;
      font-size: 0.875rem;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
    }

    .btn-success {
      background: linear-gradient(135deg, #1f9e76 0%, #16a085 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(31, 158, 118, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(31, 158, 118, 0.4);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }

    /* Badge Styling - Compact */
    .badge {
      padding: 0.3rem 0.6rem;
      font-size: 0.8rem;
      font-weight: 500;
    }

    /* Compact spacing for cards */
    .col-12.mb-4 {
      margin-bottom: 0.5rem !important;
    }

    .row.g-4 {
      gap: 0.5rem !important;
    }

    /* Compact button groups */
    .btn-group-sm .btn {
      padding: 0.35rem 0.6rem;
      font-size: 0.8rem;
    }

    .btn-group {
      gap: 0.25rem;
    }

    /* Compact icons in headers */
    .content-card h5 i,
    thead th i {
      font-size: 0.9rem;
      margin-right: 0.3rem;
    }

    /* Compact icons in table cells */
    tbody td i {
      font-size: 1rem;
    }

    /* Smaller gap in d-flex */
    tbody .d-flex.gap-2 {
      gap: 0.5rem !important;
    }

    tbody .d-flex.align-items-center {
      line-height: 1.3;
    }

    /* Smaller text in cells */
    tbody small {
      font-size: 0.75rem;
    }

    /* Toggle Button Group Styling */
    .btn-group .btn-outline-primary {
      border-color: #1f9e76;
      color: #1f9e76;
      font-size: 0.85rem;
      padding: 0.4rem 0.85rem;
    }

    .btn-group .btn-outline-primary:hover {
      background-color: #e8f5f0;
      border-color: #1f9e76;
      color: #1f9e76;
    }

    .btn-group .btn-outline-primary.active {
      background: linear-gradient(135deg, #1f9e76 0%, #16a085 100%);
      border-color: #1f9e76;
      color: white;
    }

    .btn-group .btn-outline-primary.active:hover {
      background: linear-gradient(135deg, #16a085 0%, #1f9e76 100%);
    }

    /* Subsection heading */
    h6 {
      font-size: 0.95rem !important;
      font-weight: 600 !important;
    }

    /* Layout Preview Styles - Mirip Layout Asli */
    .layout-preview-container {
      border: 2px dashed #d1d5db;
      border-radius: 8px;
      padding: 1rem;
      background-color: #f8f9fa;
      min-height: 220px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .layout-preview-container.has-preview {
      border-color: #1f9e76;
      background-color: #f0f9f0;
    }

    .layout-preview {
      width: 100%;
      max-width: 280px;
      height: 200px;
      position: relative;
      background: rgba(11, 11, 11, 0.9);
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      overflow: hidden;
      padding: 8px;
    }

    /* Grid Layout Preview - Sesuai Layout Asli */
    .preview-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: repeat(4, 1fr);
      gap: 4px;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
      border-radius: 4px;
      padding: 4px;
    }

    .preview-grid-item {
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 8px;
      color: rgba(255, 255, 255, 0.7);
      font-weight: 600;
      position: relative;
      transition: all 0.3s ease;
      backdrop-filter: blur(4px);
    }

    .preview-grid-item.active {
      background: linear-gradient(135deg, #1f9e76 0%, #16a085 100%);
      color: white;
      border-color: #1f9e76;
      box-shadow: 0 0 12px rgba(31, 158, 118, 0.6);
      transform: scale(1.05);
    }

    /* Position specific styling - Sesuai Layout Asli */
    .preview-grid-item:nth-child(1) { 
      grid-column: 1; 
      grid-row: 1; 
    }
    
    .preview-grid-item:nth-child(2) { 
      grid-column: 2; 
      grid-row: 1 / 3; 
    }
    
    .preview-grid-item:nth-child(3) { 
      grid-column: 1; 
      grid-row: 2 / 4; 
    }
    
    .preview-grid-item:nth-child(4) { 
      grid-column: 2; 
      grid-row: 3; 
    }
    
    .preview-grid-item:nth-child(5) { 
      grid-column: 1; 
      grid-row: 4; 
    }
    
    .preview-grid-item:nth-child(6) { 
      grid-column: 2; 
      grid-row: 4; 
    }

    /* Label untuk setiap posisi */
    .preview-position-label {
      position: absolute;
      top: 2px;
      left: 2px;
      background: rgba(0,0,0,0.8);
      color: white;
      font-size: 7px;
      padding: 1px 3px;
      border-radius: 2px;
      font-weight: bold;
    }

    .preview-grid-item.active .preview-position-label {
      background: rgba(255,255,255,0.9);
      color: #1f9e76;
    }

    .preview-empty {
      color: #6c757d;
      font-style: italic;
      text-align: center;
    }

    .form-check {
      padding: 0.75rem;
      background-color: #f8f9fa;
      border-radius: 8px;
      border: 1px solid #e9ecef;
      transition: all 0.2s ease;
    }

    .form-check:hover {
      background-color: #e9ecef;
    }

    .form-check-input:checked {
      background-color: #1f9e76;
      border-color: #1f9e76;
    }

    .form-check-label {
      margin-bottom: 0;
      cursor: pointer;
      font-weight: 500;
    }

    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
      color: #6c757d;
    }

    .empty-state i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    /* Layout Status Styles */
    .layout-status-container {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 1rem;
    }

    .current-layout-preview {
      background: rgba(11, 11, 11, 0.9);
      border-radius: 8px;
      padding: 8px;
      margin-bottom: 1rem;
    }

    .preview-grid-status {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: repeat(3, 1fr);
      gap: 8px;
      max-width: 100%;
      background: #ffffff;
      border-radius: 8px;
      padding: 16px;
      border: 1px solid #e9ecef;
    }

    .preview-grid-item-status {
      background: #f8f9fa;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 80px;
      padding: 12px 8px;
      text-align: center;
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .preview-grid-item-status.occupied {
      background: linear-gradient(135deg, #1f9e76 0%, #16a085 100%);
      color: white;
      border-color: #1f9e76;
      box-shadow: 0 0 12px rgba(31, 158, 118, 0.6);
    }

    .preview-grid-item-status.scheduled {
      background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
      color: white;
      border-color: #ffc107;
      box-shadow: 0 0 12px rgba(255, 193, 7, 0.6);
    }

    /* Position specific styling for status grid */
    .preview-grid-item-status:nth-child(1) { 
      grid-column: 1; 
      grid-row: 1; 
    }
    
    .preview-grid-item-status:nth-child(2) { 
      grid-column: 2; 
      grid-row: 1; 
    }
    
    .preview-grid-item-status:nth-child(3) { 
      grid-column: 1; 
      grid-row: 2; 
    }
    
    .preview-grid-item-status:nth-child(4) { 
      grid-column: 2; 
      grid-row: 2; 
    }
    
    .preview-grid-item-status:nth-child(5) { 
      grid-column: 1; 
      grid-row: 3; 
    }
    
    .preview-grid-item-status:nth-child(6) { 
      grid-column: 2; 
      grid-row: 3; 
    }

    .position-info {
      text-align: center;
      line-height: 1.1;
      margin-top: 2px;
    }

    .position-type {
      font-size: 7px;
      font-weight: bold;
      margin-bottom: 1px;
    }

    .position-status {
      font-size: 6px;
      opacity: 0.9;
    }

    .layout-legend h6 {
      color: #2c3a67;
      font-size: 0.9rem;
    }

    /* Background & Description Management Styles */
    .background-preview-container {
      border: 2px solid #e9ecef;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      background: #f8f9fa;
      transition: all 0.3s ease;
    }

    .preview-grid-item-status {
      border: 2px solid #e9ecef;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      background: #f8f9fa;
      transition: all 0.3s ease;
    }

    .preview-grid-item-status.filled {
      border-color: #20c997;
      background: #e8f5f0;
    }

    .preview-grid-item-status.empty {
      border-color: #dee2e6;
      background: #f8f9fa;
    }

    .position-status.filled {
      color: #0f5132;
      font-weight: 500;
      font-size: 0.75rem;
      line-height: 1.2;
      word-break: break-word;
    }

    .position-status.empty {
      color: #6c757d;
      font-size: 0.75rem;
      line-height: 1.2;
    }

    .position-status span {
      display: block;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .preview-position-label {
      font-weight: 600;
      font-size: 1rem;
      color: #495057;
      margin-bottom: 4px;
    }

    .position-type {
      font-size: 0.7rem;
      color: #6c757d;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      margin-bottom: 4px;
    }

    .background-preview-container.has-preview {
      border-color: #1f9e76;
      background: #fff;
    }

    .background-preview-container img {
      max-width: 100%;
      max-height: 180px;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .background-preview-container video {
      max-width: 100%;
      max-height: 180px;
      border-radius: 4px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .current-settings-container {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
      border: 1px solid #dee2e6;
    }

    .current-setting-item {
      margin-bottom: 10px;
    }

    .current-setting-item:last-child {
      margin-bottom: 0;
    }

    #descriptionCharCount {
      font-weight: 500;
    }
</style>

<body>
  <!-- Page Transition Overlay -->
  <div class="page-transition" id="pageTransition">
    <div class="transition-content">
      <div class="transition-spinner"></div>
      <p>Loading...</p>
    </div>
  </div>

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
          <a class="nav-link active" href="{{ route('schedule.index') }}">
            <i class="bi bi-calendar-event"></i> <span>Penjadwalan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('layout') }}">
            <i class="bi bi-grid-3x3"></i> <span>Master Layout</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('staff.index') }}">
            <i class="bi bi-people"></i> <span>Master Profil</span>
          </a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
            @csrf
          </form>
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> <span>Log Out</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <main class="content-area">
    <div class="header-top">
      <h2 class="section-header">Penjadwalan Media & Pengaturan Layout</h2>
      <div class="user-badge" title="Logged in">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ Auth::user()->name ?? 'User' }}</span>
      </div>
    </div>
    
    <div class="container-fluid">
      <!-- Single Section - Penjadwalan Media -->
      <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Penjadwalan Media</h5>
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-primary active" id="btnShowScheduled">
              <i class="bi bi-list-check"></i> Terjadwal
            </button>
            <button type="button" class="btn btn-outline-primary" id="btnShowMedia">
              <i class="bi bi-plus-circle"></i> Tambah Jadwal
            </button>
          </div>
        </div>

        <!-- Tabel Media yang Sudah Dijadwalkan -->
        <div id="scheduledSection">
          <div class="table-container scrollable">
            <table id="scheduledTable">
                <thead>
                  <tr>
                    <th><i class="bi bi-file-earmark me-2"></i>Nama Media</th>
                    <th><i class="bi bi-calendar-event me-2"></i>Tanggal</th>
                    <th><i class="bi bi-calendar-week me-2"></i>Hari</th>
                    <th><i class="bi bi-grid-3x3-gap me-2"></i>Posisi</th>
                    <th><i class="bi bi-gear me-2"></i>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($media) && $media->count() > 0)
                    @foreach($media as $item)
                      @if($item->schedules && $item->schedules->count() > 0)
                        @foreach($item->schedules as $schedule)
                        <tr data-schedule-id="{{ $schedule->id }}" data-media-id="{{ $item->id }}">
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              @if($item->type === 'Audio')
                                <i class="bi bi-music-note-beamed text-info"></i>
                              @elseif($item->type === 'Video')
                                <i class="bi bi-play-circle text-danger"></i>
                              @else
                                <i class="bi bi-image text-success"></i>
                              @endif
                              <div style="overflow: hidden; max-width: 250px;">
                                <div style="word-break: break-word;" title="{{ $item->name }}">{{ $item->name }}</div>
                                <small class="text-muted">{{ $item->type }}</small>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div>{{ $schedule->start_date->format('d/m/Y') }}</div>
                            @if($schedule->time)
                              <small class="text-muted">{{ $schedule->time->format('H:i') }}</small>
                            @endif
                          </td>
                          <td>
                            @if($schedule->day_of_week)
                              <span class="badge bg-secondary">{{ ucfirst($schedule->day_of_week) }}</span>
                            @else
                              <span class="text-muted">Semua</span>
                            @endif
                          </td>
                          <td>
                            @if($item->type === 'Audio')
                              <span class="badge bg-info">Audio</span>
                            @else
                              @if($schedule->layout_position)
                                <span class="badge bg-primary">Posisi {{ $schedule->layout_position }}</span>
                              @else
                                <span class="badge bg-secondary">-</span>
                              @endif
                            @endif
                          </td>
                          <td>
                            <div class="btn-group btn-group-sm">
                              <button class="btn btn-outline-primary btn-sm" 
                                      onclick="editSchedule({{ $schedule->id }})" 
                                      title="Edit">
                                <i class="bi bi-pencil"></i>
                              </button>
                              <button class="btn btn-outline-danger btn-sm" 
                                      onclick="deleteSchedule({{ $schedule->id }}, '{{ addslashes($item->name) }}')" 
                                      title="Hapus">
                                <i class="bi bi-trash"></i>
                              </button>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      @endif
                    @endforeach
                  @else
                    <tr>
                      <td colspan="5" class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <div>Belum ada media yang dijadwalkan</div>
                        <small>Buat jadwal baru untuk media Anda</small>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Section Tambah Jadwal (Hidden by default) -->
        <div id="addScheduleSection" style="display: none;">
          <hr style="margin: 1rem 0; border-color: #e9ecef;">
          
          <div class="row">
            <!-- Tabel Pilih Media -->
            <div class="col-lg-5">
              <h6 class="mb-2" style="font-size: 0.85rem; font-weight: 600; color: #2c3a67;">
                <i class="bi bi-table me-1"></i>Pilih Media
              </h6>
              
              <div class="search-container">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control search-input" id="cariFile" placeholder="Cari media...">
              </div>
            
            <div class="table-container scrollable">
              <table class="media-selection-table">
                <thead>
                  <tr>
                    <th class="icon-cell"><i class="bi bi-check-square"></i></th>
                    <th><i class="bi bi-file-earmark me-2"></i>Nama Media</th>
                    <th><i class="bi bi-calendar-check me-2"></i>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($media) && $media->count() > 0)
                    @foreach($media as $item)
                    <tr data-id="{{ $item->id }}" class="media-row">
                      <td class="icon-cell">
                        <input type="checkbox" name="select_row" value="{{ $item->id }}" class="checkbox-custom" id="checkbox-{{ $item->id }}">
                      </td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          @if($item->type === 'Audio')
                            <i class="bi bi-music-note-beamed text-info"></i>
                          @elseif($item->type === 'Video')
                            <i class="bi bi-play-circle text-danger"></i>
                          @else
                            <i class="bi bi-image text-success"></i>
                          @endif
                          <div style="overflow: hidden;">
                            <div style="word-break: break-word;" title="{{ $item->name }}">{{ $item->name }}</div>
                            <small class="text-muted">{{ $item->type }}</small>
                          </div>
                        </div>
                      </td>
                      <td>
                        @if($item->schedules && $item->schedules->count() > 0)
                          @if($item->hasActiveSchedules())
                            <span class="badge bg-success">Aktif ({{ $item->schedules->count() }})</span>
                          @else
                            <span class="badge bg-warning text-dark">Terjadwal ({{ $item->schedules->count() }})</span>
                          @endif
                        @else
                          <span class="badge bg-secondary">Belum Dijadwal</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="3" class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <div>Tidak ada media yang tersedia</div>
                        <small>Silakan tambahkan media terlebih dahulu</small>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          
          <!-- Form Jadwal -->
          <div class="col-lg-7">
            <h6 class="mb-2" style="font-size: 0.85rem; font-weight: 600; color: #2c3a67;">
              <i class="bi bi-calendar-plus me-1"></i>Atur Jadwal
            </h6>
            
            <div id="alertContainer"></div>
            
            <form id="scheduleForm" action="{{ route('schedule.store') }}" method="POST">
              @csrf
              <input type="hidden" id="media_id" name="media_id">
              
              <div class="form-section">
                <label for="namaFile" class="form-label">Media Terpilih</label>
                <input type="text" class="form-control" id="namaFile" readonly placeholder="Pilih media dari tabel">
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <label for="start_date" class="form-label">Tanggal Mulai</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
              </div>
              
              <div class="form-section">
                <label for="day_of_week" class="form-label">Hari dalam Seminggu</label>
                <select class="form-select" id="day_of_week" name="day_of_week">
                  <option value="">Semua Hari</option>
                  <option value="senin">Senin</option>
                  <option value="selasa">Selasa</option>
                  <option value="rabu">Rabu</option>
                  <option value="kamis">Kamis</option>
                  <option value="jumat">Jumat</option>
                  <option value="sabtu">Sabtu</option>
                  <option value="minggu">Minggu</option>
                </select>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-section">
                    <label for="time" class="form-label">Waktu Tayang</label>
                    <input type="time" class="form-control" id="time" name="time">
                    <small class="form-text text-muted">Kosongkan untuk sepanjang hari</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-section">
                    <label for="end_date" class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                    <small class="form-text text-muted">Kosongkan jika permanen</small>
                  </div>
                </div>
              </div>

              <!-- Layout Position Section -->
              <div class="form-section" id="layoutPositionSection">
                <label for="layout_position" class="form-label">Posisi di Layout</label>
                <select class="form-select" id="layout_position" name="layout_position">
                  <option value="">Pilih Posisi Layout</option>
                  <option value="1">Posisi 1 - Kebijakan (Kiri)</option>
                  <option value="2">Posisi 2 - Sosialisasi (Kanan Atas)</option>
                  <option value="3">Posisi 3 - Gratifikasi (Kanan Bawah Kiri)</option>
                  <option value="4">Posisi 4 - Release (Kanan Bawah Kanan)</option>
                </select>
              </div>



            
              <div class="button-section">
                <button type="reset" class="btn btn-danger" id="resetButton">
                  <i class="bi bi-arrow-clockwise me-1"></i>Reset
                </button>
                <button type="submit" class="btn btn-success" id="submitButton">
                  <i class="bi bi-check-lg me-1"></i>Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  </main>




  <!-- Edit Schedule Modal -->
  <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editScheduleModalLabel">
            <i class="bi bi-pencil-square me-2"></i>Edit Jadwal Media
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editScheduleForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_schedule_id" name="schedule_id">
            
            <div class="form-section">
              <label for="edit_media_name" class="form-label">
                <i class="bi bi-file-earmark-text me-2"></i>Media
              </label>
              <input type="text" class="form-control" id="edit_media_name" readonly>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-section">
                  <label for="edit_start_date" class="form-label">
                    <i class="bi bi-calendar-event me-2"></i>Tanggal Mulai
                  </label>
                  <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-section">
                  <label for="edit_end_date" class="form-label">
                    <i class="bi bi-calendar-x me-2"></i>Tanggal Berakhir
                    <small class="text-muted ms-2">(Opsional)</small>
                  </label>
                  <input type="date" class="form-control" id="edit_end_date" name="end_date">
                  <small class="form-text text-muted">Kosongkan jika jadwal permanen</small>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-section">
                  <label for="edit_day_of_week" class="form-label">
                    <i class="bi bi-calendar-week me-2"></i>Hari dalam Seminggu
                  </label>
                  <select class="form-select" id="edit_day_of_week" name="day_of_week">
                    <option value="">Semua Hari</option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                    <option value="minggu">Minggu</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-section">
                  <label for="edit_time" class="form-label">
                    <i class="bi bi-clock me-2"></i>Waktu Tayang
                  </label>
                  <input type="time" class="form-control" id="edit_time" name="time">
                  <small class="form-text text-muted">Kosongkan untuk sepanjang hari</small>
                </div>
              </div>
            </div>
            
            <div class="form-section" id="editLayoutPositionSection">
              <label for="edit_layout_position" class="form-label">
                <i class="bi bi-grid-3x3-gap me-2"></i>Posisi di Layout
                <small class="text-muted ms-2">Pilih lokasi tampilan media di landing page</small>
              </label>
              <select class="form-select" id="edit_layout_position" name="layout_position">
                <option value="">Pilih Posisi Layout</option>
                <option value="1">Posisi 1 - Kebijakan (Kiri)</option>
                <option value="2">Posisi 2 - Sosialisasi (Kanan Atas)</option>
                <option value="3">Posisi 3 - Gratifikasi (Kanan Bawah Kiri)</option>
                <option value="4">Posisi 4 - Release (Kanan Bawah Kanan)</option>
              </select>
            </div>
            
            <!-- Layout Preview Section -->
            <div class="form-section" id="editLayoutPreview">
              <label class="form-label">
                <i class="bi bi-eye me-2"></i>Preview Posisi Layout
              </label>
              <div class="layout-preview-container" id="editLayoutPreviewContainer">
                <div class="preview-empty">Pilih posisi untuk melihat preview</div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-2"></i>Batal
          </button>
          <button type="button" class="btn btn-success" onclick="updateSchedule()">
            <i class="bi bi-check-lg me-2"></i>Update Jadwal
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/jadwal.js') }}"></script>
  <script>

// Toggle between scheduled and add schedule sections
document.getElementById('btnShowScheduled').addEventListener('click', function() {
    document.getElementById('scheduledSection').style.display = 'block';
    document.getElementById('addScheduleSection').style.display = 'none';
    this.classList.add('active');
    document.getElementById('btnShowMedia').classList.remove('active');
});

document.getElementById('btnShowMedia').addEventListener('click', function() {
    document.getElementById('scheduledSection').style.display = 'none';
    document.getElementById('addScheduleSection').style.display = 'block';
    this.classList.add('active');
    document.getElementById('btnShowScheduled').classList.remove('active');
});

// Landing Page Preview Functions
function refreshPreview() {
    const iframe = document.getElementById('landingPreview');
    const loader = document.getElementById('previewLoader');
    
    if (iframe && loader) {
        loader.style.display = 'flex';
        iframe.src = iframe.src; // Force reload
    }
}

function openLandingInNewTab() {
    window.open('{{ url("/") }}', '_blank');
}

function handlePreviewLoad() {
    const loader = document.getElementById('previewLoader');
    if (loader) {
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    }
}

// Auto-refresh preview when schedule changes
function autoRefreshPreview() {
    setTimeout(() => {
        refreshPreview();
    }, 1000);
}

// Function to select media by checkbox click
function selectMediaByCheckbox(mediaId, mediaName, mediaType) {
    console.log('selectMediaByCheckbox called:', mediaId, mediaName, mediaType);
    
    // Clear all other checkboxes first (only one selection allowed)
    const allCheckboxes = document.querySelectorAll('input[name="select_row"]');
    allCheckboxes.forEach(cb => {
        if (cb.value !== mediaId) {
            cb.checked = false;
        }
    });
    
    // Get form inputs - try multiple selectors
    let mediaIdInput = document.getElementById('media_id');
    let namaFileInput = document.getElementById('namaFile');
    
    // If not found, try alternative selectors
    if (!mediaIdInput) {
        mediaIdInput = document.querySelector('input[name="media_id"]');
    }
    if (!namaFileInput) {
        namaFileInput = document.querySelector('input[name="nama_file"]') || document.querySelector('#namaFile');
    }
    
    console.log('Form inputs found:', {
        mediaIdInput: mediaIdInput ? 'found' : 'not found',
        namaFileInput: namaFileInput ? 'found' : 'not found',
        mediaIdInputId: mediaIdInput ? mediaIdInput.id : 'no id',
        namaFileInputId: namaFileInput ? namaFileInput.id : 'no id'
    });
    
    // Log all available inputs for debugging
    const allInputs = document.querySelectorAll('input');
    console.log('All inputs on page:', Array.from(allInputs).map(input => ({
        id: input.id,
        name: input.name,
        type: input.type,
        placeholder: input.placeholder
    })));
    
    if (mediaIdInput && namaFileInput) {
        const checkbox = document.querySelector(`input[name="select_row"][value="${mediaId}"]`);
        
        if (checkbox && checkbox.checked) {
            // Media selected
            mediaIdInput.value = mediaId;
            namaFileInput.value = mediaName;
            
            console.log('Updated form fields:', {
                mediaId: mediaIdInput.value,
                namaFile: namaFileInput.value
            });
            
            // Update form fields based on media type
            updateFormFieldsForMediaType(mediaType);
            
            // Show success feedback
            showAlert('Media berhasil dipilih: ' + mediaName, 'success');
            
            // Highlight selected row
            const selectedRow = document.querySelector(`tr[data-id="${mediaId}"]`);
            if (selectedRow) {
                // Remove highlight from all rows
                document.querySelectorAll('.media-row').forEach(row => {
                    row.classList.remove('table-active');
                });
                // Add highlight to selected row
                selectedRow.classList.add('table-active');
            }
        } else {
            // Media deselected
            mediaIdInput.value = '';
            namaFileInput.value = '';
            updateFormFieldsForMediaType('');
            showAlert('Media selection cleared', 'info');
            
            // Remove highlight from all rows
            document.querySelectorAll('.media-row').forEach(row => {
                row.classList.remove('table-active');
            });
        }
    } else {
        console.error('❌ Form inputs not found');
        console.error('mediaIdInput:', mediaIdInput);
        console.error('namaFileInput:', namaFileInput);
        showAlert('Error: Form tidak ditemukan', 'error');
    }
}

// Function to select media by row click
function selectMediaByRow(row) {
    const mediaId = row.getAttribute('data-id');
    const checkbox = row.querySelector('input[name="select_row"]');
    const mediaNameElement = row.querySelector('div div:first-child');
    const mediaTypeElement = row.querySelector('small');
    
    console.log('selectMediaByRow called for ID:', mediaId);
    console.log('Found elements:', {checkbox, mediaNameElement, mediaTypeElement});
    
    if (mediaId && checkbox && mediaNameElement && mediaTypeElement) {
        const mediaName = mediaNameElement.textContent.trim();
        const mediaType = mediaTypeElement.textContent.trim();
        
        console.log('Extracted data:', {mediaId, mediaName, mediaType});
        
        // Toggle checkbox
        checkbox.checked = !checkbox.checked;
        
        // Trigger the checkbox function to handle the selection
        selectMediaByCheckbox(mediaId, mediaName, mediaType);
    } else {
        console.error('Missing required elements for media selection');
        showAlert('Error: Tidak dapat memilih media', 'error');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    console.log('DOM loaded, initializing media selection...');
    
    const searchInput = document.getElementById("cariFile");
    const tableRows = document.querySelectorAll("table tbody tr");
    const checkboxes = document.querySelectorAll('input[name="select_row"]');
    const mediaIdInput = document.getElementById('media_id');
    const namaFileInput = document.getElementById('namaFile');
    const scheduleForm = document.getElementById('scheduleForm');
    const layoutPositionSelect = document.getElementById('layout_position');
    
    console.log('Found elements:');
    console.log('- Checkboxes:', checkboxes.length);
    console.log('- Media ID input:', mediaIdInput);
    console.log('- Nama file input:', namaFileInput);
    console.log('- Schedule form:', scheduleForm);
    
    // Set today as default for date input
    const today = new Date().toISOString().split('T')[0];
    const startDateInput = document.getElementById('start_date');
    if (startDateInput) {
        startDateInput.value = today;
        console.log('Set start_date default value:', today);
    }

    // Initialize layout position section - hide by default
    const layoutPositionSection = document.getElementById('layoutPositionSection');
    if (layoutPositionSection) {
        layoutPositionSection.style.display = 'none';
        console.log('Layout position section hidden by default');
    }

    // Load current layout status on page load
    loadCurrentLayoutStatus();

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const keyword = searchInput.value.trim().toLowerCase();

            tableRows.forEach(row => {
                if (row.cells && row.cells.length > 1) {
                    const mediaName = row.cells[1].textContent.toLowerCase();
                    row.style.display = mediaName.includes(keyword) ? "" : "none";
                }
            });
        });
    }
    
    // Add click handlers to table rows for media selection
    const mediaRows = document.querySelectorAll('.media-selection-table tbody tr[data-id]');
    console.log('Found media rows:', mediaRows.length);
    
    // Also check for media-row class as backup
    const mediaRowsBackup = document.querySelectorAll('.media-row[data-id]');
    console.log('Found media-row elements:', mediaRowsBackup.length);
    
    const allMediaRows = mediaRows.length > 0 ? mediaRows : mediaRowsBackup;
    console.log('Using media rows:', allMediaRows.length);
    
    allMediaRows.forEach(row => {
        // Add click handler to row (but not to checkbox)
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on checkbox directly
            if (e.target.type !== 'checkbox') {
                console.log('Row clicked, calling selectMediaByRow');
                selectMediaByRow(this);
            }
        });
        
        // Add style for clickable rows
        row.style.cursor = 'pointer';
        row.title = 'Klik untuk memilih media';
    });
    
    // Handle checkbox changes directly
    const allCheckboxes = checkboxes.length > 0 ? checkboxes : document.querySelectorAll('input[name="select_row"]');
    console.log('Found checkboxes:', allCheckboxes.length);
    
    if (allCheckboxes.length > 0) {
        console.log('Setting up checkbox listeners...');
        
        allCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation(); // Prevent row click
                console.log('Checkbox changed:', this.value, this.checked);
                
                const mediaId = this.value;
                const row = this.closest('tr');
                const mediaNameElement = row.querySelector('div div:first-child') || row.querySelector('td:nth-child(2) div div:first-child');
                const mediaTypeElement = row.querySelector('small') || row.querySelector('td:nth-child(2) small');
                
                console.log('Found elements:', {
                    mediaNameElement: mediaNameElement ? mediaNameElement.textContent.trim() : 'not found',
                    mediaTypeElement: mediaTypeElement ? mediaTypeElement.textContent.trim() : 'not found'
                });
                
                if (mediaNameElement && mediaTypeElement) {
                    const mediaName = mediaNameElement.textContent.trim();
                    const mediaType = mediaTypeElement.textContent.trim();
                    
                    // Call selection function
                    selectMediaByCheckbox(mediaId, mediaName, mediaType);
                } else {
                    console.error('Could not find media name or type elements in row');
                }
            });
        });
    } else {
        console.warn('No checkboxes found!');
    }

    // Layout position change handler
    if (layoutPositionSelect) {
        layoutPositionSelect.addEventListener('change', function() {
            updateLayoutPreview(this.value);
        });
    }
    
    // Edit layout position change handler
    const editLayoutPositionSelect = document.getElementById('edit_layout_position');
    if (editLayoutPositionSelect) {
        editLayoutPositionSelect.addEventListener('change', function() {
            updateEditLayoutPreview(this.value);
        });
    }

    console.log('✅ Media selection initialization complete');
});

    // Function to load current layout status
    function loadCurrentLayoutStatus() {
        // Initialize position status
        const positionStatus = {
            1: { status: 'Kosong', mediaName: null, source: null },
            2: { status: 'Kosong', mediaName: null, source: null },
            3: { status: 'Kosong', mediaName: null, source: null },
            4: { status: 'Kosong', mediaName: null, source: null },
            5: { status: 'Kosong', mediaName: null, source: null },
            6: { status: 'Kosong', mediaName: null, source: null }
        };

        // First, check for scheduled media
        const scheduledRows = document.querySelectorAll('#scheduledTable tbody tr[data-schedule-id]');
        scheduledRows.forEach(row => {
            const positionCell = row.cells[5]; // Position column
            const mediaNameCell = row.cells[0]; // Media name column
            const statusCell = row.cells[6]; // Status column
            
            if (positionCell && mediaNameCell) {
                const positionBadges = positionCell.querySelectorAll('.badge');
                const mediaName = mediaNameCell.querySelector('span')?.textContent || '';
                const isActive = statusCell.querySelector('.badge.bg-success') !== null;
                
                positionBadges.forEach(badge => {
                    const position = parseInt(badge.textContent);
                    if (position >= 1 && position <= 6) {
                        positionStatus[position] = {
                            status: isActive ? 'Terjadwal' : 'Nonaktif',
                            mediaName: mediaName,
                            source: 'schedule'
                        };
                    }
                });
            }
        });

        // Then, check for default layout media (show_on_landing = true)
        // Make AJAX call to get current default layout media
        fetch('/api/layout/current-status', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.defaultMedia) {
                // Process default layout media
                data.defaultMedia.forEach(media => {
                    const position = media.layout_order;
                    if (position >= 1 && position <= 6) {
                        // Only set if position is not already occupied by scheduled media
                        if (positionStatus[position].status === 'Kosong') {
                            positionStatus[position] = {
                                status: 'Default Layout',
                                mediaName: media.name,
                                source: 'default'
                            };
                        }
                    }
                });
            }
            
            // Update the layout status display
            updateLayoutStatusDisplay(positionStatus);
        })
        .catch(error => {
            console.error('Error loading default layout status:', error);
            // Update display with scheduled media only
            updateLayoutStatusDisplay(positionStatus);
        });
    }

    // Function to update the layout status display
    function updateLayoutStatusDisplay(positionStatus) {
        for (let i = 1; i <= 4; i++) {
            const statusElement = document.getElementById(`status-${i}`);
            const gridItem = document.querySelector(`[data-position="${i}"]`);
            
            if (statusElement && gridItem) {
                const status = positionStatus[i];
                statusElement.textContent = status.status;
                
                // Update visual styling
                gridItem.classList.remove('occupied', 'scheduled');
                if (status.status === 'Terjadwal') {
                    gridItem.classList.add('scheduled');
                } else if (status.status === 'Default Layout') {
                    gridItem.classList.add('occupied');
                } else if (status.status !== 'Kosong') {
                    gridItem.classList.add('occupied');
                }
                
                // Add tooltip with media name if available
                if (status.mediaName) {
                    const sourceText = status.source === 'schedule' ? 'Terjadwal' : 'Default Layout';
                    gridItem.title = `${status.mediaName} - ${sourceText}`;
                } else {
                    gridItem.title = `Posisi ${i} - ${status.status}`;
                }
            }
        }
    }

// Function to show alert messages
function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        alertContainer.innerHTML = alertHTML;
        setTimeout(() => {
            alertContainer.innerHTML = '';
        }, 3000);
    }
}

// Function to update layout preview
function updateLayoutPreview(position) {
    const container = document.getElementById('layoutPreviewContainer');
    
    if (!container) return;
    
    if (!position) {
        container.className = 'layout-preview-container';
        container.innerHTML = '<div class="preview-empty">Pilih posisi untuk melihat preview</div>';
        return;
    }

    container.className = 'layout-preview-container has-preview';
    
    const positionLabels = {
        1: 'Square',
        2: 'Portrait', 
        3: 'Portrait',
        4: 'Square',
        5: 'Landscape',
        6: 'Landscape'
    };
    
    let previewHTML = '<div class="layout-preview">';
    previewHTML += '<div class="preview-grid">';
    
    // Create 6 grid items with proper styling
    for (let i = 1; i <= 6; i++) {
        const isActive = i == position;
        const label = positionLabels[i];
        previewHTML += `
            <div class="preview-grid-item ${isActive ? 'active' : ''}">
                <div class="preview-position-label">${i}</div>
                <div style="text-align: center; line-height: 1.2; margin-top: 8px;">
                    <div style="font-size: 9px; font-weight: bold;">${label}</div>
                </div>
            </div>
        `;
    }
    
    previewHTML += '</div></div>';
    container.innerHTML = previewHTML;
}

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const scheduleForm = document.getElementById('scheduleForm');
    const mediaIdInput = document.getElementById('media_id');
    
    if (scheduleForm) {
        scheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!mediaIdInput.value) {
                showAlert('Silakan pilih media terlebih dahulu', 'warning');
                return;
            }

            // Get selected media type
            const selectedRow = document.querySelector('input[name="select_row"]:checked')?.closest('tr');
            const mediaType = selectedRow ? selectedRow.cells[1].querySelector('small').textContent.trim() : '';
            const layoutPositionSelect = document.getElementById('layout_position');

            console.log('Form submission - Media type detected:', mediaType);
            console.log('Selected row:', selectedRow);
            console.log('Layout position select:', layoutPositionSelect);

            // Audio validation - no layout position needed
            if (mediaType === 'Audio') {
                // Audio duration is now automatically detected from file
                console.log('Audio selected - duration will be auto-detected');
                // Skip layout position validation for audio
            } else {
                // For Gambar & Video, layout position is required
                if (!layoutPositionSelect || !layoutPositionSelect.value) {
                    showAlert('Silakan pilih posisi layout untuk media visual', 'warning');
                    return;
                }
            }
            
            // Validate start date
            const startDate = document.getElementById('start_date').value;
            console.log('Start date value before validation:', startDate);
            if (!startDate) {
                showAlert('Silakan pilih tanggal mulai', 'warning');
                return;
            }
            
            // Submit form via AJAX
            const formData = new FormData(scheduleForm);
            
            // Debug form data
            console.log('Form data entries:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            // Validate required fields before submission
            if (!formData.get('media_id')) {
                showAlert('Media ID tidak ditemukan', 'error');
                return;
            }
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF token:', token ? 'found' : 'not found');
            
            fetch(scheduleForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showAlert(data.message, 'success');
                    // Reset form
                    scheduleForm.reset();
                    mediaIdInput.value = '';
                    const namaFileInput = document.getElementById('namaFile');
                    namaFileInput.value = '';
                    // Uncheck all checkboxes
                    const checkboxes = document.querySelectorAll('input[name="select_row"]');
                    checkboxes.forEach(cb => {
                        cb.checked = false;
                    });
                    // Remove row highlights
                    document.querySelectorAll('.media-row').forEach(row => {
                        row.classList.remove('table-active');
                    });
                    // Set today as default for date input
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('start_date').value = today;
                    // Reset preview
                    updateLayoutPreview('');
                    
                    // Refresh current schedule page after successful save
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Terjadi kesalahan saat menyimpan jadwal', 'error');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showAlert('Terjadi kesalahan saat menyimpan jadwal: ' + error.message, 'error');
            });
        });
    }
});

// Function to update form fields based on media type
function updateFormFieldsForMediaType(mediaType) {
    console.log('updateFormFieldsForMediaType called with mediaType:', mediaType);
    
    const layoutPositionSection = document.getElementById('layoutPositionSection');
    const layoutPreviewSection = document.getElementById('layoutPreview');
    const layoutPositionSelect = document.getElementById('layout_position');

    console.log('Found elements:', {
        layoutPositionSection: layoutPositionSection ? 'found' : 'not found',
        layoutPreviewSection: layoutPreviewSection ? 'found' : 'not found',
        layoutPositionSelect: layoutPositionSelect ? 'found' : 'not found'
    });

    if (!layoutPositionSection || !layoutPositionSelect) {
        console.error('Required form elements not found');
        return;
    }

    if (mediaType === 'Audio') {
        // For Audio: Hide layout position and preview (duration auto-detected)
        console.log('Hiding layout position section for Audio');
        layoutPositionSection.style.display = 'none';
        if (layoutPreviewSection) layoutPreviewSection.style.display = 'none';
        
        // Audio doesn't need layout position
        layoutPositionSelect.required = false;
        layoutPositionSelect.value = '';
        
        // Update layout preview to show audio info
        updateLayoutPreview('');
        
    } else if (mediaType === 'Gambar' || mediaType === 'Video') {
        // For Visual media: Show layout position and preview
        console.log('Showing layout position section for', mediaType);
        layoutPositionSection.style.display = 'block';
        if (layoutPreviewSection) layoutPreviewSection.style.display = 'block';
        
        // Make layout position required for visual media
        layoutPositionSelect.required = true;
        
    } else {
        // Default state: show layout fields for visual media
        console.log('Default state - showing layout position section');
        layoutPositionSection.style.display = 'block';
        if (layoutPreviewSection) layoutPreviewSection.style.display = 'block';
        
        // Reset requirements
        layoutPositionSelect.required = false;
        layoutPositionSelect.value = '';
        
        // Clear layout preview
        updateLayoutPreview('');
    }
    
    console.log('Form updated for media type:', mediaType);
}

function editSchedule(scheduleId) {
    // Get schedule data via AJAX
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/schedule/${scheduleId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateEditForm(data.schedule);
            showEditModal();
        } else {
            alert('Gagal memuat data jadwal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data jadwal');
    });
}

function populateEditForm(schedule) {
    // Set form action to update
    const editForm = document.getElementById('editScheduleForm');
    editForm.action = `/schedule/${schedule.id}`;
    
    // Populate form fields
    document.getElementById('edit_media_name').value = schedule.media.name;
    document.getElementById('edit_start_date').value = schedule.start_date;
    document.getElementById('edit_end_date').value = schedule.end_date || '';
    document.getElementById('edit_day_of_week').value = schedule.day_of_week || '';
    document.getElementById('edit_time').value = schedule.time || '';
    
    // Handle layout position based on media type
    const mediaType = schedule.media.type;
    const editLayoutPositionSection = document.getElementById('editLayoutPositionSection');
    const editLayoutPreviewSection = document.getElementById('editLayoutPreview');
    const editLayoutPositionSelect = document.getElementById('edit_layout_position');
    
    if (mediaType === 'Audio') {
        // For Audio: Hide layout position and preview
        if (editLayoutPositionSection) editLayoutPositionSection.style.display = 'none';
        if (editLayoutPreviewSection) editLayoutPreviewSection.style.display = 'none';
        
        // Audio doesn't need layout position
        if (editLayoutPositionSelect) {
            editLayoutPositionSelect.required = false;
            editLayoutPositionSelect.value = '';
        }
        
        // Clear layout preview
        updateEditLayoutPreview('');
        
    } else {
        // For Visual media: Show layout position and preview
        if (editLayoutPositionSection) editLayoutPositionSection.style.display = 'block';
        if (editLayoutPreviewSection) editLayoutPreviewSection.style.display = 'block';
        
        // Make layout position required for visual media
        if (editLayoutPositionSelect) {
            editLayoutPositionSelect.required = true;
            
            // Set layout position if available
            if (schedule.layout_position) {
                editLayoutPositionSelect.value = schedule.layout_position;
                updateEditLayoutPreview(schedule.layout_position);
            } else {
                editLayoutPositionSelect.value = '';
                updateEditLayoutPreview('');
            }
        }
    }
    
    // Store schedule ID for form submission
    document.getElementById('edit_schedule_id').value = schedule.id;
}

function showEditModal() {
    const modal = new bootstrap.Modal(document.getElementById('editScheduleModal'));
    modal.show();
}

function updateEditLayoutPreview(position) {
    const container = document.getElementById('editLayoutPreviewContainer');
    
    if (!position) {
        container.className = 'layout-preview-container';
        container.innerHTML = '<div class="preview-empty">Pilih posisi untuk melihat preview</div>';
        return;
    }

    container.className = 'layout-preview-container has-preview';
    
    const positionLabels = {
        1: 'Square',
        2: 'Portrait', 
        3: 'Portrait',
        4: 'Square',
        5: 'Landscape',
        6: 'Landscape'
    };
    
    let previewHTML = '<div class="layout-preview">';
    previewHTML += '<div class="preview-grid">';
    
    // Create 6 grid items with proper styling
    for (let i = 1; i <= 6; i++) {
        const isActive = i == position;
        const label = positionLabels[i];
        previewHTML += `
            <div class="preview-grid-item ${isActive ? 'active' : ''}">
                <div class="preview-position-label">${i}</div>
                <div style="text-align: center; line-height: 1.2; margin-top: 8px;">
                    <div style="font-size: 9px; font-weight: bold;">${label}</div>
                </div>
            </div>
        `;
    }
    
    previewHTML += '</div></div>';
    container.innerHTML = previewHTML;
}

// Function to update schedule
function updateSchedule() {
    const editForm = document.getElementById('editScheduleForm');
    const formData = new FormData(editForm);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const scheduleId = document.getElementById('edit_schedule_id').value;
    
    fetch(`/schedule/${scheduleId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('editScheduleModal'));
            modal.hide();
            // Refresh page to show updated data
            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            alert(data.message || 'Gagal mengupdate jadwal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate jadwal');
    });
}

function deleteSchedule(scheduleId, mediaName = '') {
    const message = mediaName ? 
        `Apakah Anda yakin ingin menghapus jadwal untuk media <strong>"${mediaName}"</strong>?` : 
        'Apakah Anda yakin ingin menghapus jadwal ini?';
    
    showConfirmDeleteModal({
        title: 'Hapus Jadwal',
        message: message,
        warnings: [
            'Media akan dihilangkan dari landing page',
            'Jadwal akan dihapus permanen dari sistem'
        ],
        confirmText: 'Ya, Hapus Jadwal!',
        onConfirm: function() {
            executeDeleteSchedule(scheduleId);
        }
    });
}

function executeDeleteSchedule(scheduleId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/schedule/${scheduleId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof showAlert === 'function') {
                showAlert(data.message || 'Jadwal berhasil dihapus', 'success');
            } else {
                alert(data.message);
            }
            // Remove row from table
            const row = document.querySelector(`tr[data-schedule-id="${scheduleId}"]`);
            if (row) {
                row.remove();
            }
            // Refresh page to update status
            setTimeout(() => window.location.reload(), 1000);
        } else {
            if (typeof showAlert === 'function') {
                showAlert(data.message || 'Gagal menghapus jadwal', 'error');
            } else {
                alert(data.message || 'Gagal menghapus jadwal');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof showAlert === 'function') {
            showAlert('Terjadi kesalahan saat menghapus jadwal', 'error');
        } else {
            alert('Terjadi kesalahan saat menghapus jadwal');
        }
    });
}

// Page transition and animation functions
function showPageTransition() {
    const transition = document.getElementById('pageTransition');
    if (transition) {
        transition.classList.add('active');
    }
}

function hidePageTransition() {
    const transition = document.getElementById('pageTransition');
    if (transition) {
        transition.classList.remove('active');
    }
}

// Add staggered animation to cards and elements
function animateElements() {
    const cards = document.querySelectorAll('.card, .form-section, .table-container');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.style.animation = 'slideInUp 0.6s ease-out forwards';
    });
}

// Handle navigation with transitions
document.addEventListener('DOMContentLoaded', function() {
    // Hide page transition after load
    setTimeout(hidePageTransition, 100);
    
    // Animate elements
    setTimeout(animateElements, 300);
    
    // Add transition to navigation links
    const navLinks = document.querySelectorAll('a[href]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                e.preventDefault();
                showPageTransition();
                setTimeout(() => {
                    window.location.href = href;
                }, 400);
            }
        });
    });
});

// Add CSS for element animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card, .form-section, .table-container {
        opacity: 0;
    }
`;
document.head.appendChild(style);

// Background & Description Management Functions
$(document).ready(function() {
    let allMedia = [];
    
    // Load initial data for background & description
    console.log('Document ready - initializing layout management'); // Debug log
    loadLayoutSettings();
    loadMediaOptions();
    
    // Character counter for description
    $('#landingDescription').on('input', function() {
        const length = $(this).val().length;
        $('#descriptionCharCount').text(length);
        
        if (length > 950) {
            $('#descriptionCharCount').addClass('text-warning');
        } else if (length === 1000) {
            $('#descriptionCharCount').addClass('text-danger');
        } else {
            $('#descriptionCharCount').removeClass('text-warning text-danger');
        }
    });
    
    // Background media selection change
    $('#backgroundMedia').on('change', function() {
        const mediaId = $(this).val();
        if (mediaId) {
            const selectedMedia = allMedia.find(m => m.id == mediaId);
            if (selectedMedia) {
                showBackgroundPreview(selectedMedia);
            }
        } else {
            hideBackgroundPreview();
        }
    });
    
    // Update background button
    $('#updateBackgroundBtn').on('click', function() {
        const mediaId = $('#backgroundMedia').val();
        if (!mediaId) {
            showLayoutAlert('Pilih media untuk background terlebih dahulu', 'warning');
            return;
        }
        updateBackground(mediaId);
    });
    
    // Update description button
    $('#updateDescriptionBtn').on('click', function() {
        const description = $('#landingDescription').val().trim();
        if (!description) {
            showLayoutAlert('Masukkan deskripsi terlebih dahulu', 'warning');
            return;
        }
        updateDescription(description);
    });
    
    function loadMediaOptions() {
        console.log('Loading media options...'); // Debug log
        console.log('Checking if backgroundMedia element exists:', $('#backgroundMedia').length); // Debug log
        
        $.get('/api/media/user')
            .done(function(response) {
                console.log('Media API response:', response); // Debug log
                if (response.success) {
                    allMedia = response.media;
                    const select = $('#backgroundMedia');
                    
                    if (select.length === 0) {
                        console.error('backgroundMedia select element not found!');
                        return;
                    }
                    
                    select.empty();
                    select.append('<option value="">Pilih Media untuk Background</option>');
                    
                    console.log('Found media items:', allMedia.length); // Debug log
                    let addedCount = 0;
                    allMedia.forEach(function(media) {
                        if (media.type === 'Gambar' || media.type === 'Video') {
                            select.append(`<option value="${media.id}">${media.name} (${media.type})</option>`);
                            console.log('Added media option:', media.name, media.type); // Debug log
                            addedCount++;
                        }
                    });
                    
                    console.log('Total options added to dropdown:', addedCount); // Debug log
                    
                    if (addedCount === 0) {
                        console.log('No suitable media found for background'); // Debug log
                        select.append('<option value="" disabled>Tidak ada gambar/video tersedia</option>');
                        showLayoutAlert('Tidak ada media gambar/video yang tersedia', 'warning');
                    }
                } else {
                    console.error('Failed to load media:', response);
                    showLayoutAlert('Gagal memuat daftar media', 'error');
                }
            })
            .fail(function(xhr, status, error) {
                console.error('AJAX Error loading media:', xhr.responseText);
                console.error('Status:', status, 'Error:', error);
                showLayoutAlert('Gagal memuat daftar media: ' + error, 'error');
            });
    }
    
    function loadLayoutSettings() {
        $.get('/layout/settings')
            .done(function(response) {
                if (response.success) {
                    // Update current background display
                    if (response.background_media) {
                        $('#currentBackground').html(`
                            <div class="d-flex align-items-center">
                                <i class="bi bi-${response.background_media.type === 'Video' ? 'play-circle' : 'image'} me-2"></i>
                                ${response.background_media.name}
                            </div>
                        `);
                        
                        // Set selected option in dropdown
                        $('#backgroundMedia').val(response.background_media.id);
                        showBackgroundPreview(response.background_media);
                    } else {
                        $('#currentBackground').text('Tidak ada background');
                    }
                    
                    // Update current description display
                    if (response.description) {
                        $('#currentDescription').text(response.description.substring(0, 100) + (response.description.length > 100 ? '...' : ''));
                        $('#landingDescription').val(response.description);
                        $('#descriptionCharCount').text(response.description.length);
                    } else {
                        $('#currentDescription').text('Tidak ada deskripsi');
                    }
                } else {
                    console.error('Failed to load layout settings:', response);
                    showLayoutAlert('Gagal memuat pengaturan layout', 'error');
                }
            })
            .fail(function(xhr, status, error) {
                console.error('AJAX Error loading layout settings:', xhr.responseText);
                showLayoutAlert('Gagal memuat pengaturan layout: ' + error, 'error');
            });
    }
    
    function showBackgroundPreview(media) {
        const container = $('#backgroundPreviewContainer');
        const section = $('#backgroundPreviewSection');
        
        let previewHtml = '';
        if (media.type === 'Gambar') {
            previewHtml = `<img src="/storage/${media.file_path}" alt="${media.name}">`;
        } else if (media.type === 'Video') {
            previewHtml = `<video controls muted><source src="/storage/${media.file_path}" type="video/mp4"></video>`;
        }
        
        container.html(previewHtml).addClass('has-preview');
        section.show();
    }
    
    function hideBackgroundPreview() {
        const container = $('#backgroundPreviewContainer');
        const section = $('#backgroundPreviewSection');
        
        container.html('').removeClass('has-preview');
        section.hide();
    }
    
    function updateBackground(mediaId) {
        const btn = $('#updateBackgroundBtn');
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i>Updating...');
        
        $.ajax({
            url: '/layout/background',
            method: 'POST',
            data: {
                media_id: mediaId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        })
        .done(function(response) {
            console.log('Background update response:', response);
            if (response.success) {
                showLayoutAlert(response.message, 'success');
                loadLayoutSettings(); // Refresh current settings
            } else {
                showLayoutAlert(response.message || 'Gagal update background', 'error');
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Background update error:', xhr.responseText);
            let errorMsg = 'Terjadi kesalahan saat update background';
            try {
                const errorResponse = JSON.parse(xhr.responseText);
                if (errorResponse.message) {
                    errorMsg = errorResponse.message;
                }
            } catch (e) {
                errorMsg += ': ' + error;
            }
            showLayoutAlert(errorMsg, 'error');
        })
        .always(function() {
            btn.prop('disabled', false).html(originalText);
        });
    }
    
    function updateDescription(description) {
        const btn = $('#updateDescriptionBtn');
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i>Updating...');
        
        $.ajax({
            url: '/layout/description',
            method: 'POST',
            data: {
                description: description,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        })
        .done(function(response) {
            console.log('Description update response:', response);
            if (response.success) {
                showLayoutAlert(response.message, 'success');
                loadLayoutSettings(); // Refresh current settings
            } else {
                showLayoutAlert(response.message || 'Gagal update deskripsi', 'error');
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Description update error:', xhr.responseText);
            let errorMsg = 'Terjadi kesalahan saat update deskripsi';
            try {
                const errorResponse = JSON.parse(xhr.responseText);
                if (errorResponse.message) {
                    errorMsg = errorResponse.message;
                }
            } catch (e) {
                errorMsg += ': ' + error;
            }
            showLayoutAlert(errorMsg, 'error');
        })
        .always(function() {
            btn.prop('disabled', false).html(originalText);
        });
    }
    
    function showLayoutAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' : 'alert-danger';
        const iconClass = type === 'success' ? 'bi-check-circle' : 
                         type === 'warning' ? 'bi-exclamation-triangle' : 'bi-x-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="bi ${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('#layoutAlertContainer').html(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});

</script>

  </main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>