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
        if (
            !method_exists($event->user, 'assignRoles') ||
            !property_exists($event->user, 'division') ||
            !property_exists($event->user, 'staff')
        ) {
            return;
        }

        $event->user->assignRoles(
            $this->roleRegistrar->getRolesToAssign(
                $event->user->division,
                $event->user->staff
            )->pluck('value')
        );
    }
}
