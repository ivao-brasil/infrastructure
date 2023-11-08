<?php

namespace IvaoBrasil\Infrastructure\Services\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Contracts\Auth\UserRolesInterface;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;
use UnitEnum;

class RoleRegistrarService implements RoleRegistrarInterface
{
    public function __construct(private string $divisionCode, private array $roleMapping)
    {
    }

    public function assignRoles(UserRolesInterface $user): void
    {
        $user->assignRole($this->getRolesToAssign($user)->pluck('value'));

        if ($user instanceof Model) {
            $user->save();
        }
    }

    /**
     * @param UserRolesInterface $user
     * @return Collection<int, UnitEnum>
     */
    private function getRolesToAssign(UserRolesInterface $user): Collection
    {
        $rolesToAssign = collect();

        if ($user->division !== $this->divisionCode) {
            return $rolesToAssign;
        }

        $userStaffRoles = collect($user->staff)
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
