<?php

declare(strict_types=1);

namespace App\Application\UseCases\Auth;

use App\Domain\Models\Auth\PasswordForgot;
use App\Exceptions\Auth\SendUserPasswordResetMailException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordUseCase
{
    /**
     * Sends a password reset link to the given email addresses.
     *
     * @param array $email The email addresses to send the reset link.
     * @return PasswordForgot The password forgot object.
     * @throws SendUserPasswordResetMailException If the reset link failed to be sent.
     */
    public function forgot(array $email): PasswordForgot
    {
        $status = Password::sendResetLink($email);
        if ($status !== Password::RESET_LINK_SENT) {
            throw new SendUserPasswordResetMailException();
        }

        return new PasswordForgot();
    }

    public function reset(array $input): PasswordForgot
    {
        Password::reset(
            $input,
            static function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)]);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return new PasswordForgot();
    }
}
