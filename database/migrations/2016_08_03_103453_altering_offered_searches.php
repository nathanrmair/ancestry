<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteringOfferedSearches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offered_searches', function (Blueprint $table) {
          $table->dropColumn('status');
        });
        Schema::table('offered_searches', function (Blueprint $table) {
            $table->enum('status',['accepted','declined','pending','cancelled','completed'])->default('pending');
            $table->text('result_message')->nullable();
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
            Schema::table('offered_searches', function (Blueprint $table) {
                $table->dropColumn('status');
                $table->dropColumn('result_message');
            });
            Schema::table('offered_searches', function (Blueprint $table) {
                $table->enum('status',['accepted','declined','pending'])->default('pending');
            });
        });
    }
}
