<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ancestors', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('avatars', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('conversations', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('credits', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('file_entries', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('provider_documents', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('visitors', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
