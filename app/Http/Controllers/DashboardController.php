<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
use Vinkla\Hashids\Facades\Hashids;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    

    public function dashboardPage()
    {
        $user =  Auth::User();
        return view('profile.dashboard', [
            'title' => ' Overview | Dashboard - MyAncestralScotland',
            'user'=> $user,
            'images' => VisitorUtilitiesController::getImageSourcesForProvider($user->user_id)
        ]);
    }

}
