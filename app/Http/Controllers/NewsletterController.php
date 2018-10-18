<?php

namespace App\Http\Controllers;

use App\Newsletter;
use Illuminate\Http\Request;

use App\Http\Requests;
use Laracasts\Flash\Flash;

class NewsletterController extends Controller
{

    public function __construct(){

    }

    public function registerNewEmail(Request $request){


        $exists = Newsletter::where('email',$request->input('email'))->first();
        if($exists) {
            if($exists->subscribed == 'yes') {
                Flash::message('This email has been registered already!', 'info')->important();
                return redirect('/');
            }else {
                $exists->subscribed = 'yes';
                $exists->save();
                Flash::message('You have successfully registered to our newsletter with the email ' . $request->input('email'), 'success')->important();
                return redirect('/');
            }
        }else {
            $newsletter = new Newsletter();
            $newsletter->email = $request->input('email');
            $newsletter->subscribed = 'yes';
            $newsletter->save();
            Flash::message('You have successfully registered to our newsletter with the email ' . $request->input('email'), 'success')->important();
            return redirect('/');
        }
    }
}
