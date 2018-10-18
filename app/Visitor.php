<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visitor extends Model
{

    protected $primaryKey = 'visitor_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','forename', 'surname','status','member','dob',
        'gender','origin','balance','description','ip'
    ];

    protected $dates = ['dob'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getNameAttribute(){
        return $this->forename . " " . $this->surname;
    }

    public function setDobAttribute($value)
    {
        if ($value != null) {
            $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value);
        }
        else{
            $this->attributes['dob'] = null;
        }
    }

    public function getDobAttribute($value){
        if(isset($value)){
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;

    }
}