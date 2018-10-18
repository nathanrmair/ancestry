<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class ProviderUtilitiesController  extends Controller
{

    public function __construct(){
        $this->middleware('isProvider');
    }


    public function visitorById($user_id)
    {
        $user = Auth::User();
        $user_id = Hashids::decode($user_id)[0];

        $visitor = Visitor::where('user_id',$user_id)->first();


        if($visitor!=null) {
            $hasConversation = DB::table('conversations')->where('provider_id',$user->user_id)->where('visitor_id',$user_id)->first();
            if($hasConversation){
                return view('providerViews.overviewOfVisitors', ['user_id' => $user_id]);
            }
        }
        return abort(403);
    }
    
    static public function getVisitorNameById($visitor_id){
        return DB::table('visitors')
            ->select('forename','surname')
            ->where('visitor_id',$visitor_id)
            ->first();
    }
}
