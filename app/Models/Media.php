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
                      ->orWhere('end_date', '>=', $currentDate);
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
        // Use the direct media serving route instead of relying on symbolic links
        return route('media.serve', ['path' => $this->file_path]);
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
}