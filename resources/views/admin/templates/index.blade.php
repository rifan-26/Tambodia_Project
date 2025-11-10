<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Template Manager - BPS Sumatera Utara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f7fa;
        }
        
        .page-header {
            background: linear-gradient(135deg, #092058 0%, #1345BE 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .template-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .template-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .template-thumbnail {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .template-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .template-thumbnail .placeholder-icon {
            font-size: 4rem;
            color: #999;
        }
        
        .active-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }
        
        .template-body {
            padding: 1.25rem;
        }
        
        .template-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .template-meta {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
        }
        
        .template-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-action {
            flex: 1;
            padding: 0.5rem;
            font-size: 0.875rem;
            border-radius: 6px;
        }
        
        .fab-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1345BE 0%, #092058 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(19, 69, 190, 0.4);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .fab-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(19, 69, 190, 0.6);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-1">Template Manager</h1>
                    <p class="mb-0 opacity-75">Kelola template layout untuk halaman landing</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        @if($templates->count() > 0)
            <div class="row g-4">
                @foreach($templates as $template)
                    <div class="col-md-6 col-lg-4">
                        <div class="template-card">
                            <div class="template-thumbnail">
                                @if($template->thumbnail_path && Storage::exists($template->thumbnail_path))
                                    <img src="{{ Storage::url($template->thumbnail_path) }}" alt="{{ $template->name }}">
                                @else
                                    <i class="bi bi-grid-3x3-gap placeholder-icon"></i>
                                @endif
                                
                                @if($template->is_active)
                                    <span class="active-badge">
                                        <i class="bi bi-check-circle me-1"></i>Active
                                    </span>
                                @endif
                            </div>
                            
                            <div class="template-body">
                                <h3 class="template-title">{{ $template->name }}</h3>
                                <div class="template-meta">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $template->updated_at->format('d M Y, H:i') }}
                                    <br>
                                    <i class="bi bi-grid me-1"></i>
                                    Grid: {{ strtoupper($template->grid_type) }}
                                </div>
                                
                                <div class="template-actions">
                                    @if(!$template->is_active)
                                        <button class="btn btn-success btn-action btn-activate" data-id="{{ $template->id }}">
                                            <i class="bi bi-check-circle me-1"></i>Pilih
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('templates.edit', $template->id) }}" class="btn btn-primary btn-action">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    
                                    @if(!$template->is_active)
                                        <button class="btn btn-danger btn-action btn-delete" data-id="{{ $template->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $templates->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-grid-3x3-gap"></i>
                <h3>Belum Ada Template</h3>
                <p class="text-muted">Klik tombol + di bawah untuk membuat template pertama Anda</p>
            </div>
        @endif
    </div>

    <!-- Floating Action Button -->
    <a href="{{ route('templates.create') }}" class="fab-button" title="Tambah Template">
        <i class="bi bi-plus-lg"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Activate Template
        document.querySelectorAll('.btn-activate').forEach(btn => {
            btn.addEventListener('click', function() {
                const templateId = this.dataset.id;
                
                Swal.fire({
                    title: 'Aktifkan Template?',
                    text: 'Template ini akan ditampilkan di halaman landing',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Aktifkan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        activateTemplate(templateId);
                    }
                });
            });
        });

        function activateTemplate(id) {
            fetch(`/admin/templates/${id}/activate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Template telah diaktifkan',
                        icon: 'success',
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Gagal mengaktifkan template', 'error');
            });
        }

        // Delete Template
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const templateId = this.dataset.id;
                
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
                        deleteTemplate(templateId);
                    }
                });
            });
        });

        function deleteTemplate(id) {
            fetch(`/admin/templates/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Template telah dihapus',
                        icon: 'success',
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Gagal menghapus template', 'error');
            });
        }
    </script>
</body>
</html>
