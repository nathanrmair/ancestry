<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id')->unique();
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->string('remember_token', 255);
            $table->enum('type',['visitor','provider','admin']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
