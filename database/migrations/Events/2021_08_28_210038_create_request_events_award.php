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
        Schema::create('events_request_award', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events', 'id');
            $table->foreignId('member_vid')->constrained('users', 'vid');
            $table->foreignId('award_id')->constrained('division_awards', 'id');
            $table->integer('granted');
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
        Schema::dropIfExists('events_request_award');
    }
};
