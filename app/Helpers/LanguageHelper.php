<?php

namespace App\Helpers;

use App\Models\Language;


class LanguageHelper
{
    /**
     * Get current language
     */
    public static function getCurrentLanguage()
    {
        $locale = app()->getLocale();
        return Language::where('code', $locale)->first();
    }

    /**
     * Get all active languages
     */
    public static function getActiveLanguages()
    {
        return Language::active()->orderBy('sort_order')->get();
    }

    /**
     * Get default language
     */
    public static function getDefaultLanguage()
    {
        return Language::getDefault();
    }

    /**
     * Get language direction
     */
    public static function getDirection()
    {
        $language = self::getCurrentLanguage();
        return $language ? $language->getDirectionClass() : 'ltr';
    }

    /**
     * Get localized URL
     */
    public static function getLocalizedUrl($route, $parameters = [], $locale = null)
    {
        if (!$locale) {
            $locale = app()->getLocale();
        }

        // If it's the default language, return the normal route
        $defaultLanguage = self::getDefaultLanguage();
        if ($defaultLanguage && $locale === $defaultLanguage->code) {
            return route($route, $parameters);
        }

        // For non-default languages, add locale prefix to the path
        $parameters['locale'] = $locale;
        return route($route, $parameters);
    }

    /**
     * Get language switcher data
     */
    public static function getLanguageSwitcherData()
    {
        $currentLanguage = self::getCurrentLanguage();
        $languages = self::getActiveLanguages();
        
        return [
            'current' => $currentLanguage,
            'languages' => $languages,
        ];
    }

    /**
     * Check if current language is RTL
     */
    public static function isRTL()
    {
        $language = self::getCurrentLanguage();
        return $language ? $language->is_rtl : false;
    }

    /**
     * Get URL for language switch
     */
    public static function getLanguageSwitchUrl($targetLocale)
    {
        $currentPath = request()->path();
        $currentLocale = app()->getLocale();
        
        // Remove current locale from path if it exists
        if (str_starts_with($currentPath, $currentLocale . '/')) {
            $currentPath = substr($currentPath, strlen($currentLocale) + 1);
        } elseif ($currentPath === $currentLocale) {
            $currentPath = '';
        }
        
        // Get default language
        $defaultLanguage = self::getDefaultLanguage();
        $isDefaultLanguage = $defaultLanguage && $targetLocale === $defaultLanguage->code;
        
        // Build new URL
        if ($isDefaultLanguage) {
            return url('/' . ($currentPath ?: ''));
        } else {
            return url('/' . $targetLocale . '/' . ($currentPath ?: ''));
        }
    }
}