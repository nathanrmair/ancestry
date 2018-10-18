<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('provider_monthly_reports', function (Blueprint $table) {
            $table->bigIncrements('provider_monthly_report_id')->unique();
            $table->bigInteger('provider_id')->unsigned();
            $table->integer('page_visits')->default(0);
            $table->integer('messages_unread')->default(0);
            $table->integer('messages_received')->default(0);
            $table->integer('new_conversations')->default(0);
            $table->integer('searches_offered')->default(0);
            $table->integer('searches_accepted')->default(0);
            $table->integer('searches_outstanding')->default(0);
            $table->integer('searches_completed')->default(0);
            $table->integer('credits_earned')->default(0);
            $table->integer('credits_earned_through_visits')->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            $table->foreign('provider_id')->references('provider_id')->on('providers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provider_monthly_reports');
    }
}
