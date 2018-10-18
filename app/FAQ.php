<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $primaryKey = 'question_id';

    public $timestamps = false;

    protected $table = 'faqs';
    
    protected $fillable = [
        'question','answer'
    ];
}
