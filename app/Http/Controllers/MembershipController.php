<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Visitor;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;


class MembershipController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('not_admin');
        $this->middleware('isVisitor');
    }

    public function show()
    {

        $user = Auth::user();

        $visitor = Visitor::where('user_id',$user->user_id)->first();

        return view('profile.membership',['title' => 'Membership | Dashboard - MyAncestralScotland', 'visitor'=>$visitor]);
    }

    public function upgrade(){
        $user = Auth::user();
        $visitor = Visitor::where('user_id',$user->user_id)->first();

        if($visitor->member == 1){
            return redirect('/profile/membership/');
        }
        // This is where we make the payment

        // if payment is successful

        $visitor->member = 1;
        $visitor->save();

        Mail::send('emails.member', [], function($message) use ($user) {
            $message->to($user['email'])->subject('You are now a member!');
        });

        Flash::message('Congratulations! You are now a member. Enjoy!','success')->important();

        return redirect('/profile/membership/');

    }

}