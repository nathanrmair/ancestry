<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credits extends Model
{
    protected $primaryKey = 'credit_id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'credits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credits', 'cost', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
