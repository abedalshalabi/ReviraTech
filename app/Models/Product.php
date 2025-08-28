<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Product extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'sku',
        'model',
        'brand',
        'country_of_origin',
        'category_id',
        'technical_specifications',
        'features',
        'applications',
        'warranty',
        'image',
        'video_url',
        'catalog_url',
        'is_active',
        'is_featured',
        'is_new',
        'is_bestseller',
        'sort_order',
        'views_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'technical_specifications' => 'array',
        'features' => 'array',
        'applications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_bestseller' => 'boolean',
    ];

    public $translatable = [
        'name',
        'short_description',
        'description',
        'technical_specifications',
        'features',
        'applications',
        'warranty',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get related products
     */
    public function relatedProducts()
    {
        return $this->category->products()
            ->where('id', '!=', $this->id)
            ->where('is_active', true)
            ->limit(6)
            ->get();
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for new products
     */
    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    /**
     * Scope for bestseller products
     */
    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    /**
     * Get the final price (sale price if available, otherwise regular price)
     */
    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Check if product is on sale
     */
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get the main product image (fallback to first media image)
     */
    public function getImageAttribute()
    {
        // First try to get from media library
        $firstImage = $this->getFirstMediaUrl('images');
        if ($firstImage) {
            return $firstImage;
        }
        
        // Fallback to the image field in database
        return $this->attributes['image'] ?? null;
    }

    /**
     * Get all product images
     */
    public function getImagesAttribute()
    {
        $mediaImages = $this->getMedia('images');
        $images = [];
        
        foreach ($mediaImages as $media) {
            $images[] = [
                'url' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
                'preview' => $media->getUrl('preview'),
                'alt' => $this->name,
                'name' => $media->name,
                'size' => $media->size
            ];
        }
        
        // If no media images, use the database image field as fallback
        if (empty($images) && isset($this->attributes['image'])) {
            $images[] = [
                'url' => $this->attributes['image'],
                'thumb' => $this->attributes['image'],
                'preview' => $this->attributes['image'],
                'alt' => $this->name,
                'name' => 'Product Image',
                'size' => null
            ];
        }
        
        return $images;
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);

        $this->addMediaCollection('documents')
            ->useDisk('public')
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 300, 300)
            ->sharpen(10)
            ->optimize()
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->fit(Fit::Contain, 800, 600)
            ->sharpen(10)
            ->optimize()
            ->nonQueued();
    }
}
