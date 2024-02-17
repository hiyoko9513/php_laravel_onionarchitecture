<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateException extends HttpException
{
    private array $validateMessages;

    protected int $statusCode = 422;
    protected $message = 'Validation Error';
    protected $code = 0;

    public function __construct(array $validateMessages, ?\Throwable $previous = null, array $headers = [])
    {
        $this->validateMessages = $validateMessages;
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }

    public function getValidateMessages(): array
    {
        return $this->validateMessages;
    }
}
