<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ReIndexProviders;
use App\Provider;
use App\User;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class UsersController extends Controller
{

    public function __construct(){
        $this->middleware('admin');
    }

    //********view redirect functions***************
    public function adminMain()
    {
        return view('adminMain');
    }
    
    public function search()
    {
        return view('admin.dashboard.userSearch');

    }

    public function index()
    {
        $users = DB::table('users')->get();

        return view('admin.dashboard.usersSummary')->with('users', $users);

    }

    public function searchByName(Request $request)
    {
        $userName = strtolower($request->name);
        $providers = Provider::where('name', 'like','%'. $userName . '%')->get();
        $visitors = Visitor::where('surname', 'like','%'. $userName . '%')->get();

        if(isset($visitors)) {
            if(isset($providers)) {
                $users = array_merge($providers->toArray(), $visitors->toArray());
            }else{
                $users = $visitors;
            }
        }else{
            $users = $providers;
        }
        return view('admin.dashboard.userSearch')->with('users', $users);

    }

    public function searchByEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user->type === 'visitor'){
            $type = Visitor::where('user_id', $user->user_id)->get();
        }else{
            $type = Provider::where('user_id', $user->user_id)->get();
        }
        return view('admin.dashboard.userSearch')->with('users', $type);

    }

    public function searchByType(Request $request){
        if($request->get('type') === 'visitor'){
            $user = Visitor::all();
        }else{
            $user = Provider::all();
        }
        return view('admin.dashboard.userSearch')->with('users', $user);
    }

    public function deleteUser(Request $request){
        $user_id = $request->get('user_id');
        $user = User::where('user_id',$user_id)->first();
        if($user->type === 'provider'){
            User::destroy($user_id);
            $this->dispatch(new ReIndexProviders());
        }else {
            User::destroy($user_id);
        }
        return redirect('admin/adminMain');
    }
}
