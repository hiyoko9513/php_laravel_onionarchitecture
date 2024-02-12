<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class AccessLogger
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        Log::withContext([
            'request-id' => uniqid('req-', false),
            'user' => $request->user()?->id,
        ]);

        Log::info($request->fullUrl(), [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'method' => $request->method(),
        ]);

        $response = $next($request);

        Log::info($response->getData(true));

        return $response;
    }
}
