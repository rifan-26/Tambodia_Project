<div class="template-selector-content">
    <style>
        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .template-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .template-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .template-thumbnail {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: rgba(255,255,255,0.5);
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
            z-index: 10;
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
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .btn-activate {
            background: #28a745;
            color: white;
        }

        .btn-activate:hover {
            background: #218838;
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background: #0056b3;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .add-template-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
        }

        .add-template-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .add-template-card i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .add-template-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
        }

        .loading-state {
            text-align: center;
            padding: 3rem;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <div class="templates-grid" id="templatesGrid">
        <!-- Loading state -->
        <div class="loading-state">
            <div class="loading-spinner"></div>
            <p class="text-muted">Memuat template...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadTemplates();
});

function loadTemplates() {
    fetch('/api/layout/templates')
        .then(response => response.json())
        .then(data => {
            renderTemplates(data.templates || []);
        })
        .catch(error => {
            console.error('Error loading templates:', error);
            document.getElementById('templatesGrid').innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Gagal memuat template</p>
                </div>
            `;
        });
}

function renderTemplates(templates) {
    const grid = document.getElementById('templatesGrid');
    
    if (templates.length === 0) {
        grid.innerHTML = `
            <a href="/admin/templates/create" class="add-template-card">
                <i class="bi bi-plus-circle"></i>
                <h3>Tambah Template</h3>
                <p class="mb-0">Buat template layout baru</p>
            </a>
        `;
        return;
    }

    let html = '';
    
    // Add template cards
    templates.forEach(template => {
        html += `
            <div class="template-card">
                <div class="template-thumbnail">
                    ${template.thumbnail_path 
                        ? `<img src="/storage/${template.thumbnail_path}" alt="${template.name}">`
                        : '<i class="bi bi-grid-3x3-gap placeholder-icon"></i>'
                    }
                    ${template.is_active 
                        ? '<span class="active-badge"><i class="bi bi-check-circle me-1"></i>Active</span>'
                        : ''
                    }
                </div>
                <div class="template-body">
                    <h3 class="template-title">${template.name}</h3>
                    <div class="template-meta">
                        <i class="bi bi-calendar3 me-1"></i>
                        ${new Date(template.updated_at).toLocaleDateString('id-ID')}
                        <br>
                        <i class="bi bi-grid me-1"></i>
                        Grid: ${template.grid_type.toUpperCase()}
                    </div>
                    <div class="template-actions">
                        ${!template.is_active 
                            ? `<button class="btn-action btn-activate" onclick="activateTemplate(${template.id})">
                                <i class="bi bi-check-circle me-1"></i>Pilih
                            </button>`
                            : ''
                        }
                        <a href="/admin/templates/${template.id}/edit" class="btn-action btn-edit">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        ${!template.is_active 
                            ? `<button class="btn-action btn-delete" onclick="deleteTemplate(${template.id})">
                                <i class="bi bi-trash"></i>
                            </button>`
                            : ''
                        }
                    </div>
                </div>
            </div>
        `;
    });

    // Add "Tambah Template" card
    html += `
        <a href="/admin/templates/create" class="add-template-card">
            <i class="bi bi-plus-circle"></i>
            <h3>Tambah Template</h3>
            <p class="mb-0">Buat template layout baru</p>
        </a>
    `;

    grid.innerHTML = html;
}

function activateTemplate(id) {
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
                        loadTemplates();
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Gagal mengaktifkan template', 'error');
            });
        }
    });
}

function deleteTemplate(id) {
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
                        loadTemplates();
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Gagal menghapus template', 'error');
            });
        }
    });
}
</script>
