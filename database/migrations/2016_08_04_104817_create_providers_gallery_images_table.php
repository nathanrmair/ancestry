<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersGalleryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers_gallery_images', function (Blueprint $table) {
            $table->bigIncrements('providers_gallery_images_id');
            $table->string('mime', 64);
            $table->string('original_filename', 64);
            $table->string('filename', 64);
            $table->bigInteger('provider_user_id')->unsigned();
            $table->foreign('provider_user_id')->references('user_id')->on('users')
                ->onDelete('cascade');
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
        Schema::drop('providers_gallery_images');
    }
}
