<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Credits;
use App\Withdrawal;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use App\Payment;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Http\Request;


class CreditsController extends Controller
{

    public function __construct()
    {
        $this->middleware('paid_members_and_providers');
    }
    
    public function show()
    {
        
        $user = Auth::user();
        $credits = Credits::where('user_id','=',$user->user_id)->first();
        if($user->type=="visitor") {
            $payments = Payment::where('user_id', '=', $user->user_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        else{
            $payments = Withdrawal::where('user_id', '=', $user->user_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('profile.credits',['title' => 'Credits | Dashboard - MyAncestralScotland', 'user'=>$user,'credits'=>$credits,'payments'=>$payments]);
    }
    
    public function buyCredits(Request $request)
        {
            $validator = $this->validatorBuy($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }

            $this->updateBuy($request->all());
            
            $this->createPayment($request->all());

            Flash::message('Your payment was successful! Your credits are now updated!','success')->important();

            return redirect('/profile/credits');
        }

    protected function updateBuy(array $data)
    {
        $user = Auth::user();

        $credit = Credits::where('user_id',$user->user_id)->first();

        $credit->credits = $credit->credits + $data['quantity'];
        $credit->save();
        
        $purchasedCredits = $data['quantity'];

        Mail::send('emails.payment', ['credits'=>$purchasedCredits], function($message) use ($user) {
            $message->to($user['email'])->subject('Your recent payment');
        });

        return $credit;
    }

    protected function validatorBuy(array $data)
    {
        return Validator::make($data, [
            'quantity' => 'required|integer|between:5,1000|'
        ]);
    }

    public function createPayment(array $data){

        date_default_timezone_set('Europe/London');

        $payment = Payment::create([
            'credit' => $data['quantity'],
            'user_id' => Auth::user()->user_id,
            'created_at' => date('Y-m-d  H:i:s'),
        ]);
    }

    public function withdrawCredits(Request $request)
    {
        $validator = $this->validatorWithdraw($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->updateWithdrawal($request->all());

        $this->createWithdrawal($request->all());

        Flash::message('Your withdrawal was successful! Your credits are now updated! Your bank account will soon be updated.','success')->important();

        return redirect('/profile/credits');
    }

    protected function updateWithdrawal(array $data)
    {
        $user = Auth::user();

        $credit = Credits::where('user_id',$user->user_id)->first();

        $credit->credits = $credit->credits - $data['quantity'];
        $credit->save();

        $withdrawn = $data['quantity'];

        Mail::send('emails.withdrawal', ['credits'=>$withdrawn], function($message) use ($user) {
            $message->to($user['email'])->subject('Your recent withdrawal');
        });

        return $credit;
    }



    protected function validatorWithdraw(array $data)
    {
        $credits = Credits::where('user_id','=',Auth::user()->user_id)->first();

        return Validator::make($data, [
            'quantity' => 'required|integer|min:10|max:'.$credits->credits
        ]);
    }

    public function createWithdrawal(array $data){

        date_default_timezone_set('Europe/London');

        $withdrawal = Withdrawal::create([
            'credit' => $data['quantity'],
            'user_id' => Auth::user()->user_id,
            'created_at' => date('Y-m-d  H:i:s'),
        ]);
    }

}