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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_vid')->constrained('users', 'vid');
            $table->foreignId('trainer_vid')->nullable()->constrained('users', 'vid');
            $table->foreignId('training_type_id')->nullable()->constrained('trainings', 'id');
            $table->enum('status', ['requested', 'finished', 'cancelled'])->default('requested');
            $table->text('internal_comments')->nullable();
            $table->text('user_comments')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('trainings');
    }
};
