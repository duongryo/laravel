<?php

namespace RSolution\RCms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PublicController extends Controller
{
    public function block()
    {
        return view('rcms::pages.public.block');
    }

    public function changeLanguage($language)
    {
        Session::put('website_language', $language);
        return redirect()->back();
    }

    public function thankyou()
    {
        if (View::exists('pages.public.thankyou'))
            return view('pages.public.thankyou');
        else
            return view('rcms::pages.public.thankyou');
    }

    public function maintenance()
    {
        if (View::exists('pages.public.maintenance'))
            return view('pages.public.maintenance');
        else
            return view('rcms::pages.public.maintenance');
    }

    public function error()
    {
        abort(404);
    }
}
