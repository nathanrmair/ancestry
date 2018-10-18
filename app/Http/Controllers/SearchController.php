<?php

namespace App\Http\Controllers;

use App\Conversations;
use App\Provider;
use App\SearchQueries;
use App\Visitor;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Errors;
use Psy\Exception\ErrorException;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function show()
    {
        return view('providersearch', ['title' => 'Search Providers | Dashboard - MyAncestralScotland']);
    }

    public function search(Request $request)
    {
        if(!$request->ajax()){
            return abort(403);
        }

        $query = $request->input('query');
        $this->updateSearchQueriesTable($query);
        if($query === '*'){
            $providers = Provider::searchByQuery(array(
                'match_all' => []
            ),null,null,500,null,null);
        } else {
            $providers = Provider::searchByQuery(array(
                'multi_match' => [
                    'query' => $query,
                    'fields' => ["name^5", "keywords", "type^2"],
                    'slop' => 50
                ]
            ),null,null,500,null,null);
        }

        foreach ($providers as $provider) {
            $provider->user_id = Hashids::encode($provider->user_id);
        }
        return $providers;
    }

    public function searchMap(Request $request)
    {
        if(!$request->ajax()){
            return abort(403);
        }
        $query = Input::get('query');
        $providers = Provider::searchByQuery(array(
            'multi_match' => [
                'query' => $query,
                'fields' => ['region'],

            ]
        ));
        foreach ($providers as $provider) {
            $provider->user_id = Hashids::encode($provider->user_id);
        }

        return $providers;
    }


    public static function findLatest(){
        $provider = null;
        try{
        $provider = Provider::searchByQuery(array(
                'match_all' => []
        ),null,null,1,null,array(
            'created_at' => [
                'order' => 'desc'
        ]
        ));}
        catch(\Exception $e){
        }

        if($provider!=null) {
            return $provider;
        }

        return null;


    }

    public static function findMostPopular(){

        $provider_user_id = DB::table('conversations')
            ->select(DB::raw('count(*) as conversation_count , provider_id'))
            ->groupBy('provider_id')
            ->orderBy('conversation_count','desc')
            ->take(1)
            ->get();

        if($provider_user_id) {
            return Provider::where('user_id', $provider_user_id[0]->provider_id)->first();
        }

        return null;

    }


    public function isLogged(Request $request){
        if(!$request->ajax()){
            return abort(403);
        }
        if (Auth::check()) {
            if (Auth::user()->type === 'visitor') {
                $visitor = Visitor::where('user_id', Auth::user()->user_id)->first();
                if ($visitor->member == 0) {
                    return array('success' => true, 'errors' => 2000);
                }
                return array('success' => true);
            }
        }
        return array('success' => false);
    }

    private function updateSearchQueriesTable($query){
        $query = strtolower(trim($query));
        $queries = SearchQueries::where('query', $query)->get();
        if(count($queries)) {
            foreach ($queries as $q) {
                $q->hits = $q->hits + 1;
                $q->save();
            }
        }else{
            $newQuery = new SearchQueries();
            $newQuery->query = $query;
            $newQuery->hits = 1;
            $newQuery->save();
        }
    }
}
