<?php

namespace IvaoBrasil\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;
use Spatie\Permission\Models\Role;

class CoreUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = UserRoles::cases();
        foreach ($roles as $role) {
            Role::create(['name' => $role->value]);
        }
    }
}
