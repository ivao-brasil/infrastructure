<?php

namespace IvaoBrasil\Infrastructure\Listeners\Auth;

use Illuminate\Auth\Events\Login;
use InvalidArgumentException;
use IvaoBrasil\Infrastructure\Contracts\Auth\UserRolesInterface;
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
     *
     * @throws InvalidArgumentException
     */
    public function handle(Login $event): void
    {
        if (!config('ivao-infrastructure.auth.enable_roles', false)) {
            return;
        }

        if (!($event->user instanceof UserRolesInterface)) {
            throw new InvalidArgumentException('User must implement UserRolesInterface.');
        }

        $this->roleRegistrar->assignRoles($event->user);
    }
}
