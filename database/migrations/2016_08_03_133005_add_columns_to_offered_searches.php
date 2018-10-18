<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOfferedSearches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offered_searches', function (Blueprint $table) {
            $table->date('completion_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offered_searches', function (Blueprint $table) {
            $table->dropColumn('completion_date');
        });
    }
}
