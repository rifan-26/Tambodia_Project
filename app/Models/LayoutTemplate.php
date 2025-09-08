<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoutTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'template_data',
        'background_image_id',
        'is_public'
    ];

    protected $casts = [
        'template_data' => 'array',
        'is_public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function backgroundMedia()
    {
        return $this->belongsTo(Media::class, 'background_image_id');
    }
}
