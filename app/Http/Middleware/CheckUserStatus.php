<?php

namespace App\Http\Middleware;

use App\Domain\Models\Users\UserStatus;
use App\Exceptions\UnauthorizedInvalidUserException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (($user = Auth::user()) && (UserStatus::from($user->status)->isInvalid())) {
            Auth::logout();
            throw new UnauthorizedInvalidUserException();
        }

        return $next($request);
    }
}
