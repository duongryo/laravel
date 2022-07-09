<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    protected function validateRequest($request, $fields)
    {
        $request->validate($fields);
    }
}
