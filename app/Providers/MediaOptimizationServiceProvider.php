<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Cache;

class MediaOptimizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Note: Cache tagging removed as file/database cache drivers don't support it
        // Media optimization can be implemented with other approaches if needed
    }
}