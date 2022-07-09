<?php

namespace RSolution\RCms\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    protected function validateRequest($request, $fields)
    {
        $validator = Validator::make($request->input(), $fields);
        if ($validator->fails())
            abort(response()->json(['status' => 500]));
    }
}
