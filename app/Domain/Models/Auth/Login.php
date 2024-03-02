<?php

declare(strict_types=1);

namespace App\Domain\Models\Auth;

use App\Domain\Models\Users\User;
use Illuminate\Http\JsonResponse;

final class Login
{
    private User $user;

    private Authorisation $authorisation;

    public function __construct(User $user, Authorisation $authorisation)
    {
        $this->user = $user;
        $this->authorisation = $authorisation;
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user->toArrayForRegister(),
            'authorisation' => $this->authorisation->toArray(),
        ];
    }

    public function responseJson(): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
