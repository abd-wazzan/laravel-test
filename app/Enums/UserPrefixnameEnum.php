<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum UserPrefixnameEnum: string
{
    use EnumTrait;
    case MR = 'Mr';
    case MRS = 'Mrs';
    case MS = 'Ms';

    public function getGender(): string
    {
        return match($this)
        {
            UserPrefixnameEnum::MR => 'Male',
            UserPrefixnameEnum::MRS => 'Female',
            UserPrefixnameEnum::MS => 'Female',
        };
    }

}
