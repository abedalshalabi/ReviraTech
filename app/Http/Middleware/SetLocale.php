<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Language;
use Illuminate\Support\Facades\Cache;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for locale query parameter first
        if ($request->has('locale')) {
            $queryLocale = $request->get('locale');
            $language = Cache::remember("language_{$queryLocale}", 3600, function() use ($queryLocale) {
                return Language::where('code', $queryLocale)->where('is_active', true)->first();
            });
            
            if ($language) {
                // Redirect to proper URL format
                $path = $request->path();
                $queryParams = $request->query();
                unset($queryParams['locale']); // Remove locale from query params
                
                // Build the new URL
                $defaultLanguage = Cache::remember('default_language', 3600, function() {
                    return Language::where('is_default', true)->first();
                });
                if ($defaultLanguage && $queryLocale === $defaultLanguage->code) {
                    // For default language, don't add prefix
                    $newUrl = url($path === '/' ? '' : $path);
                } else {
                    // For non-default language, add prefix
                    $newUrl = url($queryLocale . '/' . ($path === '/' ? '' : $path));
                }
                
                // Add remaining query parameters if any
                if (!empty($queryParams)) {
                    $newUrl .= '?' . http_build_query($queryParams);
                }
                
                return redirect($newUrl);
            }
        }
        
        // Get language from URL segment
        $locale = $request->segment(1);
        
        // Check if locale exists in database (with caching)
        $language = Cache::remember("language_{$locale}", 3600, function() use ($locale) {
            return Language::where('code', $locale)->where('is_active', true)->first();
        });
        
        if (!$language) {
            // Get default language
            $defaultLanguage = Cache::remember('default_language', 3600, function() {
                return Language::where('is_default', true)->first();
            });
            if ($defaultLanguage) {
                $locale = $defaultLanguage->code;
            } else {
                $locale = 'en'; // Fallback to English
            }
        }
        
        // Set application locale
        app()->setLocale($locale);
        
        // Store current language in session
        session(['locale' => $locale]);
        
        return $next($request);
    }
}
