// Simple test function
function testJS() {
    alert('JavaScript is working!');
}

// Edit schedule function
function editSchedule(scheduleId) {
    alert('Edit schedule ID: ' + scheduleId);
    // Get schedule data via AJAX
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/schedule/' + scheduleId, {
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
            // TODO: Populate edit form and show modal
            console.log('Schedule data:', data.schedule);
        } else {
            alert('Gagal memuat data jadwal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data jadwal');
    });
}

// Delete schedule function
function deleteSchedule(scheduleId, mediaName) {
    if (confirm('Apakah Anda yakin ingin menghapus jadwal untuk media "' + mediaName + '"?\n\nMedia ini akan dihilangkan dari landing page.')) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/schedule/' + scheduleId, {
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
                alert(data.message);
                // Remove row from table
                const row = document.querySelector('tr[data-schedule-id="' + scheduleId + '"]');
                if (row) {
                    row.remove();
                }
                // Refresh page to update status
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                alert(data.message || 'Gagal menghapus jadwal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus jadwal');
        });
    }
}

console.log('Jadwal.js loaded successfully');
