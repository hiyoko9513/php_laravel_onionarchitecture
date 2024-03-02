<?php

declare(strict_types=1);

namespace App\Domain\Models\Auth;

use Illuminate\Http\JsonResponse;

final class Logout
{
    public function toArray(): array
    {
        return [
            'status' => 'success',
        ];
    }

    public function responseJson(): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
