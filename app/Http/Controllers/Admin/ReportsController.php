<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\EmailProvider;
use App\Payment;
use App\SearchQueries;
use App\User;
use App\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Provider;
use App\Http\Controllers\Reports\UserReportsController;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Reports\ProviderReportsController;

define('TIMEZONE', 'Europe/London');

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function showReports()
    {
        $readStatsHolder = [];
        $read = DB::table('messages')->where('read', 'yes')->count();
        $unread = DB::table('messages')->where('read', 'no')->count();
        $total = DB::table('messages')->count();

        $readStatsHolder = array_add($readStatsHolder, 'read', $read);
        $readStatsHolder = array_add($readStatsHolder, 'unread', $unread);
        $readStatsHolder = array_add($readStatsHolder, 'total', $total);

        $jsonArray = json_encode($readStatsHolder);

        $providers = DB::table('providers')->get();

        $visitors = DB::table('visitors')->get();

        $messagesOver3Months = DB::table('messages')->where('read', 'no')->whereBetween('time', [Carbon::now(TIMEZONE)->subYears(2), Carbon::now(TIMEZONE)->subMonth(3)])->get();

        $messagesOver1Month = DB::table('messages')->where('read', 'no')->whereBetween('time', [Carbon::now(TIMEZONE)->subMonth(1), Carbon::now(TIMEZONE)])->get();

        $unansweredThreeMonths = DB::table('messages')->where('read', 'no')->whereBetween('time', [Carbon::now(TIMEZONE)->subYears(2), Carbon::now(TIMEZONE)->subMonth(3)])->count();

        $unansweredOneMonth = DB::table('messages')->where('read', 'no')->whereBetween('time', [Carbon::now(TIMEZONE)->subMonth(1), Carbon::now(TIMEZONE)])->count();

        $totalUsers = DB::table('users')->count();

        $totalProviders = DB::table('providers')->count();

        $totalVisitors = DB::table('visitors')->count();

        $countIncompleteProfiles = DB::table('visitors')->where('forename', 'null')->orWhere('surname', 'null')->orWhere('dob', 'null')
            ->orWhere('origin', 'null')->orWhere('description', 'null')->orWhere('avatar_id', 'null')->count();


        return view('reports.reportsOverview')->with('jsonArray', $jsonArray)->with('providers', $providers)->with('messagesOver3Months', $messagesOver3Months)
            ->with('messagesOver1Month', $messagesOver1Month)->with('visitors', $visitors)->with('unansweredOneMonth', $unansweredOneMonth)
            ->with('unansweredThreeMonths', $unansweredThreeMonths)->with('read', $read)->with('unread', $unread)->with('total', $total)->with('totalUsers', $totalUsers)
            ->with('totalProviders', $totalProviders)->with('totalVisitors', $totalVisitors)->with('countIncompleteProfiles', $countIncompleteProfiles);
    }

    public function getIndividualMessageStats($providerName)
    {
        $providerId = DB::table('providers')->where('name', $providerName)->value('provider_id');

        $individualReadStatsHolder = [];

        $read = DB::table('messages')->where('read', 'yes')->where('provider_id', $providerId)->count();

        $unread = DB::table('messages')->where('read', 'no')->where('provider_id', $providerId)->count();

        $total = DB::table('messages')->where('provider_id', $providerId)->where('provider_id', $providerId)->count();

        $individualReadStatsHolder = array_add($individualReadStatsHolder, 'read', $read);
        $individualReadStatsHolder = array_add($individualReadStatsHolder, 'unread', $unread);
        $individualReadStatsHolder = array_add($individualReadStatsHolder, 'total', $total);
        $individualReadStatsHolder = array_add($individualReadStatsHolder, 'museumSelected', 'true');

        $individualJsonArray = json_encode($individualReadStatsHolder);

        return view('reports.providerReportsOverview')->with('individualJsonArray', $individualJsonArray)->with('providerName', $providerName);

    }

    public function providerSummary($providerId)
    {
        $providerDetails = DB::table('providers')->where('user_id', $providerId)->first();
        $provider_user_id = $providerDetails->user_id;

        $read = DB::table('messages')->where('read', 'yes')->where('provider_id', $provider_user_id)->count();

        $unread = DB::table('messages')->where('read', 'no')->where('provider_id', $provider_user_id)->count();

        $total = DB::table('messages')->where('provider_id', $provider_user_id)->count();

        $oldestDate = DB::table('messages')->where('provider_id', $provider_user_id)->value('time');

        $unansweredMessages = DB::table('messages')->where('provider_id', $provider_user_id)->where('read', 'no')->get();

        $unansweredThreeMonths = DB::table('messages')->where('provider_id', $provider_user_id)->where('read', 'no')->whereBetween('time', [Carbon::now(TIMEZONE)->subYears(2), Carbon::now(TIMEZONE)->subMonth(3)])->count();

        $unansweredOneMonth = DB::table('messages')->where('provider_id', $provider_user_id)->where('read', 'no')->whereBetween('time', [Carbon::now(TIMEZONE)->subMonth(1), Carbon::now(TIMEZONE)])->count();

        $reviews = DB::table('reviews')->where('provider_id', $provider_user_id)->get();

        $messageStatsHolder = array(
            "read" => $read,
            "unread" => $unread,
            "total" => $total,
            "unansweredOneMonth" => $unansweredOneMonth,
            "unansweredThreeMonths" => $unansweredThreeMonths
        );


        $jsonArrayProvider = json_encode($messageStatsHolder);

        return view('reports.reportsProviderSummary', [
            'jsonArrayProvider' => $jsonArrayProvider,
            'providerDetails' => $providerDetails,
            'read' => $read,
            'unread' => $unread,
            'total' => $total,
            'oldestDate' => $oldestDate,
            'unansweredMessages' => $unansweredMessages,
            'unansweredThreeMonths' => $unansweredThreeMonths,
            'unansweredOneMonth' => $unansweredOneMonth,
            'reviews' => $reviews,
        ]);
    }

    public function visitorSummary($user_id)
    {
        $fieldsMissing = [];
        $user = User::where('user_id', $user_id)->first();
        $percentComplete = 100;
        $visitor = DB::table('visitors')->where('user_id', $user_id)->first();
        if ($visitor) {
            $users = DB::table('users')->get();

            $messagesSentCount = DB::table('messages')->where('visitor_id', $user_id)->where('who', 'visitor')->count();
            $messagesReceivedCount = DB::table('messages')->where('visitor_id', $user_id)->where('who', 'provider')->count();
            $numberOfAncestors = DB::table('ancestors')->where('visitor_id', $user_id)->count();
            $ancestorDetails = DB::table('ancestors')->where('visitor_id', $user_id)->get();

            $nullFieldForename = DB::table('visitors')->where('visitor_id', $user_id)->select('forename')->get();


            $nullFieldDob = DB::table('visitors')->where('visitor_id', $user_id)->select('dob')->get();

            $nullFieldSurname = DB::table('visitors')->where('visitor_id', $user_id)->select('surname')->get();

            $nullFieldDescription = DB::table('visitors')->where('visitor_id', $user_id)->select('description')->get();

            $topUps = Payment::where('user_id', $visitor->user_id)->get();
//        doesnt pick up on other missind details such as missing forename


            if (empty($nullFieldForename)) {
                $percentComplete -= 20;

                array_push($fieldsMissing, 'Forename');

            }
            if (empty($nullFieldSurname)) {
                $percentComplete -= 20;

                array_push($fieldsMissing, 'Surname');


            }
            if (empty($nullFieldDob)) {
                $percentComplete -= 20;

                array_push($fieldsMissing, 'Date Of Birth');
            }

            if (empty($nullFieldDescription)) {
                $percentComplete -= 20;

                array_push($fieldsMissing, 'Description');
            }

            if ($fieldsMissing && $percentComplete == 100) {
                $percentComplete = 0;
            }

//

            return view('reports.visitorSummary', [
                'visitor' => $visitor,
                'users' => $users,
                'messagesSentCount' => $messagesSentCount,
                'messagesReceivedCount' => $messagesReceivedCount,
                'numberOfAncestors' => $numberOfAncestors,
                'percentComplete' => $percentComplete,
                'nullFieldDescription' => $nullFieldDescription,
                'ancestorDetails' => $ancestorDetails,
                'fieldsMissing' => $fieldsMissing,
                'topUps' => $topUps
            ]);
        }

        return view('reports.userNotConfirmed', [
            'user' => $user,
        ]);

    }

public function queriesReport(){
    $queries = DB::table('search_queries')->select('query','hits')->orderBy('hits', 'DESC')->get();
    return view('admin.searchQueriesReport', ['queries' => $queries]);
}

    public function getProviderReports()
    {
        return view('reports.admin.adminOverview', ['providers' => Provider::orderBy('name')->get()]);
    }

    function getProviderReport($user_id)
    {
        return view('reports.admin.adminProviderReports', ['encoded_user_id' => $user_id, 'admin' => true, 'reports' => UserReportsController::getUserReports(Hashids::decode($user_id)[0])]);
    }

    function getStats($user_id){
      
        $user_id = Hashids::decode($user_id)[0];
        
        switch (User::find($user_id)->value('type')){
            case 'provider':
                return view('reports.admin.adminProvidersStats',['stats'=>ProviderReportsController::getStats($user_id),'name'=>Provider::where('user_id',$user_id)->value('name')]);
            default:
                return abort(404);
        }



    }

}
