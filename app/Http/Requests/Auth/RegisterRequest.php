<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Domain\Models\Users\UserStatus;
use App\Util\Datetime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class RegisterRequest
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
            'original_id', 'password', 'first_name', 'last_name', 'email', 'tel', 'birthday',
        ];
    }

    public function credentialFilter(): array
    {
        return [
            'email', 'password',
        ];
    }

    public function rules(): array
    {
        return [
            'original_id' => ['required', 'string', 'regex:/\A([a-zA-Z0-9\-_])+\z/u', 'min:4', 'max:255',
                'unique:users'],
            'password' => ['required', 'string', 'regex:/\A([a-zA-Z0-9\-_]{8,})+\z/u', 'min:6', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tel' => ['required', 'numeric', 'digits_between:10,11'],
            'birthday' => ['required', 'date'],
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

    public function credentialArray(): array
    {
        return $this->request->only($this->credentialFilter());
    }

    public function toUserCreateInput(): array
    {
        $date = new Datetime();

        return array_merge($this->request->only($this->requestFilter()),
            [
                'last_login' => $date->toRFC3339String(),
                'status' => UserStatus::ACTIVE->value,
            ]);
    }
}
