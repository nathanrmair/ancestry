<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRegionFieldProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('region');
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->enum('region',['Ayrshire','Highlands','Central Scotland','Grampian','Tayside','Fife','Clyde Valley','Hebrides','Argyll','Orkney Islands','Shetland Islands','Borders','Lothian','Dumfries and Galloway'])->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('region');
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->string('region')->nullable()->default(null);
        });
    }
}
