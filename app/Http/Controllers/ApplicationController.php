<?php

namespace App\Http\Controllers;

use App\Jobs\LoadCsvData;
use App\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

define('TIMEZONE', 'Europe/London');

class ApplicationController extends Controller
{


    public function getHome(Request $request)
    {
        if (!$request->session()->has('ip')) {
            $request->session()->put('ip', $request->getClientIp());
            $now = Carbon::now(TIMEZONE);
            $request->session()->put('time', $now->timestamp);
        }

        if(Auth::check() && Auth::user()->type==='visitor') {
            $provider_ids = $request->session()->get('providersVisitedIds');
            $providers = array();
            if ($provider_ids) {
                array_slice($provider_ids, -3, 3, true);
                foreach ($provider_ids as $provider_id) {
                    $provider = Provider::where('user_id', $provider_id)->get();

                    if ($provider[0]->avatar_id == 0) {
                        $avatar = url('/') . "/img/avatar/default_provider.png";
                    } else {
                        $avatar = json_decode(ProfileController::getAvatarSource($provider_id));
                    }
                    $provider[0]->avatar = $avatar;
                    array_push($providers, $provider[0]);
                }
            }
        }else{
            $providers = null;
        }
        return view('index', [
            'title' => 'Find your roots and your ancestors in Scotland - MyAncestralScotland',
            'providers' => $providers
        ]);
    }

    public function getCookies()
    {
        return view('cookiePolicy');
    }

    public function getAbout()
    {
        return view('about', ['title' => 'About | MyAncestralScotland']);
    }

    public function loadCsv(){
        $this->dispatch(new LoadCsvData());
    }

    public function getPrivacyPolicy(){
        return view('privacyPolicy');
    }

}
