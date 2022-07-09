<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    const PATH_HOME = '/rcms';

    public function index()
    {
        return view('rcms::pages.auth');
    }

    public function store(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!$validator->fails())
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
                return redirect(self::PATH_HOME);
            }
        return redirect()->back();
    }
}
