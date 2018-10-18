<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Laravel\LavachartsServiceProvider;
use App\Provider;
use App\Messages;
use App\Conversations;
use App\OfferedSearches;
use CpChart\Factory\Factory;
use Exception;
use Carbon\Carbon;
use App\ProviderMonthlyReport;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use App\Report;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProviderReportsController extends Controller
{
    static function generateReports($time = null)
    {
        //monthly report
        if (!isset($time)) {
            $time = Carbon::now('Europe/London');
        }
        $end = Carbon::parse($time)->endOfDay();
        $start = Carbon::parse(Carbon::parse($end)->subMonth()->addSecond());

        $providers = Provider::get();
        for ($i = 0; $i < count($providers); $i++) {

            $report = new ProviderMonthlyReport();
            $r = new Report();
            $provider = Provider::where('user_id', $providers[$i]->user_id)->first();

            $r->user_id = $provider->user_id;
            $r->type = 'month';
            $report->provider_id = $provider->provider_id;

            //$messages = Messages::where('provider_id', $provider->provider_id)->get();

            if (ProviderMonthlyReport::where('provider_id', $provider->provider_id)->count()>0) {
                $first = false;
            } else {
                $report->start_date = Carbon::parse($provider->created_at);
                $first = true;
                $report->report_index = 0;
            }


            $report->end_date = $end;
            $conversation_ids = DB::table('conversations')->where('provider_id', $provider->provider_id)->select('conversation_id')->get();

            if ($first) {
                //first report of this type
                $report->page_visits = $provider->visits;//checked

                //provider stats

                //message stats
                $report->messages_unread = Messages::where('provider_id', $provider->provider_id)->where('read', 'no')->count();
                $report->new_conversations = Conversations::where('provider_id', $provider->provider_id)->count();

//          
                $offered_searches_ids = DB::table('offered_searches')->whereIn('conversation_id', $conversation_ids)->select('offered_search_id')->get();

                //$report->searches_offered =;
            } else {
                $report->report_index = (ProviderMonthlyReport::where('provider_id', $provider->provider_id)->select('report_index')->max('report_index')) + 1;
                $lastMonth = ProviderMonthlyReport::where('report_index', ($report->report_index - 1))->first();
                $report->start_date = Carbon::parse($lastMonth->end_date)->addSecond();

                $report->page_visits = ($provider->visits - $lastMonth->total_page_visits);//change to total
                $report->messages_unread = Messages::where('provider_id', $provider->provider_id)->where('created_at', '>', Carbon::parse($lastMonth->end_date))->where('read', 'no')->count();
                $report->new_conversations = Conversations::where('provider_id', $provider->provider_id)->where('date_started', '>', Carbon::parse($lastMonth->end_date))->count();


                $offered_searches_ids = DB::table('offered_searches')->whereIn('conversation_id', $conversation_ids)->where('updated_at', '>', Carbon::parse($lastMonth->end_date))->select('offered_search_id')->get();


            }
            //searches
            $report->searches_offered = OfferedSearches::whereIn('offered_search_id', $offered_searches_ids)->where('status', 'pending')->count();
            $report->searches_accepted = OfferedSearches::whereIn('offered_search_id', $offered_searches_ids)->where('status', 'accepted')->count();
            $report->searches_completed = OfferedSearches::whereIn('offered_search_id', $offered_searches_ids)->where('status', 'completed')->count();

            //totals
            $stats = ['total_page_visits' => $provider->visits,
                'total_messages' => Messages::where('provider_id', $provider->provider_id)->count(),
                'total_messages_unread' => Messages::where('provider_id', $provider->provider_id)->where('read', 'no')->count(),
                'total_conversations' => Conversations::where('provider_id', $provider->provider_id)->count(),
                'total_searches_completed' => OfferedSearches::whereIn('conversation_id', $conversation_ids)->count()];

            foreach ($stats as $key => $value) {
                $report->$key = $value;
            }

            $r->title = "My Ancestral Scotland Progress Report (" . Carbon::parse($report->start_date)->format('j M') . " - " .
                Carbon::parse($report->end_date)->format('j M Y') . ")";
            $r->save();
            $report->report_id = $r->report_id;
            $report->save();
        }

    }

    static function getData($user_id)
    {
        $providerId = DB::table('providers')->where('user_id', $user_id)->value('provider_id');
        //order by date
        return ProviderMonthlyReport::where('provider_id', $providerId)->first();//note: this is not correct, it is merely for test purposes
    }

//    static function getMonthlyReport($report_id)
//    {
//        return ProviderMonthlyReport::find(/*Hashids::decode($report_id)*/
//            $report_id);
//    }

    static function getView($report_id)
    {
        $report = Report::find(Hashids::decode($report_id)[0]);
        if ($report->type == 'month') {
            return view('reports.provider.providerReport', [
                'report' => $report,
                'report_content' => ProviderMonthlyReport::where('report_id', $report->report_id)->first()]);
        }
        return abort(404);
    }

    public static function getPDF($report_id)
    {

        $user = Auth::User();
        $report = Report::find(Hashids::decode($report_id)[0]);

        if ($user->type != 'admin' && $user->user_id != $report->user_id) {
            return abort(403);
        }
        if ($report->type == 'month') {
            $pdf = \PDF::loadView('reports.provider.providerReport', ['report' => $report, 'report_content' => ProviderMonthlyReport::where('report_id', $report->report_id)->first()]);
        }

        if (isset($pdf)) {
            return $pdf->download($report->title . '.pdf');
        }

        return abort(404);
    }

    public static function getStats($user_id = null)
    {

        $user = Auth::User();

        if ($user->type == 'admin') {
            $user_id = User::find($user_id)->value('user_id');
        } else {
            $user_id = $user->user_id;
        }

        $provider = Provider::where('user_id', $user_id)->first();

        $conversation_ids = DB::table('conversations')->where('provider_id', $provider->provider_id)->select('conversation_id')->get();
        return ['total_page_visits' => $provider->visits,
            'total_messages' => Messages::where('provider_id', $provider->provider_id)->count(),
            'total_messages_unread' => Messages::where('provider_id', $provider->provider_id)->where('read', 'no')->count(),
            'total_conversations' => Conversations::where('provider_id', $provider->provider_id)->count(),
            'total_searches_completed' => OfferedSearches::whereIn('conversation_id', $conversation_ids)->count()

        ];

    }

}
