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

    // Helper methods
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
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