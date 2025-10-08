<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_id',
        'start_date',
        'end_date',
        'day_of_week',
        'time',
        'layout_position',
        'layout_positions',
        'is_active',
        'auto_rotate'
    ];

    protected $casts = [
        'start_date' => 'date',
        'time' => 'datetime:H:i',
        'layout_positions' => 'array',
        'layout_settings' => 'array',
        'auto_rotate' => 'boolean',
    ];

    // Relationships
    public function media()
    {
        return $this->belongsTo(Media::class);
    }


    // Helper methods
    public function isActive($date = null)
    {
        $checkDate = $date ?? now()->toDateString();
        return $checkDate >= $this->start_date;
    }

    public function scopeActive($query, $date = null)
    {
        $checkDate = $date ?? now()->toDateString();
        return $query->where('start_date', '<=', $checkDate)
                    ->where('is_active', true);
    }

    // Check if schedule is currently active based on date, time and day
    public function isCurrentlyActive()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = $this->getDayOfWeekInIndonesian($now->dayOfWeek);

        // Check date range
        if (!$this->isActive($currentDate)) {
            return false;
        }

        // Check day of week if specified
        if ($this->day_of_week && $this->day_of_week !== $currentDay) {
            return false;
        }

        // Check time if specified
        if ($this->time && $this->time->format('H:i') !== $currentTime) {
            return false;
        }

        return $this->is_active;
    }

    // Convert day number to Indonesian day name
    private function getDayOfWeekInIndonesian($dayNumber)
    {
        $days = [
            0 => 'minggu',
            1 => 'senin', 
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu'
        ];

        return $days[$dayNumber] ?? null;
    }

    // Get layout configuration
    public function getLayoutConfig()
    {
        return [
            'type' => $this->layout_type,
            'positions' => $this->layout_positions ?? [],
            'duration' => $this->display_duration,
            'auto_rotate' => $this->auto_rotate,
            'settings' => $this->layout_settings ?? []
        ];
    }

    // Scope for currently active schedules
    public function scopeCurrentlyActive($query)
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentDay = $this->getDayOfWeekInIndonesian($now->dayOfWeek);
        
        return $query->where('is_active', true)
                    ->where('start_date', '<=', $currentDate)
                    ->where(function($q) use ($currentDay) {
                        $q->whereNull('day_of_week')
                          ->orWhere('day_of_week', $currentDay);
                    });
    }
}