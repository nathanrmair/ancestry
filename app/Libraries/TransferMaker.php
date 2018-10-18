<?php
namespace app\Libraries;


use App\Credits;
use Illuminate\Support\Facades\Auth;
use App\Transfer;
use App\Visitor;
use App\Provider;


class TransferMaker
{
    public static function make($credits,$type,$visitor_user_id,$provider_user_id){
        $transfer = new Transfer();

        $visitor_credits = Credits::where('user_id',$visitor_user_id)->first();
        $provider_credits = Credits::where('user_id',$provider_user_id)->first();

        $visitor_credits->credits = $visitor_credits->credits - $credits;
        $visitor_credits->save();

        $provider_credits->credits = $provider_credits->credits + $credits;
        $provider_credits->save();

        Transfer::create([
            'credits' => $credits,
            'type' => $type,
            'visitor_user_id' => $visitor_user_id,
            'provider_user_id' => $provider_user_id,
        ]);

    }
}