<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Log;

class Ancestor extends Model
{
    protected $primaryKey = 'ancestor_id';

    protected $table = 'ancestors';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visitor_id', 'forename', 'surname', 'town', 'dob', 'dod',
        'gender', 'description', 'origin',
        'clan', 'place_of_birth', 'place_of_death'
    ];
//
//    protected $dates = ['dob','dod'];
//
//    protected $appends = ['parsed_dob,parsed_dod'];

//    public function setDobAttribute($value)
//    {
//        if ($value != null) {
//            $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value);
//        }
//            else{
//                $this->attributes['dob'] = null;
//            }
//    }
//
//    public function setDodAttribute($value)
//    {
//        if ($value != null) {
//            $this->attributes['dod'] = Carbon::createFromFormat('d-m-Y', $value);
//        }
//        else{
//            $this->attributes['dod'] = null;
//        }
//    }
//
//    public function getDobAttribute($value){
//        if(isset($value)){
//            return Carbon::parse($value)->format('d-m-Y');
//        }
//        return null;
//
//    }
//
//    public function getDodAttribute($value){
//        if(isset($value)){
//            return Carbon::parse($value)->format('d-m-Y');
//        }
//        return null;
//    }

    //appended accessors

//    public function getParsedDob(){
//        return Carbon::parse($this->dob)->format('j M Y');
//    }
//
//    public function getParsedDod(){
//        return 'accessor';
//        //return Carbon::parse($this->dod)->format('j M Y');
//    }
    

}
