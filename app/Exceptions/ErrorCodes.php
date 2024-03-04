<?php

declare(strict_types=1);

namespace App\Exceptions;

enum ErrorCodes: int
{
    case COMMON = 0;
    case USER_CREATION_FAILED = 1;
    case SEND_USER_PASS_RESET_EMAIL_FAILED = 2;
    // case RESET_USER_PASS_FAILED = 3;
    case EXCHANGE_DATETIME_FAILED = 4;
    case INVALID_USER = 5;
}
