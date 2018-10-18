<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('visitor_id')->unique();
            $table->string('forename');
            $table->string('surname');
            $table->bigInteger('user_id')->unsigned();
            $table->enum('status', [0, 1])->default(0);
            $table->enum('member', [0, 1])->nullable()->default(0);
            $table->date('dob')->nullable()->default('1975-1-1');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('origin')->nullable()->default(null);
            $table->text('description')->nullable();
            $table->bigInteger('avatar_id')->unsigned();
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
        Schema::drop('visitors');
    }
}