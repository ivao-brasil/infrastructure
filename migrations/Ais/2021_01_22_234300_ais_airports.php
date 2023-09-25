<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('ais_airports')) {
            Schema::create('ais_airports', function (Blueprint $table) {
                $table->id();
                $table->string('icao', 4);
                $table->json('rwy_configuration')->nullable(true);
                $table->json('rmk')->nullable(true);
                $table->boolean('active');
                $table->foreignId('updated_by')->constrained('users', 'vid');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ais_airports');
    }
};
