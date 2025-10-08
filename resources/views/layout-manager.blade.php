<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Layout Manager - Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
    }
    
    .navbar {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      transition: transform 0.2s ease;
    }
    
    .card:hover {
      transform: translateY(-2px);
    }
    
    .btn-primary {
      background: var(--primary);
      border-color: var(--primary);
    }
    
    .btn-primary:hover {
      background: var(--primary-light);
      border-color: var(--primary-light);
    }
    
    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(31, 158, 118, 0.25);
    }
    
    .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(31, 158, 118, 0.25);
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="/dashboard">
        <i class="fas fa-palette me-2"></i>Layout Manager
      </a>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="/dashboard">
          <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-palette me-2"></i>Layout Manager
                    </h4>
                </div>
                <div class="card-body">
                    
                    <!-- Background Management Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-image me-2"></i>Background Management
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="backgroundForm">
                                        <div class="mb-3">
                                            <label for="backgroundMedia" class="form-label">Pilih Background Media</label>
                                            <select class="form-select" id="backgroundMedia" name="media_id" required>
                                                <option value="">-- Pilih Media --</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="backgroundPreview" style="display: none;">
                                            <label class="form-label">Preview Background</label>
                                            <div class="border rounded p-2" style="height: 200px; overflow: hidden;">
                                                <img id="backgroundPreviewImg" src="" alt="Background Preview" 
                                                     class="img-fluid w-100 h-100" style="object-fit: cover; display: none;">
                                                <video id="backgroundPreviewVideo" class="w-100 h-100" 
                                                       style="object-fit: cover; display: none;" muted loop>
                                                </video>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Background
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Description Management Section -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-edit me-2"></i>Description Management
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="descriptionForm">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Deskripsi Landing Page</label>
                                            <textarea class="form-control" id="description" name="description" 
                                                      rows="8" maxlength="1000" required 
                                                      placeholder="Masukkan deskripsi untuk landing page..."></textarea>
                                            <div class="form-text">
                                                <span id="charCount">0</span>/1000 karakter
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i>Update Deskripsi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Layout Settings Display -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cog me-2"></i>Current Layout Settings
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6>Current Background:</h6>
                                            <div id="currentBackground" class="border rounded p-2 mb-3" style="height: 150px;">
                                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                    <i class="fas fa-image fa-3x"></i>
                                                    <span class="ms-2">No Background Set</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6>Current Description:</h6>
                                            <div id="currentDescription" class="border rounded p-3 bg-light" style="min-height: 150px;">
                                                <em class="text-muted">No description set</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2">Processing...</div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let allMedia = [];
    
    // Load initial data
    loadLayoutSettings();
    loadMediaOptions();
    
    // Character counter for description
    $('#description').on('input', function() {
        const length = $(this).val().length;
        $('#charCount').text(length);
        
        if (length > 900) {
            $('#charCount').addClass('text-warning');
        } else {
            $('#charCount').removeClass('text-warning');
        }
    });
    
    // Background media selection change
    $('#backgroundMedia').on('change', function() {
        const mediaId = $(this).val();
        if (mediaId) {
            const media = allMedia.find(m => m.id == mediaId);
            if (media) {
                showBackgroundPreview(media);
            }
        } else {
            hideBackgroundPreview();
        }
    });
    
    // Background form submission
    $('#backgroundForm').on('submit', function(e) {
        e.preventDefault();
        updateBackground();
    });
    
    // Description form submission
    $('#descriptionForm').on('submit', function(e) {
        e.preventDefault();
        updateDescription();
    });
    
    // Load layout settings
    function loadLayoutSettings() {
        console.log('Loading layout settings...'); // Debug log
        $.get('/layout/settings')
            .done(function(response) {
                console.log('Layout settings response:', response); // Debug log
                if (response.success) {
                    displayCurrentSettings(response);
                } else {
                    console.log('Layout settings failed:', response); // Debug log
                    showAlert('Gagal memuat pengaturan layout', 'danger');
                }
            })
            .fail(function(xhr, status, error) {
                console.log('Layout settings AJAX failed:', xhr, status, error); // Debug log
                showAlert('Gagal memuat pengaturan layout', 'danger');
            });
    }
    
    // Load media options
    function loadMediaOptions() {
        console.log('Loading media options...'); // Debug log
        $.get('/api/media/user')
            .done(function(response) {
                console.log('Media response:', response); // Debug log
                if (response.success) {
                    allMedia = response.media;
                    populateMediaSelect();
                    console.log('Media loaded:', allMedia.length, 'items'); // Debug log
                } else {
                    console.log('Media loading failed:', response); // Debug log
                    showAlert('Gagal memuat daftar media', 'danger');
                }
            })
            .fail(function(xhr, status, error) {
                console.log('Media API failed:', xhr, status, error); // Debug log
                showAlert('Gagal memuat daftar media', 'danger');
            });
    }
    
    // Populate media select options
    function populateMediaSelect() {
        const select = $('#backgroundMedia');
        select.empty().append('<option value="">-- Pilih Media --</option>');
        
        allMedia.forEach(function(media) {
            const option = $('<option></option>')
                .attr('value', media.id)
                .text(`${media.name} (${media.type})`);
            select.append(option);
        });
    }
    
    // Show background preview
    function showBackgroundPreview(media) {
        const preview = $('#backgroundPreview');
        const img = $('#backgroundPreviewImg');
        const video = $('#backgroundPreviewVideo');
        
        img.hide();
        video.hide();
        
        if (media.type === 'Gambar') {
            img.attr('src', `/storage/${media.file_path}`).show();
        } else if (media.type === 'Video') {
            video.attr('src', `/storage/${media.file_path}`).show();
            video[0].load();
        }
        
        preview.show();
    }
    
    // Hide background preview
    function hideBackgroundPreview() {
        $('#backgroundPreview').hide();
    }
    
    // Display current settings
    function displayCurrentSettings(response) {
        // Display current background
        const currentBg = $('#currentBackground');
        if (response.background_media) {
            const media = response.background_media;
            if (media.type === 'Gambar') {
                currentBg.html(`<img src="/storage/${media.file_path}" alt="${media.name}" class="img-fluid w-100 h-100" style="object-fit: cover;">`);
            } else if (media.type === 'Video') {
                currentBg.html(`<video src="/storage/${media.file_path}" class="w-100 h-100" style="object-fit: cover;" muted loop autoplay></video>`);
            }
        }
        
        // Display current description
        const currentDesc = $('#currentDescription');
        if (response.description) {
            currentDesc.html(response.description.replace(/\n/g, '<br>'));
            $('#description').val(response.description);
            $('#charCount').text(response.description.length);
        }
        
        // Set selected background in dropdown
        if (response.background_media) {
            $('#backgroundMedia').val(response.background_media.id);
        }
    }
    
    // Update background
    function updateBackground() {
        console.log('updateBackground called'); // Debug log
        const formData = new FormData($('#backgroundForm')[0]);
        console.log('Form data:', Object.fromEntries(formData)); // Debug log
        showLoading();
        
        $.ajax({
            url: '/layout/background',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function(response) {
            console.log('Background update response:', response); // Debug log
            hideLoading();
            if (response.success) {
                showAlert(response.message, 'success');
                loadLayoutSettings(); // Reload to show updated settings
            } else {
                showAlert(response.message || 'Gagal memperbarui background', 'danger');
            }
        })
        .fail(function(xhr, status, error) {
            console.log('Background update failed:', xhr, status, error); // Debug log
            hideLoading();
            showAlert('Terjadi kesalahan saat memperbarui background', 'danger');
        });
    }
    
    // Update description
    function updateDescription() {
        console.log('updateDescription called'); // Debug log
        const formData = new FormData($('#descriptionForm')[0]);
        console.log('Description form data:', Object.fromEntries(formData)); // Debug log
        showLoading();
        
        $.ajax({
            url: '/layout/description',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done(function(response) {
            console.log('Description update response:', response); // Debug log
            hideLoading();
            if (response.success) {
                showAlert(response.message, 'success');
                loadLayoutSettings(); // Reload to show updated settings
            } else {
                showAlert(response.message || 'Gagal memperbarui deskripsi', 'danger');
            }
        })
        .fail(function(xhr, status, error) {
            console.log('Description update failed:', xhr, status, error); // Debug log
            hideLoading();
            showAlert('Terjadi kesalahan saat memperbarui deskripsi', 'danger');
        });
    }
    
    // Show loading modal
    function showLoading() {
        $('#loadingModal').modal('show');
    }
    
    // Hide loading modal
    function hideLoading() {
        $('#loadingModal').modal('hide');
    }
    
    // Show alert
    function showAlert(message, type) {
        console.log('Alert:', type, message); // Debug log
        
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert at the top of card body
        $('.card-body').first().prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
</body>
</html>
