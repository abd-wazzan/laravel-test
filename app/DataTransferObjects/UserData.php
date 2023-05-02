<?php

namespace App\DataTransferObjects;

use App\Enums\UserPrefixnameEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public ?int                $id,
        public ?UserPrefixnameEnum $prefixname,
        #[Max(255)]
        public string              $firstname,
        #[Max(255)]
        public ?string             $middlename,
        #[Max(255)]
        public string              $lastname,
        #[Max(255)]
        public ?string             $suffixname,
        #[Max(255)]
        public ?string              $username,
        #[Max(255), Email]
        public string              $email,
        #[Min(8), Max(16)]
        public ?string             $password,
        public ?string             $photo,
        public ?UploadedFile       $photo_file,
        public UserTypeEnum        $type = UserTypeEnum::USER,
    )
    {
    }

    public static function fromRequest(Request $request): UserData
    {
        return self::from($request->validated());
    }
}
