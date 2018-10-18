<?php
namespace App\Http\Controllers;

use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use App\Pending_provider;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProvidersRegController extends Controller
{
    public function __construct()
    {
        $this->middleware('logged_out');
    }

    public function show()
    {
        return view('auth.provider_reg');
    }

    public function postSendforapproval(Request $request)
    {
       return $this->send($request);
    }

    public function send(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        Flash::message('Thanks for applying! We will be in touch soon!','success')->important();

        return redirect('/');
    }

    protected function create(array $data)
    {

        $provider = Pending_provider::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'type' => $data['type'],
            'name' => $data['name'],
            'description' => $data['description'],
            'street_name' => $data['street_name'],
            'town' => $data['town'],
            'county' => $data['county'],
            'historic_county' => $data['historic_county'],
            'region' => $data['region'],
            'postcode' => $data['postcode'],
        ]);


        Mail::send('auth.emails.thanks', [], function($message) use ($provider) {
            $message->to($provider['email'])->subject('Thank you for contacting us');
        });

        return $provider;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users|unique:pending_providers',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'postcode' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);
    }
}