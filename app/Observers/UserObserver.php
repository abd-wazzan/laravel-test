<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public $afterCommit = false;

    public function creating(User $user)
    {
        $user->generateNewUsername();
    }
}
