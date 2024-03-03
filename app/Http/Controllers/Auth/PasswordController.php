<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\Services\Auth\PasswordService;
use App\Exceptions\ValidateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordForgotRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PasswordController extends Controller
{
    private PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * Send reset password email.
     */
    public function forgot(Request $request): JsonResponse
    {
        $passwordForgotReq = new PasswordForgotRequest($request);
        if ($passwordForgotReq->fails()) {
            throw new ValidateException($passwordForgotReq->errors());
        }

        return $this->passwordService->forgot($passwordForgotReq->getEmailArray())->responseJson();
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
