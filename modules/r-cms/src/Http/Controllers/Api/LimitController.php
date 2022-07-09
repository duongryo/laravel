<?php

namespace RSolution\RCms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\LimitRepository;

class LimitController extends ApiController
{
    protected $limitRepository;

    public function __construct()
    {
        $this->limitRepository = new LimitRepository;
    }

    public function getUsage(request $request)
    {
        $this->validateRequest($request, ['module' => 'required']);

        return response()->json([
            'status' => 200,
            'data' => $this->limitRepository->getUsage(
                Auth::user(),
                $request->module
            )
        ]);
    }

    public function getAllUsage()
    {
        return response()->json([
            'status' => 200,
            'data' => $this->limitRepository->getAllUsage(
                Auth::user()
            )
        ]);
    }
}
