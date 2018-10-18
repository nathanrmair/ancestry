<?php

namespace App\Http\Controllers;

use App\OfferedSearches;
use App\User;
use App\Conversations;
use App\Credits;
use App\FileEntry;
use app\Libraries\ConversationLoader;
use app\Libraries\MessagesHelper;
use app\Libraries\TransferMaker;
use App\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Jobs\SendNewMessageReminderEmail;
use App\Visitor;
use App\Provider;
use App\Avatar;
use App\Http\Errors;
use \Vinkla\Hashids\Facades\Hashids;

class MessagesController extends Controller
{

    private $conversation_loader;


    public function __construct()
    {
        $this->conversation_loader = new ConversationLoader();
        $this->middleware('paid_members_and_providers');
    }

    /**
     * Gets called from the /profile/dashboard/messages through HTTP GET
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View the messages view
     */
    public function showSummaryOfMessages()
    {
        $user = Auth::User();
        if ($user->type == 'provider') {
            $userType = 'provider_id';
        } else {
            $userType = 'visitor_id';
        }

        $preview = DB::select(DB::raw("SELECT * FROM messages s JOIN (SELECT MAX(message_id) AS id FROM messages WHERE $userType = :visitor_id GROUP BY conversation_id )
              max ON s.message_id= max.id ORDER BY message_id desc"), array(
            'visitor_id' => $user->user_id,
        ));

        if (count($preview) == 0) {
            $lastConvId = 0;
            $lastConvName = " ";
        } else {
            $lastConvId = $preview[0]->conversation_id;
            if ($user->type == 'visitor') {
                $lastConvName = MessagesHelper::getNameOfProvider($preview[0]->provider_id);
            } else {
                $lastConvName = MessagesHelper::getNameOfVisitor($preview[0]->visitor_id);

            }
            foreach ($preview as $convo) {
                $convo->conversation_id = Hashids::encode($convo->conversation_id);
                $convo->visitor_source = $this->getAvatarSourceVisitor($convo->visitor_id);
                $convo->provider_source = $this->getAvatarSourceProvider($convo->provider_id);
                $convo->visitor_id = Hashids::encode($convo->visitor_id);
                $convo->provider_id = Hashids::encode($convo->provider_id);
            }

        }
        return view('messages', ['title' => ' Messages | Dashboard - MyAncestralScotland',
            'conversations' => $preview,
            'lastConvId' => Hashids::encode($lastConvId),
            'lastConvName' => $lastConvName,
            'offered_searches' => '']);
    }

    /**
     * Endpoint available only through ajax which retrieves the specified conversation
     *@return json conversation object
     */
    public function getConversation(Request $request)
    {
        if(!$request->ajax()){
            return abort(403);
        }
        $id = Hashids::decode($request->get('id'))[0];
        $chunkSize = $request->get('size');
        $offset = $request->get('offset');
        $this->conversation_loader->markConversationAsRead($id);
        return $this->conversation_loader->loadConversationFromDb($id, $chunkSize, $offset);
    }

    /**
     * Endpoint available only through ajax which inserts a new message to the conversation
     * @param Request $request contains the provider id, visitor id, conversation id, message, and the file if any
     * @return array returns the message and the attachment if successful, an array contains the error otherwise
     */
    public function createNewMessage(Request $request)
    {
        if(!$request->ajax()){
            return abort(403);
        }
//        Log::info($request->all());
        $user = Auth::User();

        $visitorId = Hashids::decode($request->input('visitorId'))[0];
        $providerId = Hashids::decode($request->input('providerId'))[0];
        $conversationId = Hashids::decode($request->input('conversationId'))[0];
        if ($user->type === 'visitor') {
            $credits = Credits::where('user_id', $user->user_id)->first();
            if (!isset($credits) || $credits->credits === 0) {
                return ['errors' => 1000];
            } else {
                TransferMaker::make(5, 'message', $user->user_id, $providerId);
            }
        }
        $message = $request->input('message');
        $file = null;
        $entry = null;
        if ($request->hasFile('fileinput') && $request->file('fileinput')->isValid()) {
            $file = $request->file('fileinput');
            $extension = $file->getClientOriginalExtension();
            Storage::disk('local')->put('user-uploads/' . $user->user_id . '/' . $file->getFilename() . '.' . $extension, File::get($file));
            $entry = new FileEntry();
            $entry->mime = $file->getClientMimeType();
            $entry->original_filename = $file->getClientOriginalName();
            $entry->filename = $file->getFilename() . '.' . $extension;
            $entry->visitor_id = $visitorId;
            $entry->provider_id = $providerId;
            $entry->who = $user->type;
        }

        $new_message = new Messages();
        $new_message->visitor_id = $visitorId;
        $new_message->provider_id = $providerId;
        $new_message->conversation_id = $conversationId;
        $new_message->message = nl2br($message);
        $new_message->who = $user->type;
        $new_message->attachments = ($file == null) ? null : $file->getFilename() . '.' . $extension;
        $new_message->save();


        if ($entry != null) {
            $entry->message_id = $new_message->message_id;
            $entry->save();
        }

        if ($user->type === 'provider') {
            $otheruser = User::where('user_id', $visitorId)->first();
            $username = Provider::where('user_id', $providerId)->first();
            $name = $username->name;
        } else {
            $otheruser = User::where('user_id', $providerId)->first();
            $username = Visitor::where('user_id', $visitorId)->first();
            $name = $username->forename . ' ' . $username->surname;
        }
        $this->dispatch(new SendNewMessageReminderEmail($otheruser, $message, $name));
        return ['message' => json_encode($new_message), 'attachment' => json_encode($entry)];

    }

