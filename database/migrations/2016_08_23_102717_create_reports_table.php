<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('report_id')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title')->nullable();
            $table->enum('type',['month', 'annual','other']);
            $table->timestamps();
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
        Schema::drop('reports');
    }
}
