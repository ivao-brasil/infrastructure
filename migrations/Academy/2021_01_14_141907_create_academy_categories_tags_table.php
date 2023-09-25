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
        Schema::create('academy_categories_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('academy_categories', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('tag_id')
                ->constrained('academy_tags', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('academy_categories_tags');
    }
};
