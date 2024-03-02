<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Util\Datetime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class LoginRequest
{
    /**
     * @var Request The object representing the HTTP request.
     */
    private Request $request;

    protected \Illuminate\Validation\Validator $validator;

    protected \Illuminate\Validation\Validator $emailValidator;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validator = Validator::make($request->only($this->requestFilter()), $this->rules());
        $this->emailValidator = Validator::make($request->only($this->requestFilter()), $this->emailRules());
    }

    public function requestFilter(): array
    {
        return [
            'login_id', 'password',
        ];
    }

    public function rules(): array
    {
        return [
            'login_id' => 'required|string|max:255',
            'password' => 'required|string',
        ];
    }

    public function emailRules(): array
    {
        return [
            'login_id' => 'email',
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

    public function getLoginId(): string
    {
        return $this->request->get('login_id');
    }

    public function getPassword(): string
    {
        return $this->request->get('password');
    }

    private function isOriginalId(): bool
    {
        return $this->emailValidator->fails();
    }

    public function credentialArray(): array
    {
        if ($this->isOriginalId()) {
            return ['original_id' => $this->getLoginId(), 'password' => $this->getPassword()];
        }

        return ['email' => $this->getLoginId(), 'password' => $this->getPassword()];
    }

    public function toLastLoginInput(): array
    {
        return [
            'last_login' => (new Datetime())->toRFC3339String(),
        ];
    }
}
