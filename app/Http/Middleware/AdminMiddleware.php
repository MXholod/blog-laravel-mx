<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		//Check if the user authenticated and he is the Administrator
        if(Auth::check() && (Auth::user()->is_admin == 1)){
			return $next($request);
		}	
		abort(404);
    }
}
