<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferedSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offered_searches', function (Blueprint $table) {
            $table->bigIncrements('offered_search_id')->unique();
            $table->bigInteger('conversation_id')->unsigned();
            $table->integer('price')->unsigned();
            $table->text('message');
            $table->enum('status',['pending', 'accepted', 'declined']);
            $table->timestamps();
            $table->foreign('conversation_id')->references('conversation_id')->on('conversations')
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
        Schema::drop('offered_searches');
    }
}
