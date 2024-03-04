<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\UseCases\Auth\AuthorisationUsecase;
use App\Exceptions\ValidateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class AuthorisationController extends Controller
{
    private AuthorisationUsecase $authorisationService;

    public function __construct(AuthorisationUsecase $registerService)
    {
        $this->authorisationService = $registerService;
    }

    /**
     * register user
     *
     * @throws Throwable
     */
    public function register(Request $request): JsonResponse
    {
        $registerReq = new RegisterRequest($request);
        if ($registerReq->fails()) {
            throw new ValidateException($registerReq->errors());
        }

        return $this->authorisationService->register($registerReq)->responseJson();
    }

    /**
     * login user
     */
    public function login(Request $request): JsonResponse
    {
        $registerReq = new LoginRequest($request);
        if ($registerReq->fails()) {
            throw new ValidateException($registerReq->errors());
        }

        return $this->authorisationService->login($registerReq)->responseJson();
    }

    /**
     * logout user
     */
    public function logout(): JsonResponse
    {
        return $this->authorisationService->logout()->responseJson();
    }

    /**
     * token refresh
     */
    public function refresh(): JsonResponse
    {
        return $this->authorisationService->refresh()->responseJson();
    }
}
