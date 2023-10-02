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
        Schema::create('support_award_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_vid')->constrained('users', 'vid');
            $table->string("type");
            $table->string("level");
            $table->boolean("granted");
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
        Schema::dropIfExists('support_award_requests');
    }
};
