<?php

namespace app\Libraries;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessagesHelper{

    public static function getNumberOfUnreadMessages($user){
        $userType = '';
        if ($user->type == 'provider') {
            $userType = 'provider_id';
        } else {
            $userType = 'visitor_id';
        }
        $unread = DB::table('messages')->select(DB::raw('count(*) as message_count'))
            ->where([
                ['read' , 'no'],
                ['who', '<>', $user->type],
                [$userType, $user->user_id]
            ])
            ->first();
//        Log::info(json_encode($unread, true));
        return $unread->message_count;
    }

    public static function getNameOfProvider($provider_id){
        $provider = DB::table('providers')->select('name')
            ->where('user_id',$provider_id)
            ->first();
        return $provider->name;
    }

    public static function getNameOfVisitor($visitor_id){
        $visitor = DB::table('visitors')->select('forename', 'surname')
            ->where('user_id',$visitor_id)
            ->first();
        return $visitor->forename . " " . $visitor->surname;
    }
    
    public static function getLastMessage($conversation_id){
        $message = DB::table('messages')->select('message','time')
            ->where('conversation_id',$conversation_id)
            ->orderBy('message_id', 'desc')
            ->first();


        return preg_replace('/<br(\s+)?\/?>/i', "\n", $message->message);
    }
}