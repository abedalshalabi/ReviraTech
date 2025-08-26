<?php

if (!function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        static $settings = null;
        
        if ($settings === null) {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        }
        
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('active_languages')) {
    /**
     * Get all active languages
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function active_languages()
    {
        return \App\Models\Language::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}

if (!function_exists('default_language')) {
    /**
     * Get the default language
     *
     * @return \App\Models\Language|null
     */
    function default_language()
    {
        return \App\Models\Language::where('is_default', true)->first() 
            ?? \App\Models\Language::where('is_active', true)->first();
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get the currency symbol from settings
     *
     * @return string
     */
    function currency_symbol()
    {
        return setting('currency_symbol', 'ريال');
    }
}

if (!function_exists('current_language')) {
    /**
     * Get the current language code
     *
     * @return string
     */
    function current_language()
    {
        return app()->getLocale();
    }
}

if (!function_exists('translate_model')) {
    /**
     * Get translated content for a model
     *
     * @param mixed $model
     * @param string $field
     * @param string|null $locale
     * @return string
     */
    function translate_model($model, string $field, string $locale = null)
    {
        if (!$model || !method_exists($model, 'getTranslation')) {
            return '';
        }
        
        $locale = $locale ?? current_language();
        return $model->getTranslation($field, $locale, false) ?? '';
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format a price with currency
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    function format_currency(float $amount, string $currency = 'USD')
    {
        return number_format($amount, 2) . ' ' . $currency;
    }
}

if (!function_exists('asset_url')) {
    /**
     * Generate a URL for an asset with fallback
     *
     * @param string|null $path
     * @param string|null $fallback
     * @return string
     */
    function asset_url(?string $path, ?string $fallback = null)
    {
        if (!$path) {
            return $fallback ? asset($fallback) : asset('images/placeholder.png');
        }
        
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        
        return asset('storage/' . $path);
    }
}