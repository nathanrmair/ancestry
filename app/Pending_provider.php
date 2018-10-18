<?php
namespace App;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Pending_provider extends Model
{

    use ElasticquentTrait;

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'street_name','town','county','region',
        'postcode','type','description','email','password',
        'historic_county',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}