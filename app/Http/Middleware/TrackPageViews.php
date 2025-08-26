<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;
use Carbon\Carbon;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only track GET requests and exclude admin routes, API routes, and assets
        if ($request->isMethod('GET') && 
            !$request->is('admin/*') && 
            !$request->is('api/*') && 
            !$request->is('_debugbar/*') && 
            !$request->is('storage/*') && 
            !$request->is('css/*') && 
            !$request->is('js/*') && 
            !$request->is('images/*') && 
            !$request->is('favicon.ico') && 
            !$request->ajax() &&
            $response->getStatusCode() === 200) {
            
            try {
                // Check if this session has already viewed this URL today
                $sessionId = $request->session()->getId();
                $url = $request->fullUrl();
                $today = Carbon::today();
                
                $existingView = PageView::where('session_id', $sessionId)
                                      ->where('url', $url)
                                      ->where('date', $today)
                                      ->first();
                
                // Only record if not already recorded for this session/URL/day
                if (!$existingView) {
                    PageView::record($request);
                }
            } catch (\Exception $e) {
                // Silently fail to avoid breaking the application
                \Log::error('Failed to record page view: ' . $e->getMessage());
            }
        }
        
        return $response;
    }
}
