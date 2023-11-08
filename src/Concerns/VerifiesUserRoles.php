<?php

namespace Modules\Core\Concerns;

use Illuminate\Support\Arr;
use IvaoBrasil\Infrastructure\Contracts\Auth\UserRolesInterface;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;

trait VerifiesUserRoles
{
    /**
     * Verifies if the user has any of the given roles.
     *
     * @param UserRolesInterface $user The user object to check roles against.
     * @param UserRoles[] $roles An array of roles to check.
     * @return bool|null Returns true if the user has any of the roles, null otherwise.
     */
    public function verifyPolicyUserRoles(UserRolesInterface $user, array $roles): ?bool
    {
        if ($user->hasAnyRole(Arr::pluck($roles, 'value'))) {
            return true;
        }

        if (config('ivao-infrastructure.auth.deny_policies')) {
            return false;
        }

        return null;
    }
}
