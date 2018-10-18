<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('message_id')->unique();
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('visitor_id')->unsigned();
            $table->text('message');
            $table->timestamp('time');
            $table->enum('read', ['yes', 'no'])->default('no');
            $table->string('attachments')->nullable()->default(null);
            $table->foreign('provider_id')->references('user_id')->on('users')
                ->onDelete('cascade');
            $table->foreign('visitor_id')->references('user_id')->on('users')
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

        Schema::drop('messages');
    }
}
