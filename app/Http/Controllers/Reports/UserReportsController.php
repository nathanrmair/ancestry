<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Report;
use Vinkla\Hashids\Facades\Hashids;
use Laracasts\Flash\Flash;
use App\Provider;
use App\User;


class UserReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getReports()
    {
        $user = Auth::User();
        
        if ($user->type == 'visitor') {
//            Flash::message('Check back soon for reports', 'info')->important();
//            return redirect('profile/dashboard');
            return abort(404);
        }

        return view('reports.userReports', ['encoded_user_id'=>Hashids::encode($user->user_id),'reports' => UserReportsController::getUserReports($user->user_id)]);
    }

    function getReport($report_id)
    {
        $user = Auth::User();
        $report = Report::find(Hashids::decode($report_id)[0]);

        if ($user->type != 'admin' && $user->user_id != $report->user_id) {

            return abort(403);

        }

        if (User::find($report->user_id)->value('type') == 'provider') {

            return ProviderReportsController::getView($report_id);

        }

        return abort(404);
    }

    function getReportPDF($report_id)
    {
        $user = Auth::User();
        $report = Report::find(Hashids::decode($report_id)[0]);

        if ($user->type != 'admin' && $user->user_id != $report->user_id) {
            return abort(403);
        }

        switch (User::find($report->user_id)->value('type')) {
            case 'provider':
                return ProviderReportsController::getPDF($report_id);
            default:
                return abort(404);
        }

    }
    
    function getStats(){
        $user = Auth::User();
        $user_id = $user->user_id;
        
        switch (User::find($user_id)->value('type')){
            case 'provider':
                return view('reports.provider.providerStats',['stats'=>ProviderReportsController::getStats($user_id),'name'=>Provider::where('user_id',$user_id)->value('name')]);
            default:
                return abort(404);
        }
        
    }

    static function getUserReports($user_id)
    {
        $reportLinks = null;
        return Report::where('user_id', $user_id)->orderBy('created_at')->get();
    }
}
