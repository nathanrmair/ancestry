<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchQueries extends Model
{

    protected $table = 'search_queries';

    protected $primaryKey = 'search_query_id';

    protected $fillable = [
        'search_query_id','hits','query'
    ];
}
