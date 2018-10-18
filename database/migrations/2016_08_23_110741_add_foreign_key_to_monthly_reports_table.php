<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToMonthlyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_monthly_reports', function (Blueprint $table) {
            $table->bigInteger('report_id')->unsigned();
            $table->foreign('report_id')->references('report_id')->on('reports')
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
        Schema::table('provider_monthly_reports', function (Blueprint $table) {
            $table->dropColumn('report_id');
        });
    }
}
