<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Application\UseCases\Auth\PasswordUseCase;
use App\Exceptions\ValidateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordForgotRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PasswordController extends Controller
{
    private PasswordUseCase $passwordUseCase;

    public function __construct(PasswordUseCase $passwordUseCase)
    {
        $this->passwordUseCase = $passwordUseCase;
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

        return $this->passwordUseCase->forgot($passwordForgotReq->getEmailArray())->responseJson();
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

        return $this->passwordUseCase->reset($passwordResetReq->toPasswordResetInput())->responseJson();
    }
}
