<?php

declare(strict_types=1);

namespace App\Domain\Models\Users;

enum UserStatus: int
{
    case DELETE = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;
    case DEVELOPER = 99;

    /**
     * Valid user status
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->value === self::ACTIVE->value
            || $this->value === self::DEVELOPER->value;
    }

    /**
     * Invalid user status
     *
     * @return bool
     */
    public function isInvalid(): bool
    {
        return !$this->isValid();
    }
}
