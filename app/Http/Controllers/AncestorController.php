<?php

namespace App\Http\Controllers;

use App\AncestorDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Ancestor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use Mockery\CountValidator\Exception;


class AncestorController extends Controller
{

    private $manFields = ['surname', 'forename'];

    public function __construct()
    {
        $this->middleware('auth');

    }

    function createAncestorPage(){
        return view('ancestors.editAncestor', ['title' => 'Add an ancestor | Dashboard - MyAncestralScotland', 'manFields' => $this->manFields]);
    }

    function ancestors()
    {

        $user = Auth::User();
        if ($user->type == 'visitor') {
            return view('ancestors.ancestors', ['user_id' => $user->user_id, 'visitor_id' => $user->user_id]);
        }
        return abort('404');
    }

    function editAncestor(Request $request)
    {

        $user = Auth::User();
        $errors = [];


        //check that mandatory fields have been filled in
        if (!$request->has('ancestor_id')) {

            $missing = [];
            $manFields = $this->manFields;

            for ($i = 0; $i < count($manFields); $i++) {
                $field = $manFields[$i];
                if (!$request->has($field)) {
                    array_push($missing, $field);
                }
            }

//            if (count($missing) > 0) {
//                $error = ('Missing the following field(s) - ' . ProfileController::legibleParse($missing) . '. Please fill in all of the fields marked with an *.');
//                array_push($errors, $error);
//            }

        }

        $badDateFormat = [];

        if ($request->has('ancestor_id')) {
            $ancestor = Ancestor::where('ancestor_id', '=', $request->input('ancestor_id'))->first();
        } else {
            $ancestor = new Ancestor();
            $ancestor->visitor_id = DB::table('visitors')->where('user_id', '=', $user->user_id)->value('user_id');
        }

        if ($request->has('forename')) {
            $ancestor->forename = trim($request->input('forename'));
        }

        if ($request->has('surname')) {
            $ancestor->surname = trim($request->input('surname'));
        }

        if ($request->has('dob')) {
            $ancestor->dob = trim($request->input('dob'));
        } else {
            $ancestor->dob = null;
        }

        if ($request->has('dod')) {
            $ancestor->dod = trim($request->input('dod'));
        } else {
            $ancestor->dod = null;
        }

        if ($request->has('sex')) {
            $ancestor->gender = $request->input('sex');
        }

        if ($request->has('description')) {
            $ancestor->description = trim($request->input('description'));
        } else {
            $ancestor->description = null;
        }

        if ($request->has('clan')) {
            $ancestor->clan = trim($request->input('clan'));
        } else {
            $ancestor->clan = null;
        }

        if ($request->has('place_of_birth')) {
            $ancestor->place_of_birth = $request->input('place_of_birth');
        } else {
            $ancestor->place_of_birth = null;
        }

        if ($request->has('place_of_death')) {
            $ancestor->place_of_death = $request->input('place_of_death');
        } else {
            $ancestor->place_of_death = null;
        }

//        if (count($badDateFormat) > 0) {
//            $error = 'The following field(s) - ' . ProfileController::legibleParse($badDateFormat) . ' - are incorrectly formatted.
//            Please enter the date in the format of "yyyy-mm-dd". For example, the 25th of May in the year 1800 would look like the following: "1800-05-25".';
//
//            array_push($errors, $error);
//        }
        if (count($errors) == 0) {
            $ancestor->save();
        }
        $file = null;
        $entry = null;
        if ($request->hasFile('fileinput')) {
            $files = $request->file('fileinput');
            foreach ($files as $file) {
                if (!empty($file)) {
                    $document = new AncestorDocuments();
                    Storage::disk('local')->put('user-uploads/' . $user->user_id . '/ancestors/' . $ancestor->ancestor_id . '/' . $file->getFilename() . '.' . $file->getClientOriginalExtension(), File::get($file));
                    $document->mime = $file->getClientMimeType();
                    $document->original_filename = $file->getClientOriginalName();
                    $document->filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
                    $document->ancestor_id = $ancestor->ancestor_id;
                    $document->save();
                }
            }
        }
        if (count($errors) == 0) {
            return redirect('ancestors');
        } else {
            ProfileController::FlashError($errors);
            return back()->withInput();
        }

    }

    function deleteAncestor(Request $request)
    {

        $user = Auth::User();


        if ($request->has('confirmed')) {
            DB::table('ancestors')->where('ancestor_id', '=', $request->input('ancestor_id'))->delete();
        } else {
            return view('ancestors.deleteAncestor', ['ancestor_id' => $request->input('ancestor_id')]);
        }

        return redirect('ancestors');

    }

    function editAncestorPage($ancestorId)
    {
        return view('ancestors.editAncestor', ['title' => 'Add an ancestor | Dashboard - MyAncestralScotland', 'ancestorId' => $ancestorId, 'manFields' => $this->manFields]);
    }

    static public function getAncestor($ancestor_id)
    {
        return Ancestor::find($ancestor_id);
        //return DB::table('ancestors')->where('ancestor_id', '=', $ancestor_id)->first();
    }

    static public function getAncestorDocuments($ancestor_id)
    {
        $docs = AncestorDocuments::where('ancestor_id', $ancestor_id)->get();
        return $docs;
    }

    static public function getAncestors($visitor_id)
    {
        //return Ancestor::find(DB::table('ancestors')->where('visitor_id', '=', $visitor_id)->value('ancestor_id'));
        return Ancestor::where('visitor_id', $visitor_id)->get();
        //return DB::table('ancestors')->where('visitor_id', '=', $visitor_id)->orderBy('surname', 'ASC')->orderBy('forename', 'ASC')->get();
    }

    static public function hasAncestors($visitor_id)
    {

        $ancestor =  Ancestor::where('visitor_id', '=', $visitor_id)->first();

        if($ancestor!=null){
            return true;
        }
        return false;
    }

    static public function ancestorBelongsToVisitor($ancestor_id, $visitor_id)
    {
        return Ancestor::where('visitor_id', '=', $visitor_id)->where('ancestor_id', '=', $ancestor_id)->first();
    }

    static public function getAncestorDocumentBase64($document_id, $ancestor_id, $user_id)
    {

        $entry = AncestorDocuments::where('document_id', $document_id)->first();
        $mime = $entry->mime;
        $file = Storage::disk('local')->get('user-uploads/' . $user_id . '/ancestors/' . $ancestor_id . '/' . $entry->filename);
        $base64 = base64_encode($file);

        $source = "data:" . $mime . ";base64," . $base64;
        return $source;
    }
}
