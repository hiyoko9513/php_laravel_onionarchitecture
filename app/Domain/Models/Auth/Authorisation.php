<?php

declare(strict_types=1);

namespace App\Domain\Models\Auth;

final class Authorisation
{
    private string $token;

    private string $type = 'bearer';

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'type' => $this->type,
        ];
    }
}
