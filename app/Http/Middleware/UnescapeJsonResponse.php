<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class UnescapeJsonResponse
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $newEncodingOptions = $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE;
        $response->setEncodingOptions($newEncodingOptions);

        return $response;
    }
}
