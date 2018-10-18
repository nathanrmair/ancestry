<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConversationIdToMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function($table) {
            $table->bigInteger('conversation_id')->unsigned();
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
        Schema::table('messages', function($table) {
            $table->dropForeign('messages_conversation_id_foreign');
            $table->dropColumn('conversation_id');
        });
    }
}
