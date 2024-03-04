<?php

declare(strict_types=1);

namespace App\Domain\Models\Users;

use Illuminate\Http\JsonResponse;

final class UserExists
{
    private bool $isExists;

    public function __construct(bool $isExists = true)
    {
        $this->isExists = $isExists;
    }

    public function responseJson(): JsonResponse
    {
        return response()->json([$this->isExists]);
    }

    public function responseJsonForUnregistered(): JsonResponse
    {
        return response()->json([!$this->isExists]);
    }
}
