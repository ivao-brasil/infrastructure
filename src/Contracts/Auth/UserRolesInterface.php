<?php

namespace IvaoBrasil\Infrastructure\Contracts\Auth;

interface UserRolesInterface
{
    /**
     * Assign the given role to the model.
     *
     * @param  array|string|int|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection  ...$roles
     * @return $this
     */
    public function assignRole(...$roles);

    /**
     * Determine if the model has any of the given role(s).
     *
     * Alias to hasRole() but without Guard controls
     *
     * @param  string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection  $roles
     */
    public function hasAnyRole(...$roles);
}
