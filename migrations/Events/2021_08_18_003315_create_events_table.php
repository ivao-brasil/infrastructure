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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('tag');
            $table->integer('status');
            $table->integer('atc_reports');
            $table->integer('pilot_reports');
            $table->foreignId('pilot_award_id')->constrained('division_awards', 'id');
            $table->foreignId('atc_award_id')->constrained('division_awards', 'id');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignId('created_by')->constrained('users', 'vid');
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
        Schema::dropIfExists('events');
    }
};
