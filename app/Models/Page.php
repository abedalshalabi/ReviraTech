<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'template',
        'meta_data',
        'is_active',
        'is_homepage',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'is_active' => 'boolean',
        'is_homepage' => 'boolean',
    ];

    public $translatable = [
        'title',
        'summary',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Scope for active pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for homepage
     */
    public function scopeHomepage($query)
    {
        return $query->where('is_homepage', true);
    }

    /**
     * Get homepage
     */
    public static function getHomepage()
    {
        return static::homepage()->active()->first();
    }

    /**
     * Get page by slug
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->active()->first();
    }

    /**
     * Get excerpt from content
     */
    public function getExcerptAttribute()
    {
        if ($this->summary) {
            return $this->summary;
        }

        return \Illuminate\Support\Str::limit(strip_tags($this->content), 200);
    }
}
