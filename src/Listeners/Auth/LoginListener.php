<?php

namespace IvaoBrasil\Infrastructure\Listeners\Auth;

use Illuminate\Auth\Events\Login;
use IvaoBrasil\Infrastructure\Services\Auth\RoleRegistrarService;

class LoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private RoleRegistrarService $roleRegistrar)
    {
        // ...
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $this->roleRegistrar->assignRoles($event->user);
    }
}
