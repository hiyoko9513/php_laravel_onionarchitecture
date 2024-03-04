<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddCacheInfo
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $response = $next($request);

        if (app()->isLocal()) {
            return $response;
        }

        $this->setCacheHeaders($response);

        return $response;
    }

    private function setCacheHeaders($response): void
    {
        if (method_exists($response, 'header')) {
            $content = $response->getContent();
            $etag = md5($content);

            $response->header('ETag', $etag);
            $response->header('Cache-Control', 'private, must-revalidate');
        }
    }
}
