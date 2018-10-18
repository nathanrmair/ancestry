<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('provider_id')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('avatar_id')->unsigned();
            $table->string('name');
            $table->string('street_name');
            $table->string('town');
            $table->string('county');
            $table->string('region');
            $table->string('postcode');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('historic_county')->nullable();
            $table->string('open_hour')->nullable();
            $table->string('close_hour')->nullable();
            $table->string('prices')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')
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
        Schema::drop('providers');
    }
}