    public function userType(Request $request)
    {
        if(!$request->ajax()){
            return abort(403);
        }
        $user = Auth::User();
        return $user->type;
    }

    public function createNewConversation(Request $request)
    {
        if(!$request->ajax()){
            return abort(403, 'Unauthorized action.');
        }
        $user = Auth::User();
        $providerId = Hashids::decode($request->input('providerId'))[0];
        $userMessage = $request->input('message');

        $firstMessage = true;
        $exists = Conversations::where('provider_id', $providerId)->where('visitor_id', $user->user_id)->first();
        if (count($exists)) {
            $firstMessage = false;
        }

        if ($user->type === 'visitor') {
            $credits = Credits::where('user_id', $user->user_id)->first();
            if($firstMessage){
                if (!isset($credits) || $credits->credits < 20) {
                    return ['errors' => 1000];
                } else {
                    TransferMaker::make(20, 'message', $user->user_id, $providerId);
                }
            }
            else {
                if (!isset($credits) || $credits->credits < 5) {
                    return ['errors' => 1000];
                } else {
                    TransferMaker::make(5, 'message', $user->user_id, $providerId);
                }
            }
            $visitor = Visitor::where('user_id', $user->user_id)->first();

            if($visitor->forename == null || $visitor->surname == null){
                return  ['errors' => 3000]; // INCOMPLETE PROFILE
            }
        }


        if (count($exists)) {
            $new_message = new Messages();
            $new_message->visitor_id = $user->user_id;
            $new_message->provider_id = $providerId;
            $new_message->conversation_id = $exists->conversation_id;
            $new_message->message = $userMessage;
            $new_message->who = $user->type;
            $new_message->save();
            return ["status" => "Already Exists"];
        } else {

            // Create the new conversation
            $conversation = new Conversations();
            $conversation->provider_id = $providerId;
            $conversation->visitor_id = $user->user_id;
            $conversation->save();

            //Insert the first message to the conversation
            $message = new Messages();
            $message->provider_id = $providerId;
            $message->visitor_id = $user->user_id;
            $message->message = $userMessage;
            $message->conversation_id = $conversation->conversation_id;
            $message->who = 'visitor';
            $message->save();

//            Log::info('MessagesController:: ' . 'Message should be inserted: ' . $userMessage . ' with id: ' . $providerId);
        }
        return ["status" => "Success"];
    }

    public function checkForNew(Request $request)
    {
        if(!$request->ajax()){
            return abort(403);
        }
        $conversationId = Hashids::decode($request->get('id'))[0];
        $user = Auth::User();
        if ($user->type == 'provider') {
            $typeToSearchFor = 'visitor';
        } else {
            $typeToSearchFor = 'provider';
        }
        $matchThese = ['conversation_id' => $conversationId, 'read' => 'no', 'who' => $typeToSearchFor];
        $messages = Messages::where($matchThese)->orderBy('message_id', 'asc')->first();
        $attachment = null;
        if (count($messages)) {
            $attachment = FileEntry::where('message_id', $messages->message_id)->first();
            $this->conversation_loader->markConversationAsRead($messages->conversation_id);
        }
        return ['message' => json_encode($messages), 'attachment' => json_encode($attachment)];
    }

