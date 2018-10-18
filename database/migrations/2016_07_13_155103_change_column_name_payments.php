<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNamePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['visitor_id']);
            $table->renameColumn('visitor_id', 'user_id');
            $table->foreign('user_id')->references('user_id')->on('users')
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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'visitor_id');
            $table->foreign('visitor_id')->references('user_id')->on('users')
                ->onDelete('cascade');
        });
    }
}
