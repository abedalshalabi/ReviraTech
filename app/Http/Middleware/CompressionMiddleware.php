<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompressionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only compress for admin routes and if gzip is supported
        if ($request->is('admin/*') && $this->supportsGzip($request)) {
            $content = $response->getContent();
            
            if ($content && strlen($content) > 1024) { // Only compress if content > 1KB
                $compressed = gzencode($content, 6); // Compression level 6 for balance
                
                if ($compressed !== false && strlen($compressed) < strlen($content)) {
                    $response->setContent($compressed);
                    $response->headers->set('Content-Encoding', 'gzip');
                    $response->headers->set('Content-Length', strlen($compressed));
                    $response->headers->set('Vary', 'Accept-Encoding');
                }
            }
        }

        return $response;
    }

    /**
     * Check if the client supports gzip compression.
     */
    private function supportsGzip(Request $request): bool
    {
        $acceptEncoding = $request->header('Accept-Encoding', '');
        return str_contains(strtolower($acceptEncoding), 'gzip');
    }
}