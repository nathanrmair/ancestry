<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('provider_documents', function (Blueprint $table) {
            $table->bigIncrements('provider_documents_id')->unique();
            $table->bigInteger('provider_id')->unsigned();
            $table->string('filepath');
            $table->text('description');
            $table->foreign('provider_id')->references('user_id')->on('users')
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
        Schema::dropIfExists('provider_documents');
    }
}
