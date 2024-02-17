<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class HiyokoException extends HttpException
{
    protected int $statusCode = 402;
    protected $message = 'hiyoko dayo!';
    protected $code = 1;

    public function __construct(?\Throwable $previous = null, array $headers = [])
    {
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }
}
