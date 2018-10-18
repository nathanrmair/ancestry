<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAncestorDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ancestor_documents', function (Blueprint $table) {
            $table->bigIncrements('document_id');
            $table->string('mime', 64);
            $table->string('original_filename', 64);
            $table->string('filename', 64);
            $table->bigInteger('ancestor_id')->unsigned();
            $table->foreign('ancestor_id')->references('ancestor_id')->on('ancestors')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ancestor_documents');
    }
}
