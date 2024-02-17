<?php

namespace App\Http\Middleware;

class UnescapeJsonResponse
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        $newEncodingOptions = $response->getEncodingOptions() | JSON_UNESCAPED_UNICODE;
        $response->setEncodingOptions($newEncodingOptions);

        return $response;
    }
}
