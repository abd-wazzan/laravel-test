<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserPrefixnameEnum;
use App\Enums\UserTypeEnum;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'prefixname' => ['nullable', Rule::in(UserPrefixnameEnum::getValues())],
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'suffixname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'type' => ['required', Rule::in(UserTypeEnum::getValues())],
        ];
    }
}