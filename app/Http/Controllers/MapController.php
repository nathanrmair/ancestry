<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MapController extends Controller
{

    public function __construct(){

    }

    static public function getMapKey(){
        return 'AIzaSyCW8ymLpIT9SbwH5qmWrB0b_caZQIN2050';
    }
}
