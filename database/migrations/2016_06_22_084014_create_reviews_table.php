<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('review_id')->unique();
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('visitor_id')->unsigned();
            $table->text('review');
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
        Schema::drop('reviews');
    }
}
