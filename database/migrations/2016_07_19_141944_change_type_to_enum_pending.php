<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeToEnumPending extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_providers', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('pending_providers', function (Blueprint $table) {
            $table->enum('type',['Museum','Heritage Centre','Archive Centre/Records Office','Family History Society','Library','Other']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_providers', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('pending_providers', function (Blueprint $table) {
            $table->string('type');
        });
    }
}
