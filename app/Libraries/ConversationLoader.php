<?php

namespace app\Libraries;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;


class ConversationLoader
{

    public function loadConversationFromDb($id, $chunkSize, $skipSize){
        $user = Auth::User();
        $userType = '';
        if ($user->type == 'provider') {
            $userType = 'messages.provider_id';
        } else {
            $userType = 'messages.visitor_id';
        }
        $conversation = DB::table('messages')
            ->select('messages.message_id', 'messages.message', 'messages.who', 'messages.time', 'messages.read',
                'messages.attachments', 'messages.visitor_id', 'messages.provider_id', 'file_entries.mime')
            ->leftJoin('file_entries', 'file_entries.message_id', '=', 'messages.message_id')
            ->where([
                ['conversation_id', $id],
                [$userType, $user->user_id]
            ])
            ->orderBy('messages.message_id', 'desc')
            ->limit($chunkSize)
            ->offset($skipSize)
            ->get();
        foreach ($conversation as $convo) {
            $convo->visitor_id = Hashids::encode($convo->visitor_id);
            $convo->provider_id = Hashids::encode($convo->provider_id);
        }
        return $conversation;
    }

    public function markConversationAsRead($conversationId){
        $update = DB::table('messages')
            ->where('conversation_id', $conversationId)
            ->update(['read' => 'yes']);
        return $update;
    }
}