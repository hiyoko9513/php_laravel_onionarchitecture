<?php

declare(strict_types=1);

namespace App\Exceptions\Response;

use Illuminate\Http\JsonResponse;

class Response
{
    /**
     * status code
     */
    protected int $statusCode;

    /**
     * error code
     */
    protected int $code;

    /**
     * raw error message
     */
    protected string|array $rawErrorMessage;

    /**
     * error status codes
     */
    protected array $codeToMessage = [
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        419 => 'Page Expired',
        // 422 => 'Validation Error', // controlled by a separate file
        429 => 'Too Many Requests',
        500 => 'Internal Server Error',
        503 => 'Service Unavailable',
    ];

    public function __construct($statusCode, $code = 0, $rawErrorMessage = '')
    {
        $this->statusCode = $statusCode;
        $this->code = $code;
        $this->rawErrorMessage = $rawErrorMessage;
    }

    /**
     * get error message
     */
    private function getMessage(): string|array
    {
        if ($this->isValidStatusCode()) {
            return __($this->codeToMessage[$this->statusCode]);
        }

        return $this->rawErrorMessage;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->code,
        ];
    }

    public function toJson(): JsonResponse
    {
        return response()->json($this->toArray(), $this->statusCode, [
            'Content-Type' => 'application/problem+json',
        ]);
    }

    /**
     * whether it is a registered status code or not
     */
    private function isValidStatusCode(): bool
    {
        return array_key_exists($this->statusCode, $this->codeToMessage);
    }
}
