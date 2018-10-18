<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $primaryKey = 'message_id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id', 'provider_id', 'visitor_id', 'message',
        'time', 'read', 'attachments', 'conversation_id', 'who'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the attachment associated with the message.
     */
    public function attachment()
    {
        return $this->hasOne('App\FileEntry');
    }
    
    public function getMessageIdAttribute($value)
    {
        return ucfirst($value);
    }

    public function getConversationIdAttribute($value)
    {
        return ucfirst($value);
    }
}
