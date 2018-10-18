<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvidersGalleryImages extends Model
{
    protected $table = 'providers_gallery_images';
    protected $primaryKey = 'providers_gallery_images_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mime', 'original_filename', 'filename', 'provider_user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
