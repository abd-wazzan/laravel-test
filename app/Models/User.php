<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserPrefixnameEnum;
use App\Enums\UserTypeEnum;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'password',
        'photo',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'prefixname' => UserPrefixnameEnum::class,
        'type' => UserTypeEnum::class,
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        self::observe(UserObserver::class);
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: function (string $value) {
                if (Hash::needsRehash($value)) {
                    $value = Hash::make($value);
                }
                return $value;
            },
        );
    }

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->prefixname->value . ' ' . $this->firstname . ' ' .
                $this->middlename . ' ' . $this->lastname . ' ' . $this->suffixname
        );
    }

    protected function middleinitial(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->middlename ? strtoupper($this->middlename[0] . '.') : null
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->photo)
        );
    }

    public function generateNewUsername(): void
    {
        $username = str_replace([' ', '.'], '_', $this->fullname);
        $count = $this->countSameUsername($username) + 1;
        $username .= "_$count";
        $this->username = strtolower($username);
    }

    private function countSameUsername(string $name): int
    {
        return $this->query()
            ->where('username', 'like', strtolower($name) . '\_%')
            ->count();
    }
}
