<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\ErrorCodes;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class SendUserPasswordResetMailException extends HttpException
{
    protected int $statusCode = 400;

    protected $message = 'SendUserPasswordResetMailException';

    protected $code = ErrorCodes::SEND_USER_PASS_RESET_EMAIL_FAILED->value;

    public function __construct(?Throwable $previous = null, array $headers = [])
    {
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }
}
