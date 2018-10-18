<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAncestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ancestors', function (Blueprint $table) {
            $table->bigIncrements('ancestor_id')->unique();
            $table->bigInteger('visitor_id')->unsigned();
            $table->string('forename');
            $table->string('surname');
            $table->date('dob')->nullable()->default(null);
            $table->date('dod')->nullable()->default(null);
            $table->enum('gender', ['male','female'])->default('male');
            $table->text('description')->nullable();
            $table->string('clan', 63)->nullable()->default(null);
            $table->string('place_of_birth', 63)->nullable()->default(null);
            $table->string('place_of_death', 63)->nullable()->default(null);
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
        Schema::drop('ancestors');
    }
}
