<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'file_path',
        'video_platform',  // Platform for external video links: youtube, tiktok, instagram, facebook, twitter
        'original_filename',
        'date',
        'show_on_landing',
        'layout_order',
    ];

    protected $casts = [
        'date' => 'date',
        'show_on_landing' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Check if media has active schedules
     */
    public function hasActiveSchedules()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->translatedFormat('l'));

        // Map English day names to Indonesian
        $dayMap = [
            'monday' => 'senin',
            'tuesday' => 'selasa', 
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu'
        ];

        $indonesianDay = $dayMap[$currentDay] ?? null;

        return $this->schedules()
            ->where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>', $currentDate);
            })
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '=', $currentTime)
                      ->orWhere('time', '<=', $currentTime);
            })
            ->exists();
    }

    // Helper methods
    public function getFileUrlAttribute()
    {
        // Use Laravel's asset helper to generate the correct URL
        return asset('storage/' . $this->file_path);
    }
    
    /**
     * Get the URL for the media file
     * This is an alias of getFileUrlAttribute for backward compatibility
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->file_url;
    }

    public function isImage()
    {
        return $this->type === 'Gambar';
    }

    public function isVideo()
    {
        return $this->type === 'Video';
    }

    public function isAudio()
    {
        return $this->type === 'Audio';
    }

    // Scope untuk filter berdasarkan type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForLanding($query)
    {
        return $query->where('show_on_landing', true);
    }

    /**
     * Check if video is from external link (social media)
     * 
     * @return bool
     */
    public function isExternalVideo()
    {
        return $this->type === 'Video' && !empty($this->video_platform);
    }

    /**
     * Check if video is uploaded file
     * 
     * @return bool
     */
    public function isUploadedVideo()
    {
        return $this->type === 'Video' && empty($this->video_platform);
    }

    /**
     * Get embed URL for external videos
     * Returns null for uploaded videos
     * 
     * @return string|null
     */
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
                return "https://www.facebook.com/plugins/video.php?href=" . urlencode($this->file_path) . "&show_text=false&autoplay=true&muted=true";
            case 'twitter':
                return $this->file_path; // Twitter uses blockquote embed
            default:
                return $this->file_path;
        }
    }

    /**
     * Extract YouTube video ID and generate embed URL
     * 
     * @return string
     */
    private function getYouTubeEmbedUrl()
    {
        // Match various YouTube URL formats
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->file_path, $matches);
        $videoId = $matches[1] ?? null;
        
        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&loop=1&playlist={$videoId}&rel=0";
        }
        
        return $this->file_path;
    }

    /**
     * Get video ID for TikTok
     * 
     * @return string|null
     */
    public function getTikTokVideoId()
    {
        preg_match('/video\/(\d+)/', $this->file_path, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get post ID for Instagram
     * 
     * @return string|null
     */
    public function getInstagramPostId()
    {
        preg_match('/\/(?:p|reel|tv)\/([a-zA-Z0-9_-]+)/', $this->file_path, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get status ID for Twitter
     * 
     * @return string|null
     */
    public function getTwitterStatusId()
    {
        preg_match('/status\/(\d+)/', $this->file_path, $matches);
        return $matches[1] ?? null;
    }
}