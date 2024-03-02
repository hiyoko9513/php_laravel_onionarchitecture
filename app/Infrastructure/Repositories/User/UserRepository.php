<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\User;

use App\Domain\Models\Users\User;
use App\Domain\Repositories\UserRepository as iRepo;
use App\Models\User as UserEloquent;

class UserRepository implements iRepo
{
    /**
     * Creates a new User.
     *
     * @param array $input The input array containing the user data.
     * @return User The created User object.
     */
    public function create(array $input): User
    {
        $userEloquent = UserEloquent::create($input);

        return new User($userEloquent);
    }

    public function updateWithId(string $id, array $input): User
    {
        $userEloquent = UserEloquent::findOrFail($id);
        $userEloquent->update($input);

        return new User($userEloquent);
    }
}
