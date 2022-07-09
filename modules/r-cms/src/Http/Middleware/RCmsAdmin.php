<?php

namespace RSolution\RCms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\UserRepository;

class RCmsAdmin
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
        if (Auth::user()->role == UserRepository::ROLE_ADMIN)
            return $next($request);
        else
            return redirect()->back();
    }
}
