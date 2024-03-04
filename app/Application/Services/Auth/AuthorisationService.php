<?php

declare(strict_types=1);

namespace App\Application\Services\Auth;

use App\Domain\Models\Auth\Authorisation;
use App\Domain\Models\Auth\Login;
use App\Domain\Models\Auth\Logout;
use App\Domain\Models\Auth\Refresh;
use App\Domain\Models\Auth\Register;
use App\Domain\Models\Users\User;
use App\Domain\Models\Users\UserStatus;
use App\Domain\Repositories\UserRepository;
use App\Exceptions\Auth\UserCreateException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\UnauthorizedInvalidUserException;
use App\Http\Requests\Auth\LoginRequest;
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

    /**
     * login user
     *
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $requests): Login
    {
        $token = Auth::attempt($requests->credentialArray());
        if (! $token) {
            LOG::error('Auth failed', ['input data' => $requests->credentialArray()]);
            throw new UnauthorizedException();
        }

        if (UserStatus::from(Auth::user()->status)->isInvalid()) {
            Auth::logout();
            throw new UnauthorizedInvalidUserException();
        }

        $user = $this->userRepository->updateWithId(Auth::user()->id, $requests->toLastLoginInput());
        $authorisation = new Authorisation($token);

        return new Login($user, $authorisation);
    }

    /**
     * logout user
     */
    public function logout(): Logout
    {
        Auth::guard('api')->logout();

        return new Logout();
    }

    /**
     * token refresh
     */
    public function refresh(): Refresh
    {
        $token = Auth::refresh();
        if (! $token) {
            LOG::error('Auth refresh failed');
            throw new UnauthorizedException();
        }

        $user = new User(Auth::user());
        $authorisation = new Authorisation($token);

        return new Refresh($user, $authorisation);
    }
}
