<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminCheckMiddleware
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
        if(Auth::check() && Auth::user()->is_admin == true){
            return $next($request);
        }

        abort(403, 'Unauthorized');
        // return redirect()->back()->with('unauthorised', 'You are 
          // unauthorised to access this page');
    }
}
