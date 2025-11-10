# Cara Menambahkan Template Manager UI ke Master Layout

## 1. Tambahkan Section Template Manager

Tambahkan kode ini di `resources/views/layout-manager.blade.php` **SEBELUM** section "Gallery Content" (sekitar baris 800-900):

```html
<!-- Template Manager Section -->
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5>
          <i class="fas fa-save me-2"></i>Template Manager
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Save Template -->
          <div class="col-md-6">
            <h6 class="mb-3"><i class="bi bi-floppy me-2"></i>Simpan Layout Saat Ini</h6>
            <p class="text-muted small">Simpan konfigurasi layout saat ini (background + grid + deskripsi) sebagai template</p>
            <button class="btn btn-success w-100" onclick="openSaveTemplateModal()">
              <i class="fas fa-save me-2"></i>Simpan sebagai Template
            </button>
          </div>

          <!-- Load Template -->
          <div class="col-md-6">
            <h6 class="mb-3"><i class="bi bi-folder-open me-2"></i>Load Template Tersimpan</h6>
            <select class="form-select mb-2" id="templateSelector">
              <option value="">-- Pilih Template --</option>
            </select>
            <div class="d-flex gap-2">
              <button class="btn btn-primary flex-grow-1" onclick="loadSelectedTemplate()">
                <i class="fas fa-download me-2"></i>Load Template
              </button>
              <button class="btn btn-danger" onclick="deleteSelectedTemplate()">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
```

## 2. Tambahkan Modal untuk Save Template

Tambahkan modal ini **SEBELUM** tag `</body>` penutup:

```html
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
```

## 3. Tambahkan JavaScript Functions

Tambahkan kode JavaScript ini **SEBELUM** tag `</body>` penutup (atau di dalam tag `<script>` yang sudah ada):

```javascript
// ═══════════════════════════════════════════════════════════════════════
// TEMPLATE MANAGEMENT FUNCTIONS
// ═══════════════════════════════════════════════════════════════════════

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
                    setBackground(template.background_media);
                } else {
                    clearBackground();
                }

                // Load grid positions
                clearAllGridMedia();
                if (gridMedia) {
                    Object.keys(gridMedia).forEach(position => {
                        const media = gridMedia[position];
                        setGridMedia(parseInt(position), media);
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
 * Helper: Set background
 */
function setBackground(media) {
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
 * Helper: Clear background
 */
function clearBackground() {
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
 * Helper: Set grid media
 */
function setGridMedia(position, media) {
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

// Track current background ID
let currentBackgroundId = null;
```

## 4. Update Existing Functions

Pastikan fungsi-fungsi berikut sudah ada dan berfungsi dengan baik:
- `clearAllGridMedia()` - untuk clear semua grid
- `removeGridMedia(position)` - untuk remove media dari posisi tertentu

## 5. Testing

Setelah menambahkan kode di atas:

1. **Test Save Template:**
   - Atur background dan grid di Master Layout
   - Klik "Simpan sebagai Template"
   - Input nama template
   - Klik "Simpan Template"
   - Cek apakah template muncul di dropdown

2. **Test Load Template:**
   - Pilih template dari dropdown
   - Klik "Load Template"
   - Cek apakah background, grid, dan deskripsi ter-load dengan benar

3. **Test Delete Template:**
   - Pilih template dari dropdown
   - Klik tombol trash (merah)
   - Konfirmasi penghapusan
   - Cek apakah template hilang dari dropdown

## Catatan Penting

- Template hanya menyimpan **referensi** ke media (ID), bukan file media itu sendiri
- Jika media dihapus dari database, template akan kehilangan referensi tersebut
- Template tidak mempengaruhi landing page sampai Anda klik "Simpan Layout"
- Setelah load template, Anda masih bisa edit sebelum save ke landing page
