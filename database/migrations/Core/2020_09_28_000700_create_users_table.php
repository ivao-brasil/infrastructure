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
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('vid')->unsigned()->primary();
            $table->string('firstName');
            $table->string('lastName');
            $table->tinyInteger('atcRating')->unsigned();
            $table->tinyInteger('pilotRating')->unsigned();
            $table->string('division', 2);
            $table->string('country', 2);
            $table->json('staff');
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
        Schema::dropIfExists('users');
    }
};
