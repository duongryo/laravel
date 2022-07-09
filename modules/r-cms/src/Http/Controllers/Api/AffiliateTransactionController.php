<?php

namespace RSolution\RCms\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RSolution\RCms\Repositories\AffiliateTransactionRepository;
use RSolution\RCms\Repositories\UserRepository;

class AffiliateTransactionController extends Controller
{
    private $affiliateTransactionRepository;

    public function __construct()
    {
        $this->affiliateTransactionRepository = new AffiliateTransactionRepository;
    }

    public function redirect(Request $request)
    {
        if (!empty($request->ref)) {
            Session::put('ref_id', $this->affiliateTransactionRepository->decryptCode($request->ref));
        }
        return redirect('/register');
    }

    protected function validateRequest($request, $fields)
    {
        $validator = Validator::make($request->input(), $fields);
        if ($validator->fails())
            abort(response()->json(['status' => 500]));
    }

    public function index(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data' => $this->affiliateTransactionRepository->getByUser(Auth::user()->id)
        ]);
    }

    public function info()
    {
        return response()->json([
            'status' => 200,
            'data' => [
                'refferer_link' => $this->affiliateTransactionRepository->buildReffererLink(Auth::user()),
                'refferer_users' => (new UserRepository)->getReffererUser(Auth::user()->id)
            ]
        ]);
    }
}
