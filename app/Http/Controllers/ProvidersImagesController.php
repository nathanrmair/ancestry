<?php

namespace App\Http\Controllers;

use App\ProvidersGalleryImages;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class ProvidersImagesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('isProvider');
    }

    public function getProvidersImagesView(){
        $entries = ProvidersGalleryImages::where('provider_user_id', Auth::User()->user_id)->get();
        return view('profile.gallery', ['images' => $entries, 'title' => 'Gallery | Dashboard - MyAncestralScotland']);
    }

    public static function getImageSrc($entry, $provider_user_id){
        $file = Storage::disk('local')->get('user-uploads/' . $provider_user_id . '/gallery/' . $entry->filename);
        $base64 = base64_encode($file);
        return "data:" . $entry->mime . ";base64," . $base64;
    }

    public function deleteImage($image_id, Request $request){
        if(!$request->ajax()){
            return abort(403);
        }
        $file = ProvidersGalleryImages::where('providers_gallery_images_id',$image_id)->first();

        $user = Auth::user();

        Storage::disk('local')->delete('user-uploads/' . $user->user_id . '/gallery/' . $file->filename);

        $file->delete();

        return array('success' => true);

    }

    public function addMoreImages(Request $request){

        $imageValidator = new ImageUploadValidator();
        $imageValidator->validateImageUpload($request,'fileinput');

        $user = Auth::User();
        if ($request->hasFile('fileinput')) {
            $files = $request->file('fileinput');
            foreach($files as $file) {
                if(!empty($file)) {
                    $image = new ProvidersGalleryImages();
                    Storage::disk('local')->put('user-uploads/' . $user->user_id . '/gallery/' . $file->getFilename() . '.' . $file->getClientOriginalExtension(), File::get($file));
                    $image->mime = $file->getClientMimeType();
                    $image->original_filename = $file->getClientOriginalName();
                    $image->filename = $file->getFilename() . '.' . $file->getClientOriginalExtension();
                    $image->provider_user_id = $user->user_id;
                    $image->save();
                }
            }
        }
        return redirect('/profile/mygallery');
    }
}
