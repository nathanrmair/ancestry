<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDobDodFieldsToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ancestors', function (Blueprint $table) {
            $table->dropColumn('dob');
            $table->dropColumn('dod');
        });

        Schema::table('ancestors', function (Blueprint $table) {
            $table->string('dob',64)->nullable()->default(null);
            $table->string('dod',64)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ancestors', function (Blueprint $table) {
            //
        });
    }
}
