<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use IvaoBrasil\Infrastructure\Database\Seeders\CoreUserRolesSeeder;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Make sure all previous roles are deleted
        $this->down();

        Artisan::call('db:seed', [
            '--class' => CoreUserRolesSeeder::class,
            '--force' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::query()->delete();
    }
};
