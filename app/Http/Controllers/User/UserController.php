<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Domain\Models\Users\UserExists;
use App\Exceptions\ValidateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ValidRequest;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    public function valid(string $originalId): JsonResponse
    {
        $registerReq = new ValidRequest($originalId);
        if ($registerReq->fails()) {
            throw new ValidateException($registerReq->errors());
        }

        return (new UserExists())->responseJson();
    }
}
