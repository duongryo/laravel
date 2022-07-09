<?php

namespace RSolution\RCms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\UserRepository;

class RCmsUser
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
        if (Auth::user()->status == UserRepository::STATUS_ACTIVE) {
            return $next($request);
        } else {

            return redirect()->route('rcms.block');
        }
    }
}
