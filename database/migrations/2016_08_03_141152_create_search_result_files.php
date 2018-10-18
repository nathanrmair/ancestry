<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchResultFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_result_files', function (Blueprint $table) {
            $table->bigIncrements('search_result_file_id')->unique();
            $table->bigInteger('offered_search_id')->unsigned();;
            $table->string('mime', 64);
            $table->string('original_filename', 64);
            $table->string('filename', 64);
            $table->timestamps();
            $table->foreign('offered_search_id')->references('offered_search_id')->on('offered_searches')
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
        Schema::drop('search_result_files');
    }
}
