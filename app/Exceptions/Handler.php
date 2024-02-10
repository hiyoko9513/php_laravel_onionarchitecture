<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function prepareResponse($request, Throwable $e): \Illuminate\Http\JsonResponse
    {
        return $this->prepareJsonResponse($request, $e);
    }

    protected function convertExceptionToArray(Throwable $e): array
    {
        return [
            'message' => $e->getMessage(),
            'status_code' => $this->isHttpException($e) ? $e->getStatusCode() : 500,
        ];
    }
}
