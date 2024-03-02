<?php

declare(strict_types=1);

namespace App\Domain\Models\Users;

enum UserStatus: int
{
    case DELETE = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;
    case DEVELOPER = 99;
}
