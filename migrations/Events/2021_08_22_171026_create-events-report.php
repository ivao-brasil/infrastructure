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
        Schema::create('events_report', function (Blueprint $table) {
            $table->id();
            $table->string('connectionType');
            $table->foreignId('event_id')->constrained('events', 'id');
            $table->string('callsign');
            $table->foreignId('owner_id')->constrained('users', 'vid');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events-report');
    }
};
