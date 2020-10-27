<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CommitteeAuthenticate
{
    public function handle($request, Closure $next)
    {
        // Perform action
        if(!Auth::guard('committee')->check()) {
        	//SAAJ-0311_ログイン => 委員会ログイン処理
        	config(['session.lifetime' => 60]);
            return redirect()->route('front-committee-login');
        }
        return $next($request);
    }
}