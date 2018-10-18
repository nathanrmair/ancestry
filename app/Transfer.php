<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $primaryKey = 'transfer_id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transfers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credits', 'visitor_user_id', 'provider_user_id', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}