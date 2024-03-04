<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Validator;

final class UnregisteredRequest
{
    protected \Illuminate\Validation\Validator $validator;

    public function __construct(string $originalId)
    {
        $this->validator = Validator::make(['original_id' => $originalId], $this->rules());
    }

    public function rules(): array
    {
        return [
            'original_id' => ['required', 'string', 'regex:/\A([a-zA-Z0-9\-_])+\z/u', 'min:4', 'max:255',
                'unique:users'],
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
}
