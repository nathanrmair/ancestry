<?php

use Illuminate\Database\Seeder;
use App\Provider;
use App\Messages;
use App\Conversations;
use Carbon\Carbon;
use App\ProviderMonthlyReport;
use App\Report;
use App\OfferedSearches;
use App\Http\Controllers\Reports\ProviderReportsController;


class ProviderMonthlyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    ProviderReportsController::generateReports();        

//        //monthly report
//
//        $time = Carbon::now('Europe/London');
//        $end = Carbon::parse($time)->endOfDay();
//        $start = Carbon::parse(Carbon::parse($end)->subMonth()->addSecond());
//
//        $providers = Provider::get();
//        for ($i = 0; $i < count($providers); $i++) {
//
//            $report = new ProviderMonthlyReport();
//            $r = new Report();
//            $provider = Provider::where('user_id', $providers[$i]->user_id)->first();
//
//            $r->user_id = $provider->user_id;
//            $r->type = 'month';
//            $report->provider_id = $provider->provider_id;
//
//            $messages = Messages::where('provider_id', $provider->provider_id)->get();
//            //$conversations =;
//
//            if (Carbon::parse($provider->created_at) > $start) {
//                $report->start_date = Carbon::parse($provider->created_at);
//                $first = true;
//                $report->report_index = 0;
//            } else {
//                $report->start_date = $start;
//                if (ProviderMonthlyReport::where('provider_id', $provider->provider_id)->first()) {
//                    $first = false;
//                } else {
//                    //if all goes well, this should never be called
//                    $report->start_date = Carbon::parse($provider->created_at);
//                    $first = true;
//                    $report->report_index = 0;
//                }
//            }
//
//            $report->end_date = $end;
//            $conversation_ids = DB::table('conversations')->where('provider_id', $provider->provider_id)->select('conversation_id')->get();
//
//            if ($first) {
//                //first report of this type
//                $report->page_visits = $provider->visits;//checked
//
//                //provider stats
//
//                //message stats
//                $report->messages_unread = Messages::where('provider_id', $provider->provider_id)->where('read', 'no')->count();
//                $report->new_conversations = Conversations::where('provider_id', $provider->provider_id)->count();
//
////
//                $offered_searches_ids = DB::table('offered_searches')->whereIn('conversation_id', $conversation_ids)->select('offered_search_id')->get();
//
//                //$report->searches_offered =;
//            } else {
//                $report->report_index = (ProviderMonthlyReport::where('provider_id', $provider->provider_id)->max('report_index') + 1);
//                $lastMonth = ProviderMonthlyReport::where('report_index', ($report->report_index - 1))->first();
//
//                $report->page_visits = ($provider->visits - $lastMonth->total_page_visits);//change to total
//                $report->messages_unread = Messages::where('provider_id', $provider->provider_id)->where('created_at', '>', Carbon::parse($lastMonth->end_date))->where('read', 'no')->count();
//                $report->new_conversations = Conversations::where('provider_id', $provider->provider_id)->where('date_started', '>', Carbon::parse($lastMonth->end_date))->count();
//
//
//                $offered_searches_ids = DB::table('offered_searches')->whereIn('conversation_id', $conversation_ids)->where('updated_at', '>', Carbon::parse($lastMonth->end_date))->select('offered_search_id')->get();
//
//
//            }
//            //searches
//            $report->searches_offered = OfferedSearches::whereIn('offered_search_id', $offered_searches_ids)->where('status', 'pending')->count();
//            $report->searches_accepted = OfferedSearches::whereIn('offered_search_id', $offered_searches_ids)->where('status', 'accepted')->count();
//            $report->searches_completed = OfferedSearches::whereIn('offered_search_id', $offered_searches_ids)->where('status', 'completed')->count();
//            //totals
//
//
//            $report->total_page_visits = $provider->visits;
//            $report->total_messages = Messages::where('provider_id', $provider->provider_id)->count();
//            $report->total_messages_unread = Messages::where('provider_id', $provider->provider_id)->where('read', 'no')->count();
//            $report->total_conversations = Conversations::where('provider_id', $provider->provider_id)->count();
//            $report->total_searches_completed = OfferedSearches::whereIn('conversation_id', $conversation_ids)->count();
//
//
//            $r->title = "My Ancestral Scotland Progress Report (" . Carbon::parse($report->start_date)->format('j M') . " - " .
//                Carbon::parse($report->end_date)->format('j M Y') . ")";
//            $r->save();
//            $report->report_id = $r->report_id;
//            $report->save();
//        }
    }
}
