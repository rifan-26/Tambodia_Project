<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LayoutTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'thumbnail_path',
        'grid_type',
        'grid_config',
        'elements',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'grid_config' => 'array',
        'elements' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Relationship dengan User (creator)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get media IDs used in elements
     */
    public function getUsedMediaIds()
    {
        $mediaIds = [];
        
        if ($this->elements && is_array($this->elements)) {
            foreach ($this->elements as $element) {
                if (isset($element['type']) && $element['type'] === 'image' && isset($element['mediaId'])) {
                    $mediaIds[] = $element['mediaId'];
                }
            }
        }
        
        return array_unique($mediaIds);
    }

    /**
     * Get media objects yang digunakan dalam template
     */
    public function getUsedMedia()
    {
        $mediaIds = $this->getUsedMediaIds();
        
        if (empty($mediaIds)) {
            return collect();
        }
        
        return Media::whereIn('id', $mediaIds)->get();
    }

    /**
     * Set template sebagai active dan deactivate yang lain
     */
    public function activate()
    {
        // Deactivate all other templates
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        // Activate this template
        $this->is_active = true;
        $this->save();
        
        return $this;
    }

    /**
     * Deactivate template
     */
    public function deactivate()
    {
        $this->is_active = false;
        $this->save();
        
        return $this;
    }

    /**
     * Scope untuk mendapatkan template yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mendapatkan template berdasarkan creator
     */
    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }
}
