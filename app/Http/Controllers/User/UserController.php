<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Domain\Models\Users\UserExists;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UnregisteredRequest;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    public function unregistered(string $originalId): JsonResponse
    {
        $registerReq = new UnregisteredRequest($originalId);
        return (new UserExists($registerReq->fails()))->responseJsonForUnregistered();
    }
}
