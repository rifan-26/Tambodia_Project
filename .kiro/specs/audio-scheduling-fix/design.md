# Design Document - Audio Scheduling Fix

## Overview

Perbaikan sistem penjadwalan audio untuk memastikan audio dapat diputar sesuai jadwal yang ditentukan. Masalah utama terletak pada logika query di backend (DashboardController) yang menggunakan kondisi `time = currentTime` yang terlalu ketat, sehingga audio hanya akan diputar pada menit yang tepat. Solusinya adalah mengubah logika menjadi `time <= currentTime` agar audio dapat diputar kapan saja setelah waktu jadwal tercapai.

## Architecture

### Current Flow (Broken)
```
1. Frontend (global-audio-system.blade.php) checks every 5 seconds
2. Calls API: GET /api/dashboard/audio-schedules
3. Backend (DashboardController::getActiveAudioSchedulesApi) queries with:
   - time = currentTime (TOO STRICT - only matches exact minute)
4. Returns empty result if not exact match
5. Frontend receives no schedules
6. Audio never plays
```

### Fixed Flow
```
1. Frontend (global-audio-system.blade.php) checks every 5 seconds
2. Calls API: GET /api/dashboard/audio-schedules
3. Backend (DashboardController::getActiveAudioSchedulesApi) queries with:
   - time <= currentTime (FLEXIBLE - matches any time after schedule)
4. Returns active schedules
5. Frontend checks if already played today (localStorage)
6. If not played, play audio and mark as played
7. Audio plays successfully
```

## Components and Interfaces

### 1. Backend API (DashboardController)

**Method:** `getActiveAudioSchedulesApi()`

**Current Logic Issues:**
```php
->where(function($query) use ($currentTime) {
    $query->whereNull('time')
          ->orWhere('time', '=', $currentTime)  // ❌ TOO STRICT
          ->orWhere('time', '<=', $currentTime);
})
```

**Fixed Logic:**
```php
->where(function($query) use ($currentTime) {
    $query->whereNull('time')
          ->orWhere('time', '<=', $currentTime);  // ✅ CORRECT
})
```

**Query Conditions:**
- `start_date <= currentDate` - Schedule has started
- `end_date > currentDate OR end_date IS NULL` - Schedule hasn't ended
- `day_of_week = currentDay OR day_of_week IS NULL` - Matches day or applies to all days
- `time <= currentTime OR time IS NULL` - Time has passed or applies all day

**Response Format:**
```json
{
  "success": true,
  "schedules": [
    {
      "id": 1,
      "media": {
        "id": 5,
        "name": "Audio Pagi.mp3",
        "file_path": "audio/audio_pagi.mp3",
        "type": "Audio"
      },
      "display_duration": null,
      "use_audio_duration": true,
      "time": "08:00",
      "start_date": "2025-01-01",
      "end_date": null,
      "is_currently_active": true
    }
  ]
}
```

### 2. Frontend Audio System (global-audio-system.blade.php)

**Key Functions:**

1. **`initAudioSystem()`**
   - Load played schedules from localStorage
   - Start interval check every 5 seconds
   - Initialize tracking system

2. **`checkAudioSchedule()`**
   - Skip if audio currently playing
   - Fetch active schedules from API
   - Find first unplayed schedule
   - Play audio and mark as played

3. **`playAudio(schedule)`**
   - Create audio element
   - Set volume from localStorage (default 70%)
   - Show popup notification
   - Handle autoplay blocking
   - Clean up on finish/error

4. **`loadPlayedSchedules()`**
   - Load from localStorage
   - Check if new day (reset if yes)
   - Initialize Set for tracking

5. **`savePlayedSchedules()`**
   - Save to localStorage
   - Store current date for reset check

6. **`getScheduleKey(schedule)`**
   - Generate unique key: `{media_id}_{date}`
   - Prevents replay on same day

**Tracking Logic:**
```javascript
// Generate unique key for each schedule per day
function getScheduleKey(schedule) {
    const today = new Date().toISOString().split('T')[0]; // YYYY-MM-DD
    return `${schedule.media.id}_${today}`;
}

// Check if already played
const scheduleKey = getScheduleKey(schedule);
if (!playedScheduleIds.has(scheduleKey)) {
    playAudio(schedule);
    playedScheduleIds.add(scheduleKey);
    savePlayedSchedules();
}
```

**Reset Logic:**
```javascript
// Reset tracking at midnight
const today = new Date().toDateString();
const storedDate = localStorage.getItem('playedSchedulesDate');

if (storedDate !== today) {
    playedScheduleIds = new Set();
    localStorage.setItem('playedSchedulesDate', today);
    localStorage.removeItem('playedScheduleIds');
}
```

## Data Models

### Schedule Model
```php
protected $fillable = [
    'media_id',
    'start_date',
    'end_date',
    'day_of_week',  // senin, selasa, rabu, kamis, jumat, sabtu, minggu, null
    'time',         // HH:mm format, null = all day
    'layout_position',
    'is_active',
];

protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'time' => 'datetime:H:i',
];
```

### Media Model
```php
protected $fillable = [
    'name',
    'type',         // 'Audio', 'Video', 'Gambar'
    'file_path',
    'user_id',
];
```

### LocalStorage Structure
```javascript
{
    "playedScheduleIds": ["5_2025-01-23", "7_2025-01-23"],
    "playedSchedulesDate": "Thu Jan 23 2025",
    "audioVolume": "0.7"
}
```

## Error Handling

### 1. API Errors
```javascript
try {
    const response = await fetch('/api/dashboard/audio-schedules');
    if (response.ok) {
        const data = await response.json();
        // Process data
    } else {
        console.error('API response not ok:', response.status);
    }
} catch (error) {
    console.error('Audio check error:', error);
}
```

### 2. Audio Loading Errors
```javascript
audio.addEventListener('error', (e) => {
    console.error('Audio error:', e);
    console.error('Failed to load:', audio.src);
    audio.remove();
    currentAudio = null;
    hideAudioPopup();
    alert('Gagal memutar audio. File mungkin tidak ditemukan atau format tidak didukung.');
});
```

### 3. Autoplay Blocking
```javascript
audio.play().then(() => {
    console.log('Audio playing automatically');
}).catch(error => {
    console.warn('Autoplay blocked by browser:', error);
    showPlayButton(schedule, audio);
});
```

### 4. File Not Found
- Check if file exists in `/storage/{file_path}`
- Show clear error message to user
- Log error to console for debugging

## Testing Strategy

### 1. Unit Tests (Backend)
- Test query conditions with various time scenarios
- Test day_of_week matching (Indonesian days)
- Test date range validation
- Test null handling (time, end_date, day_of_week)

### 2. Integration Tests
- Test API endpoint returns correct schedules
- Test schedule activation at exact time
- Test schedule activation after time has passed
- Test schedule with no time (all day)
- Test schedule with specific day
- Test schedule with date range

### 3. Manual Testing Scenarios

**Scenario 1: Audio with specific time**
- Create schedule: Audio at 14:00
- Expected: Audio plays at 14:00 or any time after 14:00 (same day)

**Scenario 2: Audio without time**
- Create schedule: Audio on 2025-01-23, no time
- Expected: Audio plays anytime on 2025-01-23

**Scenario 3: Audio with specific day**
- Create schedule: Audio every Monday at 09:00
- Expected: Audio plays only on Mondays at/after 09:00

**Scenario 4: Audio with date range**
- Create schedule: Audio from 2025-01-20 to 2025-01-25
- Expected: Audio plays every day in that range

**Scenario 5: Tracking system**
- Play audio once
- Refresh page
- Expected: Audio should not play again (already played today)

**Scenario 6: Daily reset**
- Play audio today
- Wait until next day (or change system date)
- Expected: Audio can play again

### 4. Browser Testing
- Test autoplay behavior in Chrome, Firefox, Edge
- Test volume control persistence
- Test localStorage functionality
- Test popup display and controls

## Implementation Notes

### Critical Changes Required

1. **DashboardController.php** - Line ~195
   ```php
   // REMOVE this line:
   ->orWhere('time', '=', $currentTime)
   
   // KEEP only:
   ->orWhere('time', '<=', $currentTime)
   ```

2. **Verify end_date logic** - Line ~190
   ```php
   // Current (might be wrong):
   ->orWhere('end_date', '>', $currentDate)
   
   // Should be:
   ->orWhere('end_date', '>=', $currentDate)
   ```

### No Changes Needed

- Frontend code (global-audio-system.blade.php) is already correct
- Tracking system is working properly
- Popup UI and controls are functional
- Volume persistence is working

### Debugging Tools

Add console logging to verify:
```javascript
console.log('🎵 Current time:', currentTime);
console.log('🎵 Schedule time:', schedule.time);
console.log('🎵 Time check passed:', currentTime >= schedule.time);
console.log('🎵 Already played:', playedScheduleIds.has(scheduleKey));
```

## Performance Considerations

- API called every 5 seconds (reasonable interval)
- Query uses indexes on start_date, time, day_of_week
- LocalStorage operations are fast
- Audio loading is async (non-blocking)
- Limit query results to prevent memory issues

## Security Considerations

- CSRF token required for API calls
- Authentication required (dashboard only)
- File path validation (storage/public only)
- No user input in audio playback
- LocalStorage is client-side only (no sensitive data)
