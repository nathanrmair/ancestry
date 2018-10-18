<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('transfer_id')->unique();
            $table->decimal('credits', 6, 2);
            $table->enum('type',['message','search']);
            $table->bigInteger('visitor_user_id')->unsigned();
            $table->bigInteger('provider_user_id')->unsigned();
            $table->timestamps();
            $table->foreign('visitor_user_id')->references('user_id')->on('users')
                ->onDelete('cascade');
            $table->foreign('provider_user_id')->references('user_id')->on('users')
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
        Schema::drop('transfers');
    }
}
