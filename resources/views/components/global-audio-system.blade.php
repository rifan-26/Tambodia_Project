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
        const today = new Date().toDateString();
        const storedDate = localStorage.getItem('playedSchedulesDate');
        
        // Reset if it's a new day
        if (storedDate !== today) {
            console.log('🎵 New day detected, clearing played schedules');
            playedScheduleIds = new Set();
            localStorage.setItem('playedSchedulesDate', today);
            localStorage.removeItem('playedScheduleIds');
            return;
        }
        
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
        localStorage.setItem('playedSchedulesDate', new Date().toDateString());
    }
    
    // Generate unique key for schedule (media_id + date to prevent replay on same day)
    function getScheduleKey(schedule) {
        const today = new Date().toISOString().split('T')[0]; // YYYY-MM-DD
        return `${schedule.media.id}_${today}`;
    }
    
    // Clear played schedules (for testing/debugging)
    window.clearAudioTracking = function() {
        playedScheduleIds = new Set();
        localStorage.removeItem('playedScheduleIds');
        localStorage.removeItem('playedSchedulesDate');
        console.log('🎵 Audio tracking cleared! Audio can play again.');
        alert('Audio tracking telah di-reset. Audio bisa diputar lagi.');
    };
    
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
                    
                    // Find first schedule that hasn't been played today
                    const unplayedSchedule = data.schedules.find(schedule => {
                        const scheduleKey = getScheduleKey(schedule);
                        return !playedScheduleIds.has(scheduleKey);
                    });
                    
                    if (unplayedSchedule) {
                        const scheduleKey = getScheduleKey(unplayedSchedule);
                        console.log(`🎵 Found unplayed schedule: ${scheduleKey}`);
                        // Play the unplayed audio
                        playAudio(unplayedSchedule);
                        // Mark as played and save to storage
                        playedScheduleIds.add(scheduleKey);
                        savePlayedSchedules();
                        console.log(`🎵 Marked schedule ${scheduleKey} as played and saved to storage`);
                    } else {
                        console.log('🎵 All schedules already played today');
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
        console.log(`🎵 Audio path: /storage/${schedule.media.file_path}`);
        
        const audio = document.createElement('audio');
        audio.src = `/storage/${schedule.media.file_path}`;
        audio.volume = 0.7;
        
        currentAudio = audio;
        
        // Show popup notification with play button
        showAudioPopup(schedule, audio);
        
        // Clean up when done
        audio.addEventListener('ended', () => {
            console.log('🎵 Audio finished');
            audio.remove();
            currentAudio = null;
            hideAudioPopup();
        });
        
        audio.addEventListener('error', (e) => {
            console.error('🎵 Audio error:', e);
            console.error('🎵 Failed to load:', audio.src);
            audio.remove();
            currentAudio = null;
            hideAudioPopup();
            alert('Gagal memutar audio. File mungkin tidak ditemukan atau format tidak didukung.');
        });
        
        audio.addEventListener('loadeddata', () => {
            console.log('🎵 Audio loaded successfully, duration:', audio.duration);
        });
        
        document.body.appendChild(audio);
        
        // Try autoplay, if fails show click-to-play button
        audio.play().then(() => {
            console.log('🎵 Audio playing automatically');
        }).catch(error => {
            console.warn('🎵 Autoplay blocked by browser:', error);
            // Update popup to show play button
            showPlayButton(schedule, audio);
        });
    }
    
    // Show audio popup notification with volume control
    function showAudioPopup(schedule, audio) {
        // Remove existing popup
        hideAudioPopup();
        
        // Get saved volume or default to 70%
        const savedVolume = localStorage.getItem('audioVolume') || '0.7';
        audio.volume = parseFloat(savedVolume);
        
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
                max-width: 320px;
                animation: slideIn 0.3s ease-out;
            ">
                <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;">
                    <i class="bi bi-volume-up-fill" style="font-size: 18px; animation: pulse 1.5s infinite; margin-top: 2px;"></i>
                    <div style="flex: 1;">
                        <div style="font-weight: bold; margin-bottom: 2px;">🎵 Playing Audio</div>
                        <div style="font-size: 12px; opacity: 0.9;">${schedule.media.name}</div>
                    </div>
                    <button onclick="stopAudio()" style="
                        background: rgba(255,255,255,0.2);
                        border: none;
                        color: white;
                        width: 30px;
                        height: 30px;
                        border-radius: 50%;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-shrink: 0;
                    ">
                        <i class="bi bi-x" style="font-size: 16px;"></i>
                    </button>
                </div>
                
                <!-- Volume Control -->
                <div style="display: flex; align-items: center; gap: 8px; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.2);">
                    <i class="bi bi-volume-down" style="font-size: 14px; opacity: 0.8;"></i>
                    <input 
                        type="range" 
                        id="audioVolumeSlider" 
                        min="0" 
                        max="100" 
                        value="${Math.round(parseFloat(savedVolume) * 100)}"
                        style="
                            flex: 1;
                            height: 4px;
                            border-radius: 2px;
                            background: rgba(255,255,255,0.3);
                            outline: none;
                            -webkit-appearance: none;
                            cursor: pointer;
                        "
                    >
                    <i class="bi bi-volume-up" style="font-size: 14px; opacity: 0.8;"></i>
                    <span id="volumePercentage" style="font-size: 11px; opacity: 0.9; min-width: 35px; text-align: right;">
                        ${Math.round(parseFloat(savedVolume) * 100)}%
                    </span>
                </div>
            </div>
            <style>
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes pulse {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.2); }
                }
                
                /* Custom range slider styling */
                #audioVolumeSlider::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    appearance: none;
                    width: 14px;
                    height: 14px;
                    border-radius: 50%;
                    background: white;
                    cursor: pointer;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }
                
                #audioVolumeSlider::-moz-range-thumb {
                    width: 14px;
                    height: 14px;
                    border-radius: 50%;
                    background: white;
                    cursor: pointer;
                    border: none;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }
                
                #audioVolumeSlider::-webkit-slider-runnable-track {
                    height: 4px;
                    border-radius: 2px;
                    background: rgba(255,255,255,0.3);
                }
                
                #audioVolumeSlider::-moz-range-track {
                    height: 4px;
                    border-radius: 2px;
                    background: rgba(255,255,255,0.3);
                }
            </style>
        `;
        
        document.body.appendChild(popup);
        
        // Add volume control event listener
        const volumeSlider = document.getElementById('audioVolumeSlider');
        const volumePercentage = document.getElementById('volumePercentage');
        
        if (volumeSlider && audio) {
            volumeSlider.addEventListener('input', function() {
                const volume = this.value / 100;
                audio.volume = volume;
                volumePercentage.textContent = `${this.value}%`;
                // Save to localStorage
                localStorage.setItem('audioVolume', volume.toString());
                console.log('🎵 Volume changed to:', this.value + '%');
            });
        }
    }
    
    // Show play button when autoplay is blocked
    function showPlayButton(schedule, audio) {
        const popup = document.getElementById('audioPopup');
        if (popup) {
            // Get saved volume or default to 70%
            const savedVolume = localStorage.getItem('audioVolume') || '0.7';
            audio.volume = parseFloat(savedVolume);
            
            popup.innerHTML = `
                <div style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #ffc107, #ff9800);
                    color: white;
                    padding: 15px 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
                    z-index: 10000;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    font-size: 14px;
                    max-width: 320px;
                ">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <button onclick="manualPlayAudio()" style="
                            background: rgba(255,255,255,0.3);
                            border: none;
                            color: white;
                            width: 40px;
                            height: 40px;
                            border-radius: 50%;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        ">
                            <i class="bi bi-play-fill" style="font-size: 20px;"></i>
                        </button>
                        <div style="flex: 1;">
                            <div style="font-weight: bold; margin-bottom: 2px;">🎵 Klik untuk Putar</div>
                            <div style="font-size: 12px; opacity: 0.9;">${schedule.media.name}</div>
                        </div>
                        <button onclick="stopAudio()" style="
                            background: rgba(255,255,255,0.2);
                            border: none;
                            color: white;
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        ">
                            <i class="bi bi-x" style="font-size: 16px;"></i>
                        </button>
                    </div>
                    
                    <!-- Volume Control -->
                    <div style="display: flex; align-items: center; gap: 8px; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.2);">
                        <i class="bi bi-volume-down" style="font-size: 14px; opacity: 0.8;"></i>
                        <input 
                            type="range" 
                            id="audioVolumeSlider" 
                            min="0" 
                            max="100" 
                            value="${Math.round(parseFloat(savedVolume) * 100)}"
                            style="
                                flex: 1;
                                height: 4px;
                                border-radius: 2px;
                                background: rgba(255,255,255,0.3);
                                outline: none;
                                -webkit-appearance: none;
                                cursor: pointer;
                            "
                        >
                        <i class="bi bi-volume-up" style="font-size: 14px; opacity: 0.8;"></i>
                        <span id="volumePercentage" style="font-size: 11px; opacity: 0.9; min-width: 35px; text-align: right;">
                            ${Math.round(parseFloat(savedVolume) * 100)}%
                        </span>
                    </div>
                </div>
                <style>
                    #audioVolumeSlider::-webkit-slider-thumb {
                        -webkit-appearance: none;
                        appearance: none;
                        width: 14px;
                        height: 14px;
                        border-radius: 50%;
                        background: white;
                        cursor: pointer;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                    }
                    
                    #audioVolumeSlider::-moz-range-thumb {
                        width: 14px;
                        height: 14px;
                        border-radius: 50%;
                        background: white;
                        cursor: pointer;
                        border: none;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                    }
                </style>
            `;
            
            // Add volume control event listener
            const volumeSlider = document.getElementById('audioVolumeSlider');
            const volumePercentage = document.getElementById('volumePercentage');
            
            if (volumeSlider && audio) {
                volumeSlider.addEventListener('input', function() {
                    const volume = this.value / 100;
                    audio.volume = volume;
                    volumePercentage.textContent = `${this.value}%`;
                    localStorage.setItem('audioVolume', volume.toString());
                    console.log('🎵 Volume changed to:', this.value + '%');
                });
            }
        }
    }
    
    // Manual play audio (for when autoplay is blocked)
    window.manualPlayAudio = function() {
        if (currentAudio) {
            currentAudio.play().then(() => {
                console.log('🎵 Audio playing after user interaction');
                // Update popup back to playing state
                const popup = document.getElementById('audioPopup');
                if (popup) {
                    popup.querySelector('button[onclick="manualPlayAudio()"]').parentElement.parentElement.innerHTML = `
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="bi bi-volume-up-fill" style="font-size: 18px; animation: pulse 1.5s infinite;"></i>
                            <div style="flex: 1;">
                                <div style="font-weight: bold; margin-bottom: 2px;">🎵 Playing Audio</div>
                                <div style="font-size: 12px; opacity: 0.9;">Audio sedang diputar</div>
                            </div>
                            <button onclick="stopAudio()" style="
                                background: rgba(255,255,255,0.2);
                                border: none;
                                color: white;
                                width: 30px;
                                height: 30px;
                                border-radius: 50%;
                                cursor: pointer;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <i class="bi bi-x" style="font-size: 16px;"></i>
                            </button>
                        </div>
                    `;
                }
            }).catch(error => {
                console.error('🎵 Manual play failed:', error);
                alert('Gagal memutar audio: ' + error.message);
            });
        }
    };
    
    // Stop audio
    window.stopAudio = function() {
        if (currentAudio) {
            currentAudio.pause();
            currentAudio.remove();
            currentAudio = null;
        }
        hideAudioPopup();
    };
    
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
