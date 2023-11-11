<?php

namespace IvaoBrasil\Infrastructure\Contracts\Auth;

use Illuminate\Support\Collection;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;

interface RoleRegistrarInterface
{
    /**
     * Get roles to assign
     *
     * @param string $division
     * @param string[] $staffPositions
     * @return Collection<int, UserRoles>
     */
    public function getRolesToAssign(string $division, array $staffPositions): Collection;
}
