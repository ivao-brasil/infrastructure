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
        Schema::create('tracker_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracker')->nullable(false);
            $table->foreign('id_tracker')
                ->references('id')
                ->on('tracker')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->enum('client_type', ['ATC', 'PILOT']);
            $table->enum('rule_type', ['FROM', 'TO', 'ROUTE', 'ATC']);
            $table->string('params', 255);
            $table->timestamps();

            $table->unique(['id_tracker', 'client_type', 'rule_type', 'params']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_rules');
    }
};
