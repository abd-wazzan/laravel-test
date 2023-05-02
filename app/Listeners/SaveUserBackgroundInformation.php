<?php

namespace App\Listeners;

use App\Services\IUserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserBackgroundInformation
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected IUserService $userService
    )
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $this->userService->saveDetails($event->user);
    }
}
