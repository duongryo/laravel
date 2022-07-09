<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use RSolution\RCms\Repositories\LimitRepository;
use RSolution\RCms\Repositories\PlanRepository;
use RSolution\RCms\Repositories\UserRepository;

class ManageUserController extends Controller
{
    const PAGE_LIMIT = 10;

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function index(Request $request)
    {
        $info = $this->userRepository->countMemberByPlan();
        $data = $this->userRepository->filter($request);
        $plans = (new PlanRepository)->getAll();
        return view('rcms::pages.manage_user.index', ['data' => $data, 'info' => $info, 'plans' => $plans]);
    }

    public function show($id)
    {
        $data = $this->userRepository->find($id);
        $plans = (new PlanRepository)->getAll();
        return view('rcms::pages.manage_user.report', ['data' => $data, 'plans' => $plans]);
    }

    public function update($id, request $request)
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            if (isset($request->status))
                $user->status = $request->status;

            if (isset($request->role))
                $user->role = $request->role == UserRepository::ROLE_TESTER ? UserRepository::ROLE_TESTER : UserRepository::ROLE_MEMBER;

            $user->save();
        }
        return redirect()->back();
    }

    public function loginAsUser(request $request)
    {
        Auth::loginUsingId($request->id);
        return redirect(URL::to('/'));
    }

    public function usage($id)
    {
        $user = $this->userRepository->find($id);
        $usage = (new LimitRepository)->getAllUsage($user);
        return view('rcms::pages.manage_user.usage', ['user' => $user, 'usage' => $usage]);
    }
}
