<?php
namespace App\Http\Controllers;

use App\Provider;
use App\ResultFile;
use Illuminate\Support\Facades\DB;
use App\Conversations;
use App\OfferedSearches;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use Vinkla\Hashids\Facades\Hashids;

class SearchesStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('paid_members_and_providers');
    }

    public function show(){

        $user = Auth::user();
        if ($user->type === 'visitor') {
            $conversation_ids = DB::table('conversations')
                ->where('visitor_id', '=', $user->user_id)
                ->lists('conversation_id');
            if ($conversation_ids != null) {
                $searches = OfferedSearches::whereIn('conversation_id', $conversation_ids)->get();
            } else {
                $searches = null;
            }
        } else if ($user->type === 'provider') {
            $conversation_ids = DB::table('conversations')
                ->where('provider_id', '=', $user->user_id)
                ->lists('conversation_id');
            if ($conversation_ids != null) {
                $searches = OfferedSearches::whereIn('conversation_id', $conversation_ids)->get();
            } else {
                $searches = null;
            }
        } else {
            $searches = null;
        }
        return view('profile.searches', ['title' => 'Searches | Dashboard - MyAncestralScotland', 'user' => $user, 'searches' => $searches]);
    }

    public function showASearch($search_id)
    {
        $user = Auth::user();
        $search_id = Hashids::decode($search_id)[0];
        if ($this->checkIfAccessibleForProvider($search_id)) {
            return view('profile.searchDetails', [
                'title' => 'Search Details | Dashboard - MyAncestralScotland',
                'user' => $user,
                'search' => OfferedSearches::where('offered_search_id', $search_id)->first(),
                'docs' => SearchesStatusController::getResultFiles($search_id)]);
        }

        if ($this->checkIfAccessibleForVisitor($search_id)) {
            return view('profile.searchDetails', [
                'title' => 'Search Details | Dashboard - MyAncestralScotland',
                'user' => $user,
                'search' => OfferedSearches::where('offered_search_id', $search_id)->first(),
                'docs' => SearchesStatusController::getResultFiles($search_id)]);
        }

        return abort(404);
    }

    public function completeASearch($search_id)
    {
        $user = Auth::user();
        $search_id = Hashids::decode($search_id)[0];
        if ($this->checkIfCompleted($search_id)) {
            return abort(404);
        }

        if ($this->checkIfAccessibleForProvider($search_id)) {
            return view('profile.complete', [
                'title' => 'Search Details | Dashboard - MyAncestralScotland',
                'user' => $user,
                'search' => OfferedSearches::where('offered_search_id', $search_id)->first()
            ]);
        }

        return abort(404);
    }

    public function sendCompleteSearch($search_id, Request $request)
    {
        $search_id = Hashids::decode($search_id)[0];
        if (!$this->checkIfAccessibleForProvider($search_id)) {
            return abort(404);
        }

        $validator = $this->validatorComplete($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->updateComplete($request, $search_id);

        $search = OfferedSearches::where('offered_search_id', $search_id)->first();
        $conversation = Conversations::where('conversation_id', $search->conversation_id)->first();
        $provider = Provider::where('user_id', $conversation->provider_id)->first();
        $visitor_user = User::where('user_id', $conversation->visitor_id)->first();


        Mail::send('emails.completed', ['name' => $provider->name], function ($message) use ($visitor_user) {
            $message->to($visitor_user['email'])->subject('Search completed');
        });

        Flash::message('You successfully completed a search!', 'success')->important();

        return redirect('/profile/searches');
    }

    protected function checkIfCompleted($search_id)
    {
        $search = OfferedSearches::where('offered_search_id', $search_id)->first();

        if ($search != null) {
            if ($search->status === 'completed') {
                return true;
            }
        }
        return false;
    }

    protected function checkIfAccessibleForProvider($search_id)
    {
        if (OfferedSearches::where('offered_search_id', $search_id)->first() != null) {
            $user = Auth::user();
            if ($user->type === 'provider') {
                $conversation = Conversations::where('conversation_id', OfferedSearches::where('offered_search_id', $search_id)->first()->conversation_id)->first();
                if ($conversation->provider_id == $user->user_id) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function checkIfAccessibleForVisitor($search_id)
    {
        if (OfferedSearches::where('offered_search_id', $search_id)->first() != null) {
            $user = Auth::user();
            if ($user->type === 'visitor') {
                $conversation = Conversations::where('conversation_id', OfferedSearches::where('offered_search_id', $search_id)->first()->conversation_id)->first();
                if ($conversation->visitor_id == $user->user_id) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function updateComplete(Request $request, $search_id)
    {
        $user = Auth::User();
        $offered_search = OfferedSearches::where('offered_search_id', $search_id)->first();

        if ($request->has('message')) {
            $offered_search->result_message = $request->input('message');
        }

        $offered_search->status = 'completed';

        $offered_search->save();

        $file = null;
        $entry = null;
        if ($request->hasFile('fileinput')) {
            $files = $request->file('fileinput');
            foreach ($files as $file) {
                if (!empty($file)) {
                    $document = new ResultFile();
                    Storage::disk('local')->put('user-uploads/' . $user->user_id . '/search-results/' . $search_id . '/' . $file->getFilename() . '.' . $file->getClientOriginalExtension(), File::get($file));
                    $document->mime = $file->getClientMimeType();
                    $document->original_filename = $file->getClientOriginalName();
                    $document->filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
                    $document->offered_search_id = $search_id;
                    $document->save();
                }
            }
        }
    }

    protected function validatorComplete(array $data)
    {
        return Validator::make($data, [
            'message' => 'required'
        ]);
    }

    static public function getResultFiles($search_id)
    {
        $docs = ResultFile::where('offered_search_id', $search_id)->get();
        return $docs;
    }

    static public function getResultFilesBase64($file_id, $search_id, $provider_user_id)
    {
        $entry = ResultFile::where('search_result_file_id', $file_id)->first();
        $mime = $entry->mime;
        $file = Storage::disk('local')->get('user-uploads/' . $provider_user_id . '/search-results/' . $search_id . '/' . $entry->filename);
        $base64 = base64_encode($file);

        $source = "data:" . $mime . ";base64," . $base64;
        return $source;
    }

}