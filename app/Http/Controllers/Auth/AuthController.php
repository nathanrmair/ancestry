<?php

namespace App\Http\Controllers\Auth;

use App\Newsletter;
use App\User;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use App\Provider;
use App\Visitor;
use Illuminate\Support\Facades\Validator;
use App\Credits;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
// For the login override
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function logout(Request $request)
    {
        Auth::guard($this->getGuard())->logout();
        $request->session()->flush();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /*
     * Overriding the login method to check for verified emails
     */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        // Checking for verified emails
        $credentials['confirmed'] = 1;

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /*
     * Overriding the postResgister method to avoid logging in after registration( default for laravel)
     */

    public function register(Request $request){
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        if($request->has('news')){

            $subscriber = Newsletter::where('email',$request->email)->first();
            if($subscriber){
                if($subscriber->subscribed == 'no'){
                    $subscriber->subscribed = 'yes';
                    $subscriber->save();
                }
            }else {

                Newsletter::create([
                    'email' => $request->email,
                    'subscribed' => 'yes',
                ]);
            }
        }

        Flash::message('Thanks for signing up! Please check your email.','success')->important();

        return redirect($this->redirectPath());
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users|unique:pending_providers',
            'password' => 'required|min:6|confirmed|max:30',
            'password_confirmation' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(30);
        
        $user =  User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'type' => 'visitor',
            'confirmation_code' => $confirmation_code,
        ]);

        Mail::send('auth.emails.verify', ['confirmation_code' => $confirmation_code] , function($message) use ($user) {
            $message->to($user['email'])->subject('Verify your email address');
        });

        return $user;
    }

    public function confirm(Request $request, $confirmation_code)
    {
        if( ! $confirmation_code)
        {
            abort(404);
        }

//      ---------Limiting visitors-----
        if(Visitor::count()>=100){
            return redirect('limited_users');
        }
//      -------------------------------

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if (!$user)
        {
            abort(404);
        }

        if($user['type'] == 'provider'){
            $provider = Provider::create([
                'user_id' => $user['user_id'],
            ]);
        } else {
            $visitor = Visitor::create([
                'user_id' => $user['user_id'],
                'ip' => $request->getClientIp()
            ]);
        }
        
        $credit = Credits::create([
            'user_id' => $user['user_id'],
        ]);

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        Flash::message('You have successfully verified your account. Please log in with your details.','success')->important();
        
        return redirect('login');
    }

    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
            ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('auth.login', ['title' => 'Login - MyAncestralScotland']);
    }

    public function showRegistrationForm()
    {
        //      ---------Limiting visitors-----
        if(Visitor::count()>=100){
            return redirect('limited_users');
        }
//---------------------------------------------

        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register' , ['title' => 'Register - MyAncestralScotland']);
    }

    // returning the view showed to the users who want to register after reaching 100
    public function limitedUsers(){
        return view('auth.limited' , ['title' =>  'Sorry - MyAncestralScotland']);
    }

}
