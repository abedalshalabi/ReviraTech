<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Agent extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'company_name',
        'logo',
        'description',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'country',
        'latitude',
        'longitude',
        'working_hours',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public $translatable = [
        'name',
        'company_name',
        'description',
        'address',
        'city',
        'country',
    ];

    /**
     * Scope for active agents
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get agents by country
     */
    public function scopeByCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    /**
     * Get agents by city
     */
    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([$this->address, $this->city, $this->country]);
        return implode(', ', $parts);
    }

    /**
     * Get coordinates for map
     */
    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }
        return null;
    }
}
