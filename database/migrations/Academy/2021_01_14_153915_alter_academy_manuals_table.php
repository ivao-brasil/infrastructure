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
        Schema::table('academy_manuals', function (Blueprint $table) {
            $table->dropForeign(['author_vid']);
            $table->dropColumn('author_vid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academy_manuals', function (Blueprint $table) {
            $table->foreignId('author_vid')
                ->nullable()
                ->constrained('users', 'vid')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }
};
