<?php

namespace App\Http\Middleware;

use App\Visitor;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use App\Http\Errors;

class IncompleteProfileMiddleware
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
        $user = Auth::User();
        if($user->type === 'visitor'){
            $visitor = Visitor::where('user_id', $user->user_id)->first();
            if($visitor->forename == null || $visitor->surname == null){
                if($request->ajax()){
                    return ['errors' => 3000];
                }
                Flash::message('You should complete your profile before messaging a provider or booking a search')->important();
                return redirect('/profile/edit');
            }
        }
        return $next($request);
    }
}
