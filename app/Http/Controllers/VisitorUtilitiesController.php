<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\ProvidersGalleryImages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Provider;
use Vinkla\Hashids\Facades\Hashids;

class VisitorUtilitiesController extends Controller
{

    private $defaultSize = 10;

    public static function getImageSourcesForProvider($provider_user_id)
    {
        $images = ProvidersGalleryImages::where('provider_user_id', $provider_user_id)->get();
        $sources = [];
        foreach ($images as $image) {
            array_push($sources, ProvidersImagesController::getImageSrc($image, $provider_user_id));
        }
        return $sources;
    }

    public function providerById(Request $request, $user_id){
        $user_id = Hashids::decode($user_id)[0];
        $provider = Provider::where('user_id', $user_id)->first();

        $this->updateLatestProvidersVisitsInSession($request, $user_id);

        $this->updateDailyVisitsInCache($request, $user_id);

        $sources = $this->getImageSourcesForProvider($provider->user_id);
        return view("providerViews.overviewOfProviders", ['provider_id' => $provider->provider_id, 'images' => $sources]);
    }

    private function updateLatestProvidersVisitsInSession(Request $request, $user_id)
    {
        if (Auth::check() && Auth::User()->type === 'visitor') {
            if (!$request->session()->has('providersVisitedIds')) {
                $request->session()->put('providersVisitedIds', [$user_id]);
            } else {
                $visits = $request->session()->get('providersVisitedIds');
                if (!in_array($user_id, $visits)) {
                    array_push($visits, $user_id);
                }
                $request->session()->put('providersVisitedIds', $visits);
            }
        }
    }

    private function updateDailyVisitsInCache(Request $request, $user_id)
    {
        if (!$request->session()->has('visitsWithTimestamps')) {
            $uniqueVisits = array(['user_id' => $user_id, 'timestamp' => date("Y-m-d", time())]);
            $request->session()->put('visitsWithTimestamps', $uniqueVisits);
            $this->updateProviderVisits($user_id);
        } else {
            $uniqueVisits = $request->session()->get('visitsWithTimestamps');
            $found = false;
            foreach ($uniqueVisits as $uniqueVisit) {
                if (in_array($user_id, $uniqueVisit)) {
                    $found = true;
                    if($uniqueVisit['timestamp'] !== date("Y-m-d", time())){
                       $this->updateProviderVisits($user_id);
                    }
                }
            }
            if (!$found) {
                array_push($uniqueVisits, array('user_id' => $user_id, 'timestamp' => date("Y-m-d", time())));
                $request->session()->put('visitsWithTimestamps', $uniqueVisits);
            }
        }
    }

    private function updateProviderVisits($user_id){
        $provider = Provider::where('user_id', $user_id)->first();
        $provider->visits = $provider->visits + 1;
        $provider->save();
    }

    public function getTotalNumberOfUsers()
    {
        return DB::table('providers')->count('provider_id');
    }
}
