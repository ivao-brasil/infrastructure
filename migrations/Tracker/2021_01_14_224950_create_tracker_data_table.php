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
        Schema::create('tracker_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracker')->nullable(false);
            $table->foreign('id_tracker')
                ->references('id')
                ->on('tracker')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->string('vid', 6)->nullable(false);
            $table->string('callsign', 30)->nullable(false);
            $table->enum('client_type', ['ATC', 'PILOT'])->nullable(false);
            $table->string('departure', 4);
            $table->string('destination', 4);
            $table->dateTime('connection_time', 0)->nullable(false);
            $table->dateTime('last_position_time', 0)->nullable(false);
            $table->integer('total_time')->nullable(false);
            $table->string('first_position', 30)->nullable(false);
            $table->string('last_position', 30)->nullable(false);
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
        Schema::dropIfExists('tracker_data');
    }
};
