<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class PasswordForgotRequest
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
            'email',
        ];
    }

    public function rules(): array
    {
        return ['email' => 'required|email'];
    }

    public function fails(): bool
    {
        return $this->validator->fails();
    }

    public function errors(): array
    {
        return $this->validator->errors()->messages();
    }

    public function getEmailArray(): array
    {
        return ['email' => $this->request->get('email')];
    }
}
