<?php

declare(strict_types=1);

namespace App\Exceptions;

enum BadRequestCodes: int
{
    case COMMON = 0;
    case USER_CREATION_FAILED = 1;
    case SEND_USER_PASS_RESET_EMAIL_FAILED = 2;
    case RESET_USER_PASS_FAILED = 3;
}
