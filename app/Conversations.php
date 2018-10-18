<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{
    protected $primaryKey = 'conversation_id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conversations';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conversation_id', 'provider_id', 'visitor_id', 'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getConversationIdAttribute($value)
    {
        return ucfirst($value);
    }
}
