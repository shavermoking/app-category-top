<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        Log::info('Incoming request:', [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'parameters' => $request->all(),
        ]);

        return $next($request);
    }
}
