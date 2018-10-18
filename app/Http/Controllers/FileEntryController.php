<?php

namespace App\Http\Controllers;

use App\FileEntry;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class FileEntryController extends Controller
{

    public function __construct(){
        $this->middleware('paid_members_and_providers');
    }

    public function getBase64(Request $request, $filename, $id){
        if(!$request->ajax()){
            return abort(403);
        }
        $id = Hashids::decode($id)[0];
        $entry = FileEntry::where('filename', '=', $filename)->first();
        $file = Storage::disk('local')->get('user-uploads/' . $id . '/' . $entry->filename);
        $file = base64_encode($file);
        $response = array('base64_data' => $file, 'mime' => $entry->mime, 'original_name' => $entry->original_filename , 'who' => $entry->who);
        return (new Response($response, 200));
    }
}
