// Background and Description Management
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Show toast notification
    function showToast(type, message) {
        const toastContainer = document.querySelector('.toast-container') || createToastContainer();
        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast show align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            const toastElement = document.getElementById(toastId);
            if (toastElement) {
                toastElement.classList.remove('show');
                setTimeout(() => {
                    toastElement.remove();
                }, 300);
            }
        }, 5000);
    }
    
    function createToastContainer() {
        const container = document.createElement('div');
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(container);
        return container;
    }
    // Background Management
    const backgroundSelect = document.getElementById('backgroundSelect');
    if (backgroundSelect) {
        backgroundSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const preview = document.getElementById('backgroundPreview');
            
            if (selectedOption.value) {
                const mediaType = selectedOption.getAttribute('data-type');
                const mediaUrl = selectedOption.getAttribute('data-url');
                
                if (mediaType === 'video') {
                    preview.innerHTML = `
                        <video class="img-fluid rounded" autoplay muted loop>
                            <source src="${mediaUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    `;
                } else {
                    preview.innerHTML = `<img src="${mediaUrl}" class="img-fluid rounded" alt="Background Preview">`;
                }
                
                // Save the background
                saveBackground(selectedOption.value);
            } else {
                preview.innerHTML = `
                    <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                        <i class="bi bi-image fs-1 opacity-50"></i>
                    </div>
                `;
                // Clear the background
                saveBackground('');
            }
        });
    }
    
    // Save background to server
    function saveBackground(mediaId) {
        if (!mediaId) return;
        
        fetch('/api/layout/update-background', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                background_image_id: mediaId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Background berhasil diperbarui');
                
                // Update the preview with the new background
                if (data.background_url) {
                    const preview = document.getElementById('backgroundPreview');
                    const selectedOption = backgroundSelect.options[backgroundSelect.selectedIndex];
                    const mediaType = selectedOption ? selectedOption.getAttribute('data-type') : 'image';
                    
                    if (mediaType === 'video') {
                        preview.innerHTML = `
                            <video class="img-fluid rounded" autoplay muted loop>
                                <source src="${data.background_url}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        `;
                    } else {
                        preview.innerHTML = `<img src="${data.background_url}" class="img-fluid rounded" alt="Background Preview">`;
                    }
                }
            } else {
                throw new Error(data.message || 'Gagal memperbarui background');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', error.message || 'Terjadi kesalahan saat memperbarui background');
            
            // Revert the select to the previous value
            if (backgroundSelect) {
                const layoutSettings = document.querySelector('meta[name="layout-settings"]');
                if (layoutSettings) {
                    const settings = JSON.parse(layoutSettings.getAttribute('content'));
                    if (settings && settings.background_image_id) {
                        backgroundSelect.value = settings.background_image_id;
                    }
                }
            }
        });
    }
    
    // Description Management
    const saveDescriptionBtn = document.getElementById('saveDescription');
    if (saveDescriptionBtn) {
        saveDescriptionBtn.addEventListener('click', function() {
            const description = document.getElementById('descriptionText').value;
            
            // Show loading state
            const originalText = saveDescriptionBtn.innerHTML;
            saveDescriptionBtn.disabled = true;
            saveDescriptionBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            
            // Save the description
            fetch('/api/layout/update-description', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Deskripsi berhasil disimpan');
                } else {
                    throw new Error(data.message || 'Gagal menyimpan deskripsi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', error.message || 'Terjadi kesalahan saat menyimpan deskripsi');
            })
            .finally(() => {
                // Restore button state
                saveDescriptionBtn.disabled = false;
                saveDescriptionBtn.innerHTML = originalText;
            });
        });
    }
    
    // Initialize date pickers with today's date
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.min = today;
        if (!input.value) {
            input.value = today;
        }
    });
    
    // Initialize time pickers with current time
    const timeInputs = document.querySelectorAll('input[type="time"]');
    timeInputs.forEach(input => {
        if (!input.value) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            input.value = `${hours}:${minutes}`;
        }
    });
});
