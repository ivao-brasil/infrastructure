<?php

namespace IvaoBrasil\Infrastructure\Services\Auth;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;

class RoleRegistrarService implements RoleRegistrarInterface
{
    public function __construct(private string $divisionCode, private array $roleMapping)
    {
    }

    /**
     * Get roles to assign
     *
     * @param string $division
     * @param string[] $staffPositions
     * @return Collection<int, UserRoles>
     */
    public function getRolesToAssign(string $division, array $staffPositions): Collection
    {
        $rolesToAssign = collect();

        if ($division !== $this->divisionCode) {
            return $rolesToAssign;
        }

        $userStaffRoles = collect($staffPositions)
            ->map(function (string $position) {
                foreach ($this->getDivisionPositionRegex() as $role => $regex) {
                    if (!$this->hasStaffPositionByRegex($position, $regex)) {
                        continue;
                    }

                    return UserRoles::from($role);
                }

                return null;
            })
            ->filter(fn (?UserRoles $role) => $role !== null);

        $rolesToAssign = $rolesToAssign->concat($userStaffRoles);

        if ($userStaffRoles->isNotEmpty()) {
            $rolesToAssign->push(UserRoles::STAFF);
        }

        return $rolesToAssign;
    }

    private function hasStaffPositionByRegex(string $position, string $positionRegex): bool
    {
        return preg_match($positionRegex, $position) === 1;
    }

    /**
     * @return array<string, string>
     */
    private function getDivisionPositionRegex(): array
    {
        return Arr::mapWithKeys($this->roleMapping, fn (UserRoles $role, string $regex) => [
            $role->value => $regex
        ]);
    }
}
