<?php

namespace IvaoBrasil\Infrastructure\Contracts\Auth;

use IvaoBrasil\Infrastructure\Models\Core\User;

interface RoleRegistrarInterface
{
    public function assignRoles(User $user): void;
}
