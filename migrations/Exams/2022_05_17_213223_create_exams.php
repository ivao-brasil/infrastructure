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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_vid')->constrained('users', 'vid');
            $table->foreignId('examiner_vid')->nullable()->constrained('users', 'vid');
            $table->enum('rating', ['PP', 'SPP', 'CP', 'ADC', 'APC', 'ACC']);
            $table->enum('status', ['requested', 'finished', 'cancelled'])->default('requested');
            $table->smallInteger('score')->nullable();
            $table->text('validator_comments')->nullable();
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
        Schema::dropIfExists('exams');
    }
};
