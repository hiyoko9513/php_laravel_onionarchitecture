<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\Services\Auth\AuthorisationService;
use App\Exceptions\ValidateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class AuthorisationController extends Controller
{
    private AuthorisationService $authorisationService;

    public function __construct(AuthorisationService $registerService)
    {
        $this->authorisationService = $registerService;
    }

    /**
     * user registration
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

    public function login(Request $request): JsonResponse
    {
        $registerReq = new LoginRequest($request);
        if ($registerReq->fails()) {
            throw new ValidateException($registerReq->errors());
        }

        return $this->authorisationService->login($registerReq)->responseJson();
    }

    public function logout(): JsonResponse
    {
        return $this->authorisationService->logout()->responseJson();
    }
}
