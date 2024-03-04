<?php

declare(strict_types=1);

namespace App\Exceptions\Util;

use App\Exceptions\ErrorCodes;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ExchangeDatetimeException extends HttpException
{
    protected int $statusCode = 500;

    protected $message = 'Failed Exchange Datetime';

    protected $code = ErrorCodes::EXCHANGE_DATETIME_FAILED->value;

    public function __construct(?Throwable $previous = null, array $headers = [])
    {
        parent::__construct($this->statusCode, $this->message, $previous, $headers, $this->code);
    }
}
