<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_translatable',
    ];

    protected $casts = [
        'is_translatable' => 'boolean',
    ];

    /**
     * Boot the model and add event listeners
     */
    protected static function boot()
    {
        parent::boot();
        
        // Clear cache when settings are modified
        static::saved(function () {
            cache()->forget('view_composer.settings');
        });
        
        static::deleted(function () {
            cache()->forget('view_composer.settings');
        });
    }

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value
     */
    public static function setValue($key, $value, $type = 'text', $group = 'general')
    {
        $result = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );
        
        // Clear cache when settings are updated
        cache()->forget('view_composer.settings');
        
        return $result;
    }

    /**
     * Get settings by group
     */
    public static function getByGroup($group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Get all settings as array
     */
    public static function getAllAsArray()
    {
        return static::all()->pluck('value', 'key')->toArray();
    }
}
