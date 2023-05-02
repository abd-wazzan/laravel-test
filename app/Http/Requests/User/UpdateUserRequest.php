<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserPrefixnameEnum;
use App\Enums\UserTypeEnum;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'prefixname' => ['nullable', Rule::in(UserPrefixnameEnum::getValues())],
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'suffixname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')
                ->ignore($this->route('user'))],
            'photo' => ['nullable', 'image', 'max:2048'],
            'type' => ['required', Rule::in(UserTypeEnum::getValues())],
        ];
    }
}