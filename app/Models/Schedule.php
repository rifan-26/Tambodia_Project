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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'time' => 'datetime:H:i',
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
        return $checkDate >= $this->start_date && $checkDate <= $this->end_date;
    }

    public function scopeActive($query, $date = null)
    {
        $checkDate = $date ?? now()->toDateString();
        return $query->where('start_date', '<=', $checkDate)
                    ->where('end_date', '>=', $checkDate);
    }
}