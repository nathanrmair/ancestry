<?php
namespace App\Http\Controllers;

use App\Jobs\ReIndexProviders;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use App\Pending_provider;
use App\Provider;
use App\User;
use App\Credits;
use Illuminate\Support\Facades\Log;

class ApproveController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function show()
    {

        $pending = Pending_provider::all();
        return view('admin.approveProviders',['pending'=>$pending]);
    }

    public function approve($id)
    {
       $pending_provider = Pending_provider::where('id','=',$id)->first();

        $user =  User::create([
            'email' => $pending_provider->email,
            'password' => $pending_provider->password,
            'type' => 'provider',
            'confirmation_code' => null,
        ]);

        $user->confirmed = 1;
        $user->save();

        $credit = Credits::create([
            'user_id' => $user['user_id'],
        ]);

        $provider = Provider::create([
            'user_id' => $user->user_id,
            'name' => $pending_provider->name,
            'street_name' => $pending_provider->street_name,
            'town' => $pending_provider->town,
            'county' => $pending_provider->county,
            'region' => $pending_provider->region,
            'postcode' => $pending_provider->postcode,
            'description' => $pending_provider->description,
            'historic_county' => $pending_provider->historic_county,
            'type' => $pending_provider->type,
        ]);



        $pending_provider->delete();

        Mail::send('emails.approved', [], function($message) use ($user) {
            $message->to($user['email'])->subject('Your account is now approved!');
        });

        Flash::message('Account with name '.$provider->name.' is now approved!','success')->important();

        $this->dispatch(new ReIndexProviders());
        return redirect('admin/approveProviders');
    }

    public function decline($id){
        $pending_provider = Pending_provider::where('id','=',$id)->first();

        $email = $pending_provider->email;
        $name = $pending_provider->name;

        $pending_provider->delete();

        Mail::send('emails.declined', [], function($message) use ($email) {
            $message->to($email)->subject('Your application was declined.');
        });

        Flash::message('Account with name '.$name.' was declined!','success')->important();

        return redirect('admin/approveProviders');
    }


}