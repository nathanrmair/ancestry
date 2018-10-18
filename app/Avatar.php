<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $primaryKey = 'avatar_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mime', 'original_filename', 'filename', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

}
