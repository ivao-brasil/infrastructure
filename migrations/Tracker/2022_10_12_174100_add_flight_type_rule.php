<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE tracker_rules MODIFY rule_type ENUM('FROM', 'TO', 'ROUTE', 'FLIGHT_TYPE', 'ATC') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE tracker_rules MODIFY rule_type ENUM('FROM', 'TO', 'ROUTE', 'ATC') NOT NULL");
    }
};
