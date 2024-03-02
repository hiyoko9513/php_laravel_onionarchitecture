<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Models\Users\User;

interface UserRepository
{
    public function create(array $input): User;
}
