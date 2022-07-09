<?php

namespace RSolution\RCms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ServicesApi
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
        if (Auth::check()){
            return $next($request);
        }
        abort(403);
    }
}
