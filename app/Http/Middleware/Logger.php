<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class Logger
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        Log::shareContext([
            'request-id' => uniqid('req-', true),
            'client-ip' => $request->getClientIp(),
            'user' => $request->user()?->id,
        ]);

        Log::info($request->method() . ' ' . $request->fullUrl(), [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
        ]);

        $response = $next($request);

        Log::info($response->status(), [
            'response' => $response->getData(true),
        ]);

        return $response;
    }
}
