<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AncestorDocuments extends Model
{
    protected $table = 'ancestor_documents';
    protected $primaryKey = 'document_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mime', 'original_filename', 'filename', 'ancestor_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
