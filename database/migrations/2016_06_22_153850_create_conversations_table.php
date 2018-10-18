<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('conversation_id')->unique();
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('visitor_id')->unsigned();
            $table->timestamp('date_started');
            $table->foreign('provider_id')->references('user_id')->on('providers')
                ->onDelete('cascade');
            $table->foreign('visitor_id')->references('user_id')->on('visitors')
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
        Schema::drop('conversations');
    }
}
