<?php

declare(strict_types=1);

namespace App\Application\Services\Auth;

use App\Domain\Models\Auth\Authorisation;
use App\Domain\Models\Auth\Register;
use App\Domain\Repositories\UserRepository;
use App\Exceptions\Auth\UserCreateException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthorisationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * register user
     *
     * @throws Throwable|UserCreateException|UnauthorizedException
     */
    public function register(RegisterRequest $requests): Register
    {
        $userInput = $requests->toUserCreateInput();

        DB::beginTransaction();
        try {
            $user = $this->userRepository->create($requests->toUserCreateInput());
        } catch (Throwable) {
            DB::rollBack();
            LOG::error('User creation failed', ['userInput' => $userInput]);
            throw new UserCreateException();
        }

        $token = Auth::attempt($requests->credentialArray());
        if (! $token) {
            DB::rollBack();
            LOG::error('Auth failed', ['userInput' => $userInput]);
            throw new UnauthorizedException();
        }

        DB::commit();
        $authorisation = new Authorisation($token);

        return new Register($user, $authorisation);
    }
}
