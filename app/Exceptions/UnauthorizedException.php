<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UnauthorizedException extends HttpException
{
    protected int $statusCode = 401;

    protected $code = 0;

    public function __construct(?Throwable $previous = null, array $headers = [])
    {
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }
}
