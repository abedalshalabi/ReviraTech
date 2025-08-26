<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Category;
use App\Helpers\LanguageHelper;

class ViewServiceProvider extends ServiceProvider
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
        // Share common data with all views with caching
        // Skip for admin panel and API routes to improve performance
        View::composer('*', function ($view) {
            // Skip view composer for admin panel routes to improve boot time
            if (request()->is('admin/*') || request()->is('api/*')) {
                return;
            }
            
            $view->with([
                'settings' => cache()->remember('view_composer.settings', 7200, function () {
                    return Setting::getAllAsArray();
                }),
                'languages' => cache()->remember('view_composer.languages', 7200, function () {
                    return LanguageHelper::getLanguageSwitcherData();
                }),
                'isRTL' => cache()->remember('view_composer.is_rtl', 7200, function () {
                    return LanguageHelper::isRTL();
                }),
                'directions' => cache()->remember('view_composer.directions', 7200, function () {
                    return LanguageHelper::getDirection();
                }),
                'mainCategories' => cache()->remember('view_composer.main_categories', 7200, function () {
                    return Category::active()->root()->with('children')->get();
                }),
            ]);
        });
    }
}