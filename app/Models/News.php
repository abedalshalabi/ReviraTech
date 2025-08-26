<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'author',
        'source',
        'source_url',
        'tags',
        'is_active',
        'is_featured',
        'published_at',
        'views_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public $translatable = [
        'title',
        'summary',
        'content',
        'author',
        'source',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Scope for active news
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured news
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for published news
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    /**
     * Scope for recent news
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get related news by tags
     */
    public function getRelatedNews($limit = 6)
    {
        if (empty($this->tags)) {
            return static::active()->published()
                ->where('id', '!=', $this->id)
                ->recent($limit)
                ->get();
        }

        $query = static::active()->published()
            ->where('id', '!=', $this->id);

        // Search for news that have any of the current news tags
        foreach ($this->tags as $tag) {
            $query->orWhereJsonContains('tags', $tag);
        }

        return $query->recent($limit)->get();
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
