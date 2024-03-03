<?php

declare(strict_types=1);

namespace App\Application\Services\Auth;

use App\Domain\Models\Auth\PasswordForget;
use App\Exceptions\Auth\ResetUserPasswordException;
use App\Exceptions\Auth\SendUserPasswordResetMailException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordService
{
    /**
     * Sends a password reset link to the given email addresses.
     *
     * @param array $email The email addresses to send the reset link.
     * @return PasswordForget The password forget object.
     * @throws SendUserPasswordResetMailException If the reset link failed to be sent.
     */
    public function forget(array $email): PasswordForget
    {
        $status = Password::sendResetLink($email);
        if ($status !== Password::RESET_LINK_SENT) {
            throw new SendUserPasswordResetMailException();
        }

        return new PasswordForget();
    }

    public function reset(array $input): PasswordForget
    {
        $status = Password::reset(
            $input,
            static function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)]);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw new ResetUserPasswordException();
        }

        return new PasswordForget();
    }
}
