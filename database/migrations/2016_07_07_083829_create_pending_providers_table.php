<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_providers', function (Blueprint $table) {
            $table->increments('id')->uniqiue();
            $table->timestamps();
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->string('name');
            $table->string('street_name');
            $table->string('town');
            $table->string('county');
            $table->string('region');
            $table->string('postcode');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('historic_county')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pending_providers');
    }
}
