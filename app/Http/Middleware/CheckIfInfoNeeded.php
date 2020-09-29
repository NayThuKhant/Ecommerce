<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfInfoNeeded
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
        if ($request->path() == "finishing-up") {
            return $next($request);
        }
        if (Auth::check()) {
            if (Auth::user()->more_info_needed) {
                return redirect('/finishing-up');
            }

        }
        return $next($request);
    }
}
