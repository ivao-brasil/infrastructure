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
        Schema::table('support_award_requests', function (Blueprint $table) {
            $table->index('type', 'support_award_requests_type');
            $table->index('granted', 'support_award_requests_granted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_award_requests', function (Blueprint $table) {
            $table->dropIndex('support_award_requests_type');
            $table->dropIndex('support_award_requests_granted');
        });
    }
};
