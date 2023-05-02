<?php

namespace App\Observers;

use App\Events\UserSavedEvent;
use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public $afterCommit = false;

    public function creating(User $user)
    {
        $user->generateNewUsername();
    }

    public function created(User $user)
    {
        event(new UserSavedEvent($user));
    }

    public function updated(User $user)
    {
        event(new UserSavedEvent($user));
    }
}
