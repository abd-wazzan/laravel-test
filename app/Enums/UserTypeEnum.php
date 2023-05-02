<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum UserTypeEnum: string
{
    use EnumTrait;
    case USER = 'user';
}
