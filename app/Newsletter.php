<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $primaryKey = 'newsletter_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'newsletter_id','email','subscribed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
