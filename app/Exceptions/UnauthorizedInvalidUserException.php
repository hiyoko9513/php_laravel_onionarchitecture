<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UnauthorizedInvalidUserException extends HttpException
{
    protected int $statusCode = 401;

    protected $code = ErrorCodes::INVALID_USER->value;

    public function __construct(?Throwable $previous = null, array $headers = [])
    {
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }
}
