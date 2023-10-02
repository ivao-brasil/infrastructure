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
        Schema::create('tracker', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('description', 255)->nullable(false);
            $table->dateTime('date_start')->nullable(false);
            $table->dateTime('date_end')->nullable(false);
            $table->enum('status', ['CREATED', 'ACTIVE', 'FINISHED', 'CANCELLED'])->default('created');
            $table->string('creator', 6)->nullable(false);
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
        Schema::dropIfExists('tracker');
    }
};
