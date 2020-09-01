<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (Str::startsWith($request->path(), 'api/')){
            if (! $request->expectsJson()) {
                return abort(401);
            }
        }
        if (! $request->expectsJson()) {
            return '/login';
        }
    }
}