    public function checkForUnreadConversation(Request $request, $id)
    {
        if(!$request->ajax()){
            return abort(403);
        }
        $conversation = Messages::where('conversation_id', Hashids::decode($id)[0])->first();
        return $conversation;
    }

    public function getAvatarSourceVisitor($visitor_id)
    {
        $visitor = Visitor::where('user_id', '=', $visitor_id)->first();

        if ($visitor && $visitor->avatar_id != 0) {
            $entry = Avatar::where('avatar_id', '=', $visitor->avatar_id)->first();
            $mime = $entry->mime;
            $file = Storage::disk('local')->get('avatars/' . $visitor->user_id . '/' . $entry->filename);
            $base64 = base64_encode($file);
            $source = "data:" . $mime . ";base64," . $base64;
            return json_encode($source);
        }
        return json_encode("null");

    }

    public function getAvatarSourceProvider($provider_id)
    {
        $provider = Provider::where('user_id', $provider_id)->first();
        if ($provider && $provider->avatar_id != 0) {
            $entry = Avatar::where('avatar_id', '=', $provider->avatar_id)->first();
            $mime = $entry->mime;
            $file = Storage::disk('local')->get('avatars/' . $provider->user_id . '/' . $entry->filename);
            $base64 = base64_encode($file);
            $source = "data:" . $mime . ";base64," . $base64;
            return json_encode($source);
        }
        return json_encode("null");

    }

    public function offerASearch(Request $request){
        $price = $request->input('price');
        $message = $request->input('short-message');
        $completion_date = $request->input('date-of-completion');
        $conversation_id = Hashids::decode($request->input('conversation_id'))[0];
        $newSearch = new OfferedSearches();

        $comp_date = date("Y-m-d", strtotime($completion_date));

        $newSearch->price = $price;
        $newSearch->message = $message;
        $newSearch->conversation_id = $conversation_id;
        $newSearch->status = 'pending';
        $newSearch->completion_date = $comp_date;
        $newSearch->save();
        return redirect('/profile/dashboard/messages');
    }

    public function getOfferedSearches(Request $request){
        if(!$request->ajax()){
            return abort(403);
        }
        $id = $request->get('conversation_id');
        if(isset($id)) {
            $conversation_id = Hashids::decode($id)[0];
        }else{
            return abort(404);
        }
        $offeredSearches = OfferedSearches::where(['conversation_id' => $conversation_id, 'status' => 'pending'])->first();
        return ($offeredSearches == null) ? 'null' : $offeredSearches;
    }

    public function acceptSearchOffer(Request $request){
        if(!$request->ajax()){
            return abort(403);
        }
        $conversation_id = Hashids::decode($request->get('conversation_id'))[0];
        $conversation = Conversations::where(['conversation_id' => $conversation_id])->first();
        if ($conversation == null){
            return 'false';
        }

        $visitor_user_id = $conversation->visitor_id;
        $provider_user_id = $conversation->provider_id;

        $transfer_credits = OfferedSearches::where(['conversation_id' => $conversation_id, 'status' => 'pending'])->first()->price;


        $visitor_credits = Credits::where('user_id', $visitor_user_id)->first();
        if ($visitor_credits->credits < $transfer_credits) {
            return ['errors' => 1000];
        } else {
            TransferMaker::make($transfer_credits, 'search', $visitor_user_id, $provider_user_id);
        }
        return $this->changeStatusOfOffer($conversation_id, 'accepted');

    }

    public function declineSearchOffer(Request $request){
        if(!$request->ajax()){
            return abort(403);
        }
        $conversation_id = Hashids::decode($request->get('conversation_id'))[0];
        return $this->changeStatusOfOffer($conversation_id, 'declined');
    }

    public function cancelSearchOffer(Request $request){
        if(!$request->ajax()){
            return abort(403);
        }
        $conversation_id = Hashids::decode($request->get('conversation_id'))[0];
        return $this->changeStatusOfOffer($conversation_id, 'cancelled');
    }

    private function changeStatusOfOffer($conversation_id, $status){
        $conversation_id = $conversation_id;
        $offeredSearches = OfferedSearches::where(['conversation_id' => $conversation_id, 'status' => 'pending'])->first();
        if ($offeredSearches == null) return 'false';
        $offeredSearches->status = $status;
        $offeredSearches->save();
        return $offeredSearches->status;
    }
}

