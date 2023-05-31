<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;

class IsLogin
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
        if (Auth::check()) {
            if (\auth()->user()->user_type == 'administrator'){
                return redirect('admin/dashboard');
            }
            else{
                return redirect('user/dashboard');
            }
        }
        return $next($request);
    }
}
