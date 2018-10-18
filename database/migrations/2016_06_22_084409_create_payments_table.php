<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id')->unique();
            $table->bigInteger('visitor_id')->unsigned();
            $table->decimal('credit', 6, 2);
            $table->string('reason');
            $table->enum('completed', ['yes','no'])->default('yes');
            $table->enum('approved', ['yes','no'])->default('yes');
            $table->enum('reason_type', [0,1])->default(0);
            $table->date('due_date')->default('1975-1-1');
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
        Schema::drop('payments');
    }
}
