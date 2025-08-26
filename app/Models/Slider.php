<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_url',
        'video_url',
        'sort_order',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public $translatable = [
        'title',
        'description',
        'button_text',
    ];

    /**
     * Scope for active sliders
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for current sliders (within date range)
     */
    public function scopeCurrent($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', now());
        })->where(function ($q) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', now());
        });
    }

    /**
     * Get active and current sliders ordered by sort order
     */
    public static function getActiveSliders()
    {
        return static::active()->current()->orderBy('sort_order')->get();
    }
}
