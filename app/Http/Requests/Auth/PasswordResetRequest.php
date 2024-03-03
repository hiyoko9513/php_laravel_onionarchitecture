<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class PasswordResetRequest
{
    /**
     * @var Request The object representing the HTTP request.
     */
    private Request $request;

    protected \Illuminate\Validation\Validator $validator;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = Validator::make($request->only($this->requestFilter()), $this->rules());
    }

    public function requestFilter(): array
    {
        return [
            'token', 'email', 'password',
        ];
    }

    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'regex:/\A([a-zA-Z0-9\-_]{8,})+\z/u', 'min:6', 'max:255'],
        ];
    }

    public function fails(): bool
    {
        return $this->validator->fails();
    }

    public function errors(): array
    {
        return $this->validator->errors()->messages();
    }

    public function toPasswordResetInput(): array
    {
        return $this->request->only($this->requestFilter());
    }
}
