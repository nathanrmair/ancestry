<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferedSearches extends Model
{
    protected $primaryKey = 'offered_search_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offered_searches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'offered_search_id','conversation_id','status' ,'message', 'price', 'created_at', 'updated_at', 'result_message', 'completion_date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

}
