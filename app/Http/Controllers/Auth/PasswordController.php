<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\Services\Auth\AuthorisationService;
use App\Application\Services\Auth\PasswordService;
use App\Exceptions\ValidateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordForgetRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

final class PasswordController extends Controller
{
    private PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * Send reset password email.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forgot(Request $request): JsonResponse
    {
        $passwordForgetReq = new PasswordForgetRequest($request);
        if ($passwordForgetReq->fails()) {
            throw new ValidateException($passwordForgetReq->errors());
        }

        return $this->passwordService->forget($passwordForgetReq->getEmailArray())->responseJson();
    }

    /**
     * Reset the password for a user.
     *
     * @param Request $request The HTTP request object.
     * @return JsonResponse The JSON response containing the result of the password reset.
     * @throws ValidateException If the password reset request validation fails.
     */
    public function reset(Request $request): JsonResponse
    {
        $passwordResetReq = new PasswordResetRequest($request);
        if ($passwordResetReq->fails()) {
            throw new ValidateException($passwordResetReq->errors());
        }

        return $this->passwordService->reset($passwordResetReq->toPasswordResetInput())->responseJson();
    }
}
