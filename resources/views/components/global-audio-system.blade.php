<!-- Global Audio System Component for Admin Panel -->
<script>
// Simple Audio System - Play once at exact scheduled time
(function() {
    'use strict';
    
    // Global variables
    let audioCheckInterval;
    let currentAudio = null;
    let playedScheduleIds = new Set();
    
    // Load played schedules from localStorage on init
    function loadPlayedSchedules() {
        const stored = localStorage.getItem('playedScheduleIds');
        if (stored) {
            try {
                const ids = JSON.parse(stored);
                playedScheduleIds = new Set(ids);
                console.log('🎵 Loaded played schedules from storage:', ids);
            } catch (e) {
                console.log('🎵 Error loading played schedules, starting fresh');
                playedScheduleIds = new Set();
            }
        }
    }
    
    // Save played schedules to localStorage
    function savePlayedSchedules() {
        localStorage.setItem('playedScheduleIds', JSON.stringify([...playedScheduleIds]));
    }
    
    // Initialize audio system
    function initAudioSystem() {
        console.log('🎵 Audio: Starting simple audio system...');
        
        // Load played schedules from storage first
        loadPlayedSchedules();
        
        // Check every 5 seconds
        audioCheckInterval = setInterval(checkAudioSchedule, 5000);
        checkAudioSchedule();
    }
    
    // Check if audio should play now
    async function checkAudioSchedule() {
        // Skip if audio is playing
        if (currentAudio) {
            console.log('🎵 Audio currently playing, skipping check');
            return;
        }
        
        console.log('🎵 Checking for audio schedules...');
        
        try {
            const response = await fetch('/api/dashboard/audio-schedules', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                console.log('🎵 API Response:', data);
                
                if (data.success && data.schedules && data.schedules.length > 0) {
                    console.log(`🎵 Found ${data.schedules.length} schedules`);
                    
                    // Find first schedule that hasn't been played
                    const unplayedSchedule = data.schedules.find(schedule => 
                        !playedScheduleIds.has(schedule.id)
                    );
                    
                    if (unplayedSchedule) {
                        console.log(`🎵 Found unplayed schedule: ${unplayedSchedule.id}`);
                        // Play the unplayed audio
                        playAudio(unplayedSchedule);
                        // Mark as played and save to storage
                        playedScheduleIds.add(unplayedSchedule.id);
                        savePlayedSchedules();
                        console.log(`🎵 Marked schedule ${unplayedSchedule.id} as played and saved to storage`);
                    } else {
                        console.log('🎵 All schedules already played');
                    }
                } else {
                    console.log('🎵 No active schedules found');
                }
            } else {
                console.error('🎵 API response not ok:', response.status);
            }
        } catch (error) {
            console.error('🎵 Audio check error:', error);
        }
    }
    
    // Play audio once
    function playAudio(schedule) {
        console.log(`🎵 Playing: ${schedule.media.name}`);
        
        const audio = document.createElement('audio');
        audio.src = `/storage/${schedule.media.file_path}`;
        audio.volume = 0.7;
        
        currentAudio = audio;
        
        // Show popup notification
        showAudioPopup(schedule);
        
        // Clean up when done
        audio.addEventListener('ended', () => {
            console.log('🎵 Audio finished');
            audio.remove();
            currentAudio = null;
            hideAudioPopup();
        });
        
        audio.addEventListener('error', () => {
            console.log('🎵 Audio error');
            audio.remove();
            currentAudio = null;
            hideAudioPopup();
        });
        
        document.body.appendChild(audio);
        audio.play().catch(console.error);
    }
    
    // Show audio popup notification
    function showAudioPopup(schedule) {
        // Remove existing popup
        hideAudioPopup();
        
        const popup = document.createElement('div');
        popup.id = 'audioPopup';
        popup.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #28a745, #20c997);
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                z-index: 10000;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-size: 14px;
                max-width: 300px;
                animation: slideIn 0.3s ease-out;
            ">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-volume-up-fill" style="font-size: 18px;"></i>
                    <div>
                        <div style="font-weight: bold; margin-bottom: 2px;">🎵 Playing Audio</div>
                        <div style="font-size: 12px; opacity: 0.9;">${schedule.media.name}</div>
                    </div>
                </div>
            </div>
            <style>
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            </style>
        `;
        
        document.body.appendChild(popup);
    }
    
    // Hide audio popup
    function hideAudioPopup() {
        const popup = document.getElementById('audioPopup');
        if (popup) {
            popup.remove();
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAudioSystem);
    } else {
        initAudioSystem();
    }
    
})();
</script>
