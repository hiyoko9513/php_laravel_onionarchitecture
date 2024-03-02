<?php

declare(strict_types=1);

namespace App\Domain\Models\Users;

use App\Models\User as UserEloquent;

final class User
{
    private string $id;

    private string $originalId;

    private UserStatus $status;

    private string $firstName;

    private string $lastName;

    private string $email;

    private string $tel;

    private ?string $birthday;

    private string $lastLogin;

    public function __construct(UserEloquent $userEloquent)
    {
        $this->id = $userEloquent->id;
        $this->originalId = $userEloquent->original_id;
        $this->status = UserStatus::from($userEloquent->status);
        $this->firstName = $userEloquent->first_name;
        $this->lastName = $userEloquent->last_name;
        $this->email = $userEloquent->email;
        $this->tel = $userEloquent->tel;
        $this->birthday = $userEloquent->birthday;
        $this->lastLogin = $userEloquent->last_login;
    }

    public function toArray(): array
    {
        return [
            'originalId' => $this->originalId,
            'status' => $this->status,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'tel' => $this->tel,
            'birthday' => $this->birthday,
            'lastLogin' => $this->lastLogin,
        ];
    }

    public function toArrayForRegister(): array
    {
        return $this->toArray();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
