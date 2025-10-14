document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const scheduleBackgroundBtn = document.getElementById('saveBackgroundSchedule');
    const scheduleDescriptionBtn = document.getElementById('saveDescriptionSchedule');
    const viewScheduledBackgroundsBtn = document.getElementById('viewScheduledBackgrounds');
    const scheduledBackgroundsList = document.getElementById('scheduledBackgroundsList');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Schedule Background
    if (scheduleBackgroundBtn) {
        scheduleBackgroundBtn.addEventListener('click', function() {
            const mediaId = document.getElementById('backgroundMediaSelect').value;
            const startDate = document.getElementById('backgroundStartDate').value;
            const dayOfWeek = document.getElementById('backgroundDayOfWeek').value || null;
            const time = document.getElementById('backgroundTime').value || null;

            // Validate required fields
            if (!mediaId || !startDate) {
                showToast('error', 'Harap isi semua field yang wajib diisi');
                return;
            }

            // Show loading state
            const originalText = scheduleBackgroundBtn.innerHTML;
            scheduleBackgroundBtn.disabled = true;
            scheduleBackgroundBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

            // Send request to server
            fetch('/api/scheduled-backgrounds', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    media_id: mediaId,
                    start_date: startDate,
                    day_of_week: dayOfWeek,
                    time: time
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Background berhasil dijadwalkan');
                    // Close modal and reset form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleBackgroundModal'));
                    modal.hide();
                    document.getElementById('scheduleBackgroundForm').reset();
                    
                    // Refresh scheduled backgrounds list if modal is open
                    if (document.getElementById('scheduledBackgroundsModal').classList.contains('show')) {
                        loadScheduledBackgrounds();
                    }
                } else {
                    throw new Error(data.message || 'Gagal menjadwalkan background');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', error.message || 'Terjadi kesalahan saat menyimpan jadwal');
            })
            .finally(() => {
                // Restore button state
                scheduleBackgroundBtn.disabled = false;
                scheduleBackgroundBtn.innerHTML = originalText;
            });
        });
    }

    // Schedule Description
    if (scheduleDescriptionBtn) {
        scheduleDescriptionBtn.addEventListener('click', function() {
            const description = document.getElementById('scheduleDescriptionText').value;
            const startDate = document.getElementById('descriptionStartDate').value;
            const dayOfWeek = document.getElementById('descriptionDayOfWeek').value || null;
            const time = document.getElementById('descriptionTime').value || null;

            // Validate required fields
            if (!description || !startDate) {
                showToast('error', 'Harap isi semua field yang wajib diisi');
                return;
            }

            // Show loading state
            const originalText = scheduleDescriptionBtn.innerHTML;
            scheduleDescriptionBtn.disabled = true;
            scheduleDescriptionBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

            // Send request to server (you'll need to create this endpoint)
            fetch('/api/schedule-descriptions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    description: description,
                    start_date: startDate,
                    day_of_week: dayOfWeek,
                    time: time
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Deskripsi berhasil dijadwalkan');
                    // Close modal and reset form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleDescriptionModal'));
                    modal.hide();
                    document.getElementById('scheduleDescriptionForm').reset();
                } else {
                    throw new Error(data.message || 'Gagal menjadwalkan deskripsi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', error.message || 'Terjadi kesalahan saat menyimpan jadwal');
            })
            .finally(() => {
                // Restore button state
                scheduleDescriptionBtn.disabled = false;
                scheduleDescriptionBtn.innerHTML = originalText;
            });
        });
    }

    // View Scheduled Backgrounds
    if (viewScheduledBackgroundsBtn) {
        viewScheduledBackgroundsBtn.addEventListener('click', function() {
            loadScheduledBackgrounds();
        });
    }

    // Load scheduled backgrounds
    function loadScheduledBackgrounds() {
        fetch('/api/scheduled-backgrounds', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (scheduledBackgroundsList) {
                scheduledBackgroundsList.innerHTML = '';
                
                if (data.length === 0) {
                    scheduledBackgroundsList.innerHTML = '<tr><td colspan="5" class="text-center">Belum ada jadwal background</td></tr>';
                    return;
                }

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.media?.name || 'Tidak ada media'}</td>
                        <td>${new Date(item.start_date).toLocaleDateString('id-ID')}</td>
                        <td>${item.day_of_week ? item.day_of_week.charAt(0).toUpperCase() + item.day_of_week.slice(1) : 'Setiap Hari'}</td>
                        <td>${item.time || '00:00'}</td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-schedule" data-id="${item.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    `;
                    scheduledBackgroundsList.appendChild(row);
                });

                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-schedule').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
                            deleteScheduledBackground(id);
                        }
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Gagal memuat jadwal background');
        });
    }

    // Delete scheduled background
    function deleteScheduledBackground(id) {
        fetch(`/api/scheduled-backgrounds/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Jadwal berhasil dihapus');
                loadScheduledBackgrounds(); // Refresh the list
            } else {
                throw new Error(data.message || 'Gagal menghapus jadwal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', error.message || 'Terjadi kesalahan saat menghapus jadwal');
        });
    }

    // Helper function to show toast notifications
    function showToast(type, message) {
        // Check if toast container exists, if not create it
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast element
        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast show align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        // Toast content
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        // Add to container
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

    // Initialize date pickers with today's date
    const today = new Date().toISOString().split('T')[0];
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.min = today;
        if (!input.value) {
            input.value = today;
        }
    });
});
