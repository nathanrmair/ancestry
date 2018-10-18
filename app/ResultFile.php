<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultFile extends Model
{
    protected $primaryKey = 'search_result_file_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'search_result_files';


    protected $fillable = [
        'mime', 'original_filename', 'filename', 'offered_search_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

}
