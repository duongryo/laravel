<?php

namespace RSolution\RCms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\UserRepository;

class RCmsLogin
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
        if (Auth::check())
            if (Auth::user()->role == UserRepository::ROLE_ADMIN || Auth::user()->role == UserRepository::ROLE_MANAGER)
                return $next($request);
        return redirect('/rcms/login');
    }
}
