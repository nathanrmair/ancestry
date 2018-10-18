<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('withdrawal_id')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('credit', 6, 2);
            $table->dateTime('created_at');
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
        Schema::drop('withdrawals');
    }
}
