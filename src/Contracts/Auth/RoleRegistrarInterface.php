<?php

namespace IvaoBrasil\Infrastructure\Contracts\Auth;


interface RoleRegistrarInterface
{
    public function assignRoles(UserRolesInterface $user): void;
}
