<?php

namespace IvaoBrasil\Infrastructure\Contracts\Auth;

use Illuminate\Support\Collection;
use Spatie\Permission\Contracts\Role;

interface UserRolesInterface
{
    public function assignRole(array|string|int|Role|Collection ...$roles): void;
    public function hasAnyRole(string|int|array|Role|Collection ...$roles): void;
}
