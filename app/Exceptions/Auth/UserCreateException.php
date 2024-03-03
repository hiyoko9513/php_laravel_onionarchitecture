<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BadRequestCodes;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UserCreateException extends HttpException
{
    protected int $statusCode = 400;

    protected $message = 'UserCreateException';

    protected $code = BadRequestCodes::USER_CREATION_FAILED->value;

    public function __construct(?Throwable $previous = null, array $headers = [])
    {
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }
}
