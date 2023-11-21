<?php

namespace IvaoBrasil\Infrastructure\Listeners\Auth;

use Illuminate\Auth\Events\Login;
use InvalidArgumentException;
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
            !array_key_exists('division', $event->user->getAttributes()) ||
            !array_key_exists('staff', $event->user->getAttributes())
        ) {
            return;
        }

        if (!in_array(\Spatie\Permission\Traits\HasRoles::class, class_uses($event->user))) {
            return;
        }

        $event->user->syncRoles(
            $this->roleRegistrar->getRolesToAssign(
                $event->user->division,
                $event->user->staff
            )->pluck('value')
        );
    }
}
