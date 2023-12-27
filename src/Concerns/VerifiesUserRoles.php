<?php

namespace IvaoBrasil\Infrastructure\Concerns;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Arr;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;

trait VerifiesUserRoles
{
    /**
     * Verifies if the user has any of the given roles.
     *
     * @param User $user
     * @param UserRoles[] $roles
     * @return bool|null Returns true if the user has any of the roles, null otherwise.
     */
    public function verifyPolicyUserRoles(User $user, array $roles): ?bool
    {
        if ($user->hasAnyRole(Arr::pluck($roles, 'value'))) {
            return true;
        }

        return null;
    }
}
