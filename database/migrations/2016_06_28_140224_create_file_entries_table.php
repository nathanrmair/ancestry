<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_entries', function (Blueprint $table) {
            $table->bigIncrements('file_id')->unique();
            $table->string('mime', 64);
            $table->string('original_filename', 64);
            $table->string('filename', 64);
            $table->enum('who',['provider', 'visitor'])->default('visitor');
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('visitor_id')->unsigned();
            $table->bigInteger('message_id')->unsigned();
            $table->foreign('provider_id')->references('user_id')->on('users')
                ->onDelete('cascade');
            $table->foreign('visitor_id')->references('user_id')->on('users')
                ->onDelete('cascade');
            $table->foreign('message_id')->references('message_id')->on('messages')
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
        Schema::drop('file_entries');
    }
}
