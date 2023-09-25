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
        Schema::create('academy_manuals', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->foreignId('author_vid')
                ->nullable()
                ->constrained('users', 'vid')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string("description");
            $table->string("language", 2);
            $table->string("file_path");
            $table->boolean("is_visible");
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
        Schema::dropIfExists('academy_manuals');
    }
};
