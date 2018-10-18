<?php

namespace App\Http\Middleware;

use Closure;
use App\Visitor;
use Illuminate\Support\Facades\Auth;

class Member
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if(Auth::User()->type == 'visitor'){
            $visitor = Visitor::where('user_id',Auth::User()->user_id)->first();
            if($visitor->member == 1) {
                return $next($request);
            }
        }else if(Auth::User()->type == 'provider'){
            return $next($request);
        }
        return abort(403);
    }
}
