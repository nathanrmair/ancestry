<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\EmailProvider;
use App\Jobs\EmailWithMultipleRecipients;
use App\Newsletter;
use App\Provider;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{

    public function __construct(){
        $this->middleware('admin');
    }

    public function getEmailAllProviders(){
        return view('admin.emailing', ['url' => url('/admin/email-all-providers/send'), 'subtitle' => 'Email all the providers on the website']);
    }

    public function getEmailAllVisitors(){
        return view('admin.emailing', ['url' => url('/admin/email-all-visitors/send'), 'subtitle' => 'Email all the visitors on the website']);
    }

    public function emailAllProviders(Request $request){
        $emails = $this->getAllProvidersEmails();
        $message = $request->input('message');
        $subject = $request->input('subject');
        $this->dispatch(new EmailWithMultipleRecipients($emails,$message,$subject));

        return redirect('/admin/adminMain');
    }

    public function emailAllVisitors(Request $request){
        $emails = $this->getAllVisitorsEmails();
        $message = $request->input('message');
        $subject = $request->input('subject');
        $this->dispatch(new EmailWithMultipleRecipients($emails,$message,$subject));

        return redirect('/admin/adminMain');
    }

    public function getSendNewsletter(Request $request){
       return view('admin.emailing', ['url' => url('/admin/send-newsletter/send'), 'subtitle' => 'Send newsletter to all subscribed users']);
    }

    public function sendNewsletter(Request $request){
        $emails = $this->getAllNewsletterEmails();
        $message = $request->input('message');
        $subject = $request->input('subject');
        $this->dispatch(new EmailWithMultipleRecipients($emails,$message,$subject));
        return redirect('/admin/adminMain');
    }


    public function getSendEmailToProviderView($userId)
    {
        return view('admin.email_provider', ['url' => 'admin/emailProvider/send', 'subtitle' => 'Email this provider', 'user_id' => $userId]);
    }

    public function sendEmailToProvider(Request $request)
    {
        $user_id = $request->input('user_id');
        $message = $request->input('message');
        $subject = $request->input('subject');
        $this->dispatch(new EmailProvider(User::findOrFail($user_id), $message, $subject));
        return redirect('/admin/adminMain');
    }

    private function getAllNewsletterEmails(){
        return DB::table('newsletter')->select('email')->where('subscribed','yes')->get();
    }
    private function getAllProvidersEmails(){
        return DB::table('users')->select('email')->where('type','provider')->get();
    }

    private function getAllVisitorsEmails(){
        return DB::table('users')->select('email')->where('type','visitor')->get();
    }

    public function unsubscribeAll(){
        $newsletters = Newsletter::all();

        foreach($newsletters as $newsletter){
            Log::info($newsletter->email);
            $newsletter->subscribed = 'no';
            $newsletter->save();
        }

        return  'success';
    }

    public function subscribeAll(){
        $newsletters = Newsletter::all();

        foreach($newsletters as $newsletter){
            Log::info($newsletter->email);
            $newsletter->subscribed = 'yes';
            $newsletter->save();
        }

        return  'success';
    }

}
