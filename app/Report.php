<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $primaryKey = 'report_id';

    protected $fillable = [
        'report_id','user_id','type'
    ];
}
