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
        Schema::create('events_reports_remarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('events_report', 'id');
            $table->string('remark');
            $table->foreignId('owner_id')->constrained('users', 'vid');
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
        Schema::dropIfExists('events_reports_remarks');
    }
};
