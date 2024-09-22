<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckResponseTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Start timing
        $startTime = microtime(true);
        // Handle the request
        $response = $next($request);
        // Stop timing
        $endTime = microtime(true);
        // Calculate elapsed time
        $elapsedTime = $endTime - $startTime;
        // Log the elapsed time
        Log::info('Response time: ' . number_format($elapsedTime * 1000, 2) . ' ms', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'status' => $response->status(),
        ]);
        return $response;
    }
}
