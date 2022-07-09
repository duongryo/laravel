<?php

namespace RSolution\RCms\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RSolution\RCms\Repositories\UserRepository;

class UserContoller extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getProfile()
    {
        $data = $this->userRepository->getProfile(
            Auth::user()
        );

        $this->userRepository->updateLastLogin(Auth::user()->id);

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function updateProfile(Request $request)
    {
        $this->userRepository->update(Auth::user()->id, $request->input());

        return response()->json([
            'status' => 200
        ]);
    }

    public function updatePass(request $request)
    {
        $validator = Validator::make($request->input(), [
            'oldPass' => 'required',
            'newPass' => 'required'
        ]);

        if ($validator->fails())
            return response()->json([
                'status' => 500,
                'message' => 'Validation fail'
            ]);

        $data = $this->userRepository->updatePassword(
            Auth::user()->id,
            $request->oldPass,
            $request->newPass
        );

        return response()->json([
            'status' => $data ? 200 : 500
        ]);
    }
}
