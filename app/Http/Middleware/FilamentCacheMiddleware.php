<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FilamentCacheMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip caching for debugbar routes
        if ($request->is('_debugbar/*')) {
            return $next($request);
        }
        
        // Only cache specific admin API endpoints, not full pages
        if ($request->is('admin/*/data') || $request->is('admin/*/table')) {
            $cacheKey = 'admin_data_' . md5($request->fullUrl() . serialize($request->query()));
            
            // Cache for 2 minutes only for data endpoints
            if ($request->isMethod('GET') && !$request->has('_token')) {
                return Cache::remember($cacheKey, 120, function () use ($next, $request) {
                    return $next($request);
                });
            }
        }
        
        return $next($request);
    }
}