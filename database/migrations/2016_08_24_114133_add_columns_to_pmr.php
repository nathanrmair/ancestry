<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPmr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_monthly_reports', function (Blueprint $table) {
            $table->bigInteger('total_page_visits')->unsigned()->default(0);
            $table->integer('total_messages')->unsigned()->default(0);
            $table->integer('total_messages_unread')->unsigned()->default(0);
            $table->integer('total_conversations')->unsigned()->default(0);
            $table->integer('total_searches_completed')->unsigned()->default(0);
            $table->integer('report_index')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_monthly_reports', function (Blueprint $table) {
            $table->dropColumn('total_page_visits');
            $table->dropColumn('total_messages');
            $table->dropColumn('total_messages_unread');
            $table->dropColumn('total_conversations');
            $table->dropColumn('total_searches_completed');
            $table->dropColumn('report_index');
            
        });
    }
}
