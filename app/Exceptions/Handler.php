<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Response\Response;
use App\Mail\Exception\ReportMail;
use App\Notifications\Exceptions\ReportNotification;
use App\Notifications\Password\ResetUserNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final class Handler extends ExceptionHandler
{
    use Notifiable;

    public string $email;

    public function __construct(Container $container)
    {
        $this->email = env('MAIL_TO_ADDRESS_FOR_DEVELOPER', 'emergency@hiyoko.com');
        parent::__construct($container);
    }

    /**
     * A list of classes that are never reported to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontReport = [
        // auth
        AuthenticationException::class,
        AuthorizationException::class,

        // other
        ValidationException::class,
        ModelNotFoundException::class,
        SuspiciousOperationException::class,
        TokenMismatchException::class,

        // custom
        ValidateException::class,
        UnauthorizedException::class,
        UnauthorizedInvalidUserException::class
    ];

    /**
     * empty override
     *
     * @var array
     */
    protected $internalDontReport = [
        // AuthenticationException::class,
        // AuthorizationException::class,
        // BackedEnumCaseNotFoundException::class,
        // HttpException::class,
        // HttpResponseException::class,
        // ModelNotFoundException::class,
        // MultipleRecordsFoundException::class,
        // RecordsNotFoundException::class,
        // SuspiciousOperationException::class,
        // TokenMismatchException::class,
        // ValidationException::class,
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
     * @throws Throwable
     */
    public function report(Throwable $e): void
    {
        if ($this->shouldReport($e)) {
            $this->notify(new ReportNotification($e));
        }

        parent::report($e);
    }
}
