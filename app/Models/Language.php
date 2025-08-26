<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'locale',
        'flag',
        'is_rtl',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'is_rtl' => 'boolean',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Get the default language
     */
    public static function getDefault()
    {
        return static::where('is_default', true)->first();
    }

    /**
     * Get active languages
     */
    public static function getActive()
    {
        return static::where('is_active', true)->orderBy('sort_order')->get();
    }

    /**
     * Scope for active languages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get language direction class
     */
    public function getDirectionClass()
    {
        return $this->is_rtl ? 'rtl' : 'ltr';
    }
}
