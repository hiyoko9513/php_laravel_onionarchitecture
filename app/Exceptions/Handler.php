<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Response\Response;
use App\Mail\Exception\ReportMail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final class Handler extends ExceptionHandler
{
    /**
     * A list of classes that are never reported to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontReport = [
        // auth
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,

        // http
        HttpException::class,
        \Illuminate\Http\Exceptions\HttpResponseException::class,

        // other
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
    }

    protected function prepareResponse($request, Throwable $e): JsonResponse
    {
        return $this->prepareJsonResponse($request, $e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): \Symfony\Component\HttpFoundation\Response
    {
        $this->renderable(function (Throwable $e) {
            if ($e instanceof HttpException) {
                $cast = static fn ($orig): HttpException => $orig;
                $httpEx = $cast($e);

                $message = $httpEx->getMessage();
                if ($e instanceof ValidateException) {
                    $message = $e->getValidateMessages();
                }

                return (new Response($httpEx->getStatusCode(), $httpEx->getCode(), $message))->toJSON();
            }

            return (new Response(500))->toJSON();
        });

        return parent::render($request, $e);
    }

    /**
     * Report or log an exception.
     *
     *
     * @throws Throwable
     */
    public function report(Throwable $e): void
    {
        if ($this->shouldReport($e)) {
            Mail::send(new ReportMail($e));
        }

        parent::report($e);
    }
}
