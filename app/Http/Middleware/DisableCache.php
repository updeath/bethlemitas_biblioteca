<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DisableCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate') // HTTP 1.1
                        ->header('Pragma', 'no-cache') // HTTP 1.0
                        ->header('Expires', '0'); // Proxies
        }
        return $response;
    }
}
