<?php
namespace App\Http\Controllers;

use App\Jobs\ReIndexProviders;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\User;
use App\Provider;
use App\Ancestor;
use App\Visitor;
use App\Avatar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;
use Carbon\Carbon;


class ProfileController extends Controller
{
    private $visitorManFields = ['email', 'password'];
    private $providerManFields = ['email', 'password', 'name', 'town', 'postcode', 'street_name', 'county', 'type'];

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function editProfile()
    {
        $user = Auth::User();
        $manFields = $this->getManFields($user->type);
        return view('profile.editprofile', ['title' => 'Edit your profile | Dashboard - MyAncestralScotland',
            'data' => $this->getUserSubclassData(), 'user' => $user, 'source' => $this->getAvatarSource($user->user_id), 'manFields' => $manFields]);

    }

    private function getUserSubclassData()
    {

        $user = Auth::User();

        if (!isset($user)) {
            return ['type' => "unregistered"];
        }

        $data = null;

        if ($user->type == 'visitor') {
            $data = Visitor::where('visitors.user_id', $user->user_id)
                ->first();
        } else if ($user->type == 'provider') {
            $data = Provider::where('providers.user_id', $user->user_id)
                ->first();
        }
        return $data;

    }

    public function editProfileSubmit(Request $request)
    {

        $user = Auth::User();
        $errors = [];

        //check that mandatory fields have been filled in
        if ($request->has('noscript')) {

            $missing = [];
            $manFields = $this->getManFields($user->type);

            if ($request->has('email')) {
                if (!$request->has('password')) {
                    array_push($missing, 'password');
                }
            }

            for ($i = 2; $i < count($manFields); $i++) {
                $field = $manFields[$i];
                if (!$request->has($field)) {
                    array_push($missing, $field);
                }
            }

            if (count($missing) > 0) {
                array_push($errors, ('Missing the following fields: ' . ProfileController::legibleParse($missing) . '. Please fill in all of the fields marked with an *.'));
            }

        }


        $imageValidator = new ImageUploadValidator();
        $imageValidator->validateImageUpload($request, 'avatar');


        //for email
        if ($request->has('email') && $request->input('email') !== $user->email) {

            if (Hash::check($request->input('password'), $user->password)) {
                if (User::where('email', '=', trim($request->input('email')))->first() == null) {
                    $user->email = trim($request->input('email'));
                    $user->save();
                    Flash::message('Email address has been updated!', 'success')->important();
                } else {

                    array_push($errors, ('An account with this email address already exists!'));
                }
            } else {

                array_push($errors, ('Entered password does not match our records!'));
            }
        }

        if ($user->type == 'provider') {

            $data = Provider::where('user_id', '=', $user->user_id)->first();

            if ($request->has('name')) {
                $data->name = trim($request->input('name'));
            }

            if ($request->has('type')) {
                $data->type = $request->input('type');
            }

            if ($request->has('description')) {
                $data->description = trim($request->input('description'));
            } else {
                $data->description = null;
            }

            if ($request->has('keywords')) {
                $data->keywords = ProfileController::convertFromUser($request->input('keywords'));
            } else {
                $data->keywords = null;
            }

            if ($request->has('street_name')) {
                $data->street_name = trim($request->input('street_name'));
            }

            if ($request->has('town')) {
                $data->town = trim($request->input('town'));
            }

            if ($request->has('county')) {
                $data->county = $request->input('county');
            }

            if ($request->has('region')) {
                $data->region = $request->input('region');
            }

            if ($request->has('historic_county')) {
                $data->historic_county = $request->input('historic_county');
            } else {
                $data->historic_county = null;
            }

            if ($request->has('postcode')) {
                $data->postcode = trim($request->input('postcode'));
            }

            if ($request->has('open_hour')) {
                $data->open_hour = trim($request->input('open_hour'));
            } else {
                $data->open_hour = null;
            }

            if ($request->has('close_hour')) {
                $data->close_hour = trim($request->input('close_hour'));
            } else {
                $data->close_hour = null;
            }

            if ($request->has('prices')) {
                $data->prices = trim($request->input('prices'));
            } else {
                $data->prices = null;
            }

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $avatar = $this->createAvatar($request);
                $data->avatar_id = $avatar->avatar_id;
            }
            if (count($errors) == 0) {
                $data->save();
                $this->dispatch(new ReIndexProviders());
                return redirect('/profile/dashboard');

            } else {
                ProfileController::FlashError($errors);
                return back()->withInput($request->except('password'));
            }


        } else if ($user->type == 'visitor') {

            $data = Visitor::where('user_id', '=', $user->user_id)->first();

            if ($request->has('forename')) {
                $data->forename = $request->input('forename');
            }

            if ($request->has('surname')) {
                $data->surname = $request->input('surname');
            }

            if ($request->has('dob')) {
                if (ProfileController::inDateFormat($request->input('dob'))) {
                    $data->dob = $request->input('dob');

                } else {
                    array_push($errors, 'Date of birth field is incorrectly formatted.
            Please enter the date in the format of "yyyy-mm-dd". For example, the 25th of May in the year 1800 would look like the following: "1800-05-25".');
                }

            } else {

                $data->dob = null;

            }

            if ($request->has('sex')) {
                $data->gender = $request->input('sex');
            }

            if ($request->has('country')) {
                $data->origin = $request->input('country');
            } else {
                $data->origin = null;
            }

            if ($request->has('description')) {
                $data->description = $request->input('description');
            } else {
                $data->description = null;
            }

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $avatar = $this->createAvatar($request);
                $data->avatar_id = $avatar->avatar_id;
            }

            if (count($errors) == 0) {
                $data->save();
                return redirect('/profile/dashboard');

            } else {
                ProfileController::FlashError($errors);
                return back()->withInput($request->except('password'));
            }

        }


    }

    public static function convertFromUser($text)
    {
        $pieces = explode(",", $text);
        $pieces = array_map('trim', $pieces);
        return implode(', ', $pieces);
    }

    public function createAvatar(Request $request)
    {
        $image = $request->file('avatar');
        $extension = $image->getClientOriginalExtension();
        $user = Auth::User();
        $avatar = Avatar::create([
            'mime' => $image->getClientMimeType(),
            'original_filename' => $image->getClientOriginalName(),
            'filename' => $image->getFilename() . '.' . $extension,
            'user_id' => $user->user_id
        ]);

        Storage::disk('local')->put('avatars/' . $user->user_id . '/' . $image->getFilename() . '.' . $extension, File::get($image));

        return $avatar;
    }

    public static function getBase64($id)
    {

        $user = User::where('user_id', '=', $id)->first();
        $avatar_id = 0;
        if ($user->type == 'visitor') {
            $visitor = Visitor::where('user_id', '=', $user->user_id)->first();
            $avatar_id = $visitor->avatar_id;
        }

        if ($user->type == 'provider') {
            $provider = Provider::where('user_id', '=', $user->user_id)->first();
            $avatar_id = $provider->avatar_id;
        }

        if ($avatar_id != 0) {
            $entry = Avatar::where('avatar_id', '=', $avatar_id)->first();
            $file = Storage::disk('local')->get('avatars/' . $user->user_id . '/' . $entry->filename);
            return base64_encode($file);
        }

        return null;


    }

    public static function getMime($id)
    {
        $user = User::where('user_id', $id)->first();

        if ($user->type == 'visitor') {

            $visitor = Visitor::where('user_id', '=', $user->user_id)->first();

            if ($visitor->avatar_id != 0) {

                $entry = Avatar::where('avatar_id', '=', $visitor->avatar_id)->first();

                return $entry->mime;
            }
        }

        if ($user->type == 'provider') {

            $provider = Provider::where('user_id', '=', $user->user_id)->first();

            if ($provider->avatar_id != 0) {

                $entry = Avatar::where('avatar_id', '=', $provider->avatar_id)->first();

                return $entry->mime;
            }
        }

        return null;


    }

    private function getManFields($type)
    {
        if ($type == 'visitor') {
            return $this->visitorManFields;
        } else {//provider
            return $this->providerManFields;
        }
    }

    public static function getAvatarSource($id)
    {
        $source = "data:" . ProfileController::getMime($id) . ";base64," . ProfileController::getBase64($id);
        return json_encode($source);
    }

    public static function inDateFormat($date)
    {
        $string = trim($date);
        return (ctype_digit(substr($string, 0, 2)) &&
            $date[2] = '-' &&
                ctype_digit(substr($string, 3, 2)) &&
                $date[5] = '-' &&
                    ctype_digit(substr($string, 6, 4)) &&
                    strlen($string) == 10);

    }

    public static function getAnAvatar($id)
    {
        return ProfileController::getAvatarSource($id);
    }

    static public function getVisitorId($user_id)
    {
        return Visitor::where('user_id', '=', $user_id)->value('visitor_id');
    }

    static public function getUser($user_id)
    {
        return User::where('user_id', '=', $user_id)->first();
    }

    static public function getProvider($user_id)
    {
        return Provider::where('user_id', '=', $user_id)->first();
    }

    static public function getVisitor($user_id)
    {
        return Visitor::where('user_id', '=', $user_id)->first();
    }

    static public function getProviderById($provider_id)
    {
        return Provider::where('provider_id', '=', $provider_id)->first();
    }

    static public function legibleParse($array)
    {

        $string = '';
        $i = 0;
        if (count($array) > 0) {
            $string = str_replace('_', ' ', $array[$i]);
        }
        for ($i = 1; $i < count($array) - 1; $i++) {
            $string .= (", " . str_replace('_', ' ', $array[$i]));
        }
        if (count($array) > 1) {
            $string .= (' and ' . str_replace('_', ' ', $array[$i]));
        }
        return $string;

    }

    static public function flashError($errors)
    {

        if (count($errors) == 1) {
            $errorString = "<h3>Error</h3><br>";
        } else {
            $errorString = "<h3>Errors</h3><br>";
        }

        $errorString .= $errors[0];
        for ($i = 1; $i < count($errors); $i++) {
            $errorString .= "<br><br>" . $errors[$i];
        }

        Flash::Message($errorString, 'danger')->important();

    }

    static public function parseDateString($date)
    {
        return Carbon::parse($date)->format('j M Y');

    }
}