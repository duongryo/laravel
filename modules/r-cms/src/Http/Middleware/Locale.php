<?php

namespace RSolution\RCms\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Locale
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
        $locale = \Session::get('website_language', config('app.locale'));
        // get language in session

        App::setLocale($locale);
        // Set locale language into app

        return $next($request);
    }
}
