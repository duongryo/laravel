<?php

namespace RSolution\RCms\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RSolution\RCms\Repositories\UserLogRepository;

class UserLogController extends Controller
{
    private $userLogRepository;

    public function __construct(UserLogRepository $userLogRepository)
    {
        $this->userLogRepository = $userLogRepository;
    }

    public function getLogs()
    {
        return response()->json([
            'status' => 200,
            'data' => $this->userLogRepository->getVisibililyLogs(Auth::user()->id)
        ]);
    }

    public function setLog(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'action' => 'required',
            'message' => 'required',
            'module' => 'required',
            'visibility' => 'required'
        ]);
        if (!$validator->fails())
            $this->userLogRepository->setLog(Auth::user()->id, $request->action, $request->message, $request->module, $request->visibility);
    }
}
