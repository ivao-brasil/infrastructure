<?php

namespace IvaoBrasil\Infrastructure\Services\Auth;

use Illuminate\Support\Collection;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;
use IvaoBrasil\Infrastructure\Models\Core\User;
use UnitEnum;

class RoleRegistrarService implements RoleRegistrarInterface
{
    public function __construct(private string $divisionCode)
    {
    }

    public function assignRoles(User $user): void
    {
        $user->assignRole($this->getRolesToAssign($user)->pluck('value'));
        $user->save();
    }

    /**
     * @param User $user
     * @return Collection<int, UnitEnum>
     */
    private function getRolesToAssign(User $user): Collection
    {
        $rolesToAssign = collect();

        if ($user->division !== $this->divisionCode || !$user->isStaff()) {
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

        if ($userStaffRoles->isNotEmpty()) {
            $rolesToAssign->push(UserRoles::STAFF);
        }

        $rolesToAssign = $rolesToAssign->concat($userStaffRoles);
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
        return [
            // XX-DIR, XX-ADIR
            UserRoles::DIRECTOR->value => '/-A?DIR$/',

            // XX-SOA, XX-SOAC
            UserRoles::SPEC_OPS_COORDINATOR->value => '/-SOA?C$/',
            // XX-SOA1
            UserRoles::SPEC_OPS_ADVISOR->value => '/-SOA\d+$/',

            // XX-FOC, XX-FOAC
            UserRoles::FLIGHT_OPS_COORDINATOR->value => '/-FOA?C$/',
            // XX-FOA1
            UserRoles::FLIGHT_OPS_ADVISOR->value => '/-FOA\d+$/',

            // XX-AOC, XX-AOAC
            UserRoles::ATC_OPS_COORDINATOR->value => '/-AOA?C$/',
            // XX-AOA1
            UserRoles::ATC_OPS_ADVISOR->value => '/-AOA\d+$/',

            // XX-TC, XX-TAC
            UserRoles::TRAINING_COORDINATOR->value => '/-TA?C$/',
            // XX-TA1
            UserRoles::TRAINING_ADVISOR->value => '/-TA\d+$/',
            // XX-T01
            UserRoles::TRAINER->value => '/-T\d+$/',

            // XX-MC, XX-MAC
            UserRoles::MEMBERS_COORDINATOR->value => '/-MA?C$/',
            // XX-MA1
            UserRoles::MEMBERS_ADVISOR->value => '/-MA\d+$/',

            // XX-EC, XX-EAC
            UserRoles::EVENTS_COORDINATOR->value => '/-EA?C$/',
            // XX-EA1
            UserRoles::EVENTS_ADVISOR->value => '/-EA\d+$/',

            // XX-PRC, XX-PRAC
            UserRoles::PUBLIC_RELATIONS_COORDINATOR->value => '/-PRA?C$/',
            // XX-PRA1
            UserRoles::PUBLIC_RELATIONS_ADVISOR->value => '/-PRA\d+$/',

            // XX-WM, XX-AWM
            UserRoles::WEB_COORDINATOR->value => '/-A?WM$/',
            // XX-WMA1
            UserRoles::WEB_ADVISOR->value => '/-WMA\d+$/',

            // XXXX-CH, XXXX-ACH
            UserRoles::FIR_CHIEF->value => '/-A?CH/',
            // XXXX-ST1
            UserRoles::FIR_SERVICE->value => '/-ST\d+$/',
        ];
    }
}
