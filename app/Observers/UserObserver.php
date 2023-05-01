<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public $afterCommit = false;

    public function creating(User $user)
    {
//        dd($user);
        $user->generateNewUsername();
        $user->remember_token = Str::random(10);
    }
}
