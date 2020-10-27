<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAuthenticate
{
    public function handle($request, Closure $next)
    {
        // Perform action
        if(!Auth::guard('admin')->check()) {
            return redirect()->route('admin-login');
        } else {
            //SAAJ-0311_ログイン => 管理者ログイン処理
            config(['session.lifetime' => 60]);
        }
        
        return $next($request);
    }
}