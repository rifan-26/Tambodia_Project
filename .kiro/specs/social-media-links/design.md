# Design Document - Social Media Links Support

## Overview

Memperluas fitur input video untuk mendukung link dari berbagai platform media sosial (TikTok, Instagram, Facebook, Twitter) selain YouTube yang sudah ada. Sistem akan mendeteksi platform secara otomatis dari URL dan menyimpan informasi platform untuk digunakan saat rendering embed player.

## Architecture

### Current Flow (YouTube Only)
```
1. User selects "Video" type
2. User enters YouTube URL
3. System saves URL to database (file_path)
4. Landing page displays YouTube embed
```

### New Flow (Multi-Platform)
```
1. User selects "Video" type
2. User enters URL from any supported platform
3. JavaScript detects platform from URL pattern
4. Shows platform badge/icon as feedback
5. System saves:
   - URL to file_path
   - Platform to video_platform (youtube/tiktok/instagram/facebook/twitter)
6. Landing page detects platform and uses appropriate embed code
```

## Components and Interfaces

### 1. Frontend - Input Form (input.blade.php)

**Current Structure:**
```html
<div id="videoLinkGroup" class="mt-3 d-none">
  <label>Link Video (YouTube atau URL video lain)</label>
  <input type="url" id="videoUrl" name="video_url" 
         placeholder="https://www.youtube.com/watch?v=...">
</div>
```

**Enhanced Structure:**
```html
<div id="videoLinkGroup" class="mt-3 d-none">
  <label>Link Video (YouTube, TikTok, Instagram, Facebook, Twitter)</label>
  
  <!-- Platform Badge (shows detected platform) -->
  <div id="platformBadge" class="platform-badge d-none mb-2">
    <i class="platform-icon"></i>
    <span class="platform-name"></span>
  </div>
  
  <input type="url" id="videoUrl" name="video_url" 
         placeholder="https://www.youtube.com/watch?v=... atau https://www.tiktok.com/@user/video/...">
  
  <!-- Hidden field for platform -->
  <input type="hidden" id="videoPlatform" name="video_platform" value="">
  
  <div class="form-text">
    Platform yang didukung: YouTube, TikTok, Instagram, Facebook, Twitter
  </div>
</div>
```

**JavaScript Detection:**
```javascript
// Platform detection patterns
const platformPatterns = {
    youtube: /(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/,
    tiktok: /tiktok\.com\/@[\w.-]+\/video\/(\d+)|vm\.tiktok\.com\/([a-zA-Z0-9]+)/,
    instagram: /instagram\.com\/(?:p|reel|tv)\/([a-zA-Z0-9_-]+)/,
    facebook: /facebook\.com\/(?:watch\/?\?v=|[\w.-]+\/videos\/)(\d+)|fb\.watch\/([a-zA-Z0-9_-]+)/,
    twitter: /(?:twitter\.com|x\.com)\/[\w]+\/status\/(\d+)/
};

function detectPlatform(url) {
    for (const [platform, pattern] of Object.entries(platformPatterns)) {
        if (pattern.test(url)) {
            return platform;
        }
    }
    return null;
}

// Real-time detection on input
document.getElementById('videoUrl').addEventListener('input', function() {
    const url = this.value.trim();
    const platform = detectPlatform(url);
    
    if (platform) {
        showPlatformBadge(platform);
        document.getElementById('videoPlatform').value = platform;
    } else if (url) {
        showPlatformBadge('unknown');
        document.getElementById('videoPlatform').value = '';
    } else {
        hidePlatformBadge();
    }
});
```

### 2. Backend - Media Controller

**Database Migration (if needed):**
```php
// Add video_platform column to media table
Schema::table('media', function (Blueprint $table) {
    $table->string('video_platform')->nullable()->after('file_path');
    // Values: 'youtube', 'tiktok', 'instagram', 'facebook', 'twitter', null
});
```

**Media Model Update:**
```php
protected $fillable = [
    'name',
    'type',
    'file_path',
    'video_platform',  // NEW
    'user_id',
    // ... other fields
];
```

**Controller Validation:**
```php
public function store(Request $request)
{
    $rules = [
        'namaFile' => 'required|string|max:255',
        'jenisMedia' => 'required|in:gambar,video,audio',
    ];
    
    if ($request->jenisMedia === 'video' && $request->video_url) {
        $rules['video_url'] = 'required|url';
        $rules['video_platform'] = 'required|in:youtube,tiktok,instagram,facebook,twitter';
    }
    
    $validated = $request->validate($rules);
    
    // Save media
    $media = new Media();
    $media->name = $validated['namaFile'];
    $media->type = 'Video';
    $media->file_path = $validated['video_url'];
    $media->video_platform = $validated['video_platform'];
    $media->user_id = auth()->id();
    $media->save();
    
    return response()->json(['success' => true]);
}
```

### 3. Frontend - Landing Page Display

**Platform-Specific Embed Code:**

```php
@if($media->video_platform)
    {{-- External video link --}}
    @if($media->video_platform === 'youtube')
        <iframe src="{{ getYouTubeEmbedUrl($media->file_path) }}" 
                frameborder="0" allowfullscreen></iframe>
                
    @elseif($media->video_platform === 'tiktok')
        <blockquote class="tiktok-embed" 
                    cite="{{ $media->file_path }}" 
                    data-video-id="{{ getTikTokVideoId($media->file_path) }}">
        </blockquote>
        <script async src="https://www.tiktok.com/embed.js"></script>
        
    @elseif($media->video_platform === 'instagram')
        <blockquote class="instagram-media" 
                    data-instgrm-permalink="{{ $media->file_path }}">
        </blockquote>
        <script async src="//www.instagram.com/embed.js"></script>
        
    @elseif($media->video_platform === 'facebook')
        <iframe src="https://www.facebook.com/plugins/video.php?href={{ urlencode($media->file_path) }}" 
                frameborder="0" allowfullscreen></iframe>
                
    @elseif($media->video_platform === 'twitter')
        <blockquote class="twitter-tweet">
            <a href="{{ $media->file_path }}"></a>
        </blockquote>
        <script async src="https://platform.twitter.com/widgets.js"></script>
    @endif
@else
    {{-- Local video file --}}
    <video src="/storage/{{ $media->file_path }}" controls></video>
@endif
```

**Helper Functions:**
```php
// In app/Helpers/VideoHelper.php or in blade directly

function getYouTubeEmbedUrl($url) {
    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches);
    $videoId = $matches[1] ?? null;
    return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $url;
}

function getTikTokVideoId($url) {
    preg_match('/video\/(\d+)/', $url, $matches);
    return $matches[1] ?? null;
}

function getInstagramPostId($url) {
    preg_match('/\/(?:p|reel|tv)\/([a-zA-Z0-9_-]+)/', $url, $matches);
    return $matches[1] ?? null;
}

function getFacebookVideoId($url) {
    preg_match('/(?:watch\/?\?v=|videos\/)(\d+)/', $url, $matches);
    return $matches[1] ?? null;
}

function getTwitterStatusId($url) {
    preg_match('/status\/(\d+)/', $url, $matches);
    return $matches[1] ?? null;
}
```

## Data Models

### Media Model
```php
class Media extends Model
{
    protected $fillable = [
        'name',
        'type',              // 'Gambar', 'Video', 'Audio'
        'file_path',         // For video links: full URL, for uploads: storage path
        'video_platform',    // 'youtube', 'tiktok', 'instagram', 'facebook', 'twitter', null
        'user_id',
        'show_on_landing',
        'layout_order',
    ];
    
    // Check if video is external link
    public function isExternalVideo()
    {
        return $this->type === 'Video' && !empty($this->video_platform);
    }
    
    // Check if video is uploaded file
    public function isUploadedVideo()
    {
        return $this->type === 'Video' && empty($this->video_platform);
    }
    
    // Get embed URL for external videos
    public function getEmbedUrl()
    {
        if (!$this->isExternalVideo()) {
            return null;
        }
        
        switch ($this->video_platform) {
            case 'youtube':
                return $this->getYouTubeEmbedUrl();
            case 'tiktok':
                return $this->file_path; // TikTok uses blockquote embed
            case 'instagram':
                return $this->file_path; // Instagram uses blockquote embed
            case 'facebook':
                return "https://www.facebook.com/plugins/video.php?href=" . urlencode($this->file_path);
            case 'twitter':
                return $this->file_path; // Twitter uses blockquote embed
            default:
                return $this->file_path;
        }
    }
    
    private function getYouTubeEmbedUrl()
    {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->file_path, $matches);
        $videoId = $matches[1] ?? null;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $this->file_path;
    }
}
```

### Database Schema
```sql
-- media table
CREATE TABLE media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type ENUM('Gambar', 'Video', 'Audio') NOT NULL,
    file_path TEXT NOT NULL,
    video_platform VARCHAR(50) NULL,  -- NEW COLUMN
    user_id BIGINT UNSIGNED NOT NULL,
    show_on_landing BOOLEAN DEFAULT FALSE,
    layout_order INT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Error Handling

### 1. Invalid URL
```javascript
if (!isValidUrl(url)) {
    showError('URL tidak valid. Pastikan URL dimulai dengan http:// atau https://');
    return false;
}
```

### 2. Unsupported Platform
```javascript
if (!platform && url) {
    showWarning('Platform tidak dikenali. Video mungkin tidak dapat ditampilkan dengan baik.');
    // Still allow submission but warn user
}
```

### 3. Embed Loading Failure
```javascript
// On landing page
iframe.addEventListener('error', function() {
    this.parentElement.innerHTML = '<div class="embed-error">Video tidak dapat dimuat</div>';
});
```

### 4. Platform API Limits
- TikTok: May have embed restrictions
- Instagram: Requires public posts
- Facebook: May require app permissions
- Twitter: Should work for public tweets

## Testing Strategy

### 1. URL Detection Tests
```javascript
// Test YouTube URLs
testDetection('https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'youtube');
testDetection('https://youtu.be/dQw4w9WgXcQ', 'youtube');

// Test TikTok URLs
testDetection('https://www.tiktok.com/@user/video/1234567890', 'tiktok');
testDetection('https://vm.tiktok.com/ZMabcdef/', 'tiktok');

// Test Instagram URLs
testDetection('https://www.instagram.com/p/ABC123/', 'instagram');
testDetection('https://www.instagram.com/reel/XYZ789/', 'instagram');

// Test Facebook URLs
testDetection('https://www.facebook.com/watch/?v=1234567890', 'facebook');
testDetection('https://fb.watch/abc123/', 'facebook');

// Test Twitter URLs
testDetection('https://twitter.com/user/status/1234567890', 'twitter');
testDetection('https://x.com/user/status/1234567890', 'twitter');
```

### 2. Manual Testing Scenarios

**Scenario 1: Add YouTube video**
- Input: `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
- Expected: YouTube badge appears, video saves, displays correctly

**Scenario 2: Add TikTok video**
- Input: `https://www.tiktok.com/@user/video/1234567890`
- Expected: TikTok badge appears, video saves, displays correctly

**Scenario 3: Add Instagram reel**
- Input: `https://www.instagram.com/reel/ABC123/`
- Expected: Instagram badge appears, video saves, displays correctly

**Scenario 4: Invalid URL**
- Input: `not-a-url`
- Expected: Error message, form doesn't submit

**Scenario 5: Unsupported platform**
- Input: `https://vimeo.com/123456`
- Expected: Warning message, can still submit

## Implementation Notes

### Critical Changes Required

1. **Database Migration**
   - Add `video_platform` column to `media` table
   - Run migration: `php artisan migrate`

2. **Input Form (input.blade.php)**
   - Add platform badge display
   - Add hidden field for video_platform
   - Add JavaScript for platform detection
   - Update placeholder text

3. **Media Controller**
   - Update validation rules
   - Save video_platform field
   - Handle both upload and link scenarios

4. **Landing Page (landingpage.blade.php)**
   - Add platform-specific embed code
   - Load platform embed scripts
   - Handle embed errors gracefully

5. **Media Model**
   - Add video_platform to fillable
   - Add helper methods for embed URLs
   - Add methods to check video type

### Platform-Specific Considerations

**YouTube:**
- ✅ Most reliable
- ✅ No special requirements
- ✅ Works in iframe

**TikTok:**
- ⚠️ Requires embed script
- ⚠️ May not work for private videos
- ⚠️ Embed may be blocked in some regions

**Instagram:**
- ⚠️ Requires embed script
- ⚠️ Only works for public posts
- ⚠️ May have loading delays

**Facebook:**
- ⚠️ May require app permissions
- ⚠️ Privacy settings affect embeds
- ⚠️ Works best with public videos

**Twitter/X:**
- ⚠️ Requires embed script
- ⚠️ Only works for public tweets
- ⚠️ May have loading delays

### Performance Considerations

- Embed scripts loaded asynchronously
- Consider lazy loading for multiple videos
- Cache platform detection results
- Limit number of embeds per page

### Security Considerations

- Validate all URLs server-side
- Use HTTPS only
- Sanitize URLs before storing
- Use CSP headers for iframe security
- Don't execute user-provided JavaScript
