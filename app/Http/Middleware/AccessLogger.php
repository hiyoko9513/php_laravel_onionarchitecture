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
        $requestId = $request->header('X-Request-Id', 'default');

        Log::info($requestId . ':' . $request->method() . ':' . $request->fullUrl(), [
            'user' => $request->user()?->id,
            'headers' => $request->headers->all(),
            'body' => $request->all(),
        ]);

        $response = $next($request);

        Log::info($requestId, $response->getData(true));

        return $response;
    }
}
