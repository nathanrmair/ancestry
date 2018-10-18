<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{
    protected $primaryKey = 'file_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mime', 'original_filename', 'filename', 'visitor_id', 'provider_id', 'who', 'message_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

}
