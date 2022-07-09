<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RSolution\RCms\Repositories\ActivationRepository;
use RSolution\RCms\Repositories\TransactionRepository;
use RSolution\RCms\Repositories\ValueTransactionRepository;

class ActivationController extends WebController
{
    private $activationRepository;
    private $transactionRepository;

    public function __construct()
    {
        $this->activationRepository = new ActivationRepository;
        $this->transactionRepository = new TransactionRepository;
    }

    public function upgrade(Request $request)
    {
        $this->validateRequest($request, [
            'user_id' => 'required',
            'price' => 'required',
            'from_plan' => 'required',
            'to_plan' => 'required',
            'plan_time' => 'required',
        ]);

        $result = $this->activationRepository->upgrade(
            Auth::user(),
            $request->input()
        );

        return $result ?
            redirect()->back()->with('success', 'Thành công') :
            redirect()->back()->withErrors(['Thất bại']);
    }

    public function renew(Request $request)
    {
        $this->validateRequest($request, [
            'user_id' => 'required',
            'price' => 'required',
            'from_plan' => 'required',
            'to_plan' => 'required',
            'plan_time' => 'required',
        ]);

        $result = $this->activationRepository->renew(
            Auth::user(),
            $request->input()
        );

        return $result ?
            redirect()->back()->with('success', 'Thành công') :
            redirect()->back()->withErrors(['Thất bại']);
    }

    public function destroy(Request $request)
    {
        $this->validateRequest($request, ['id' => 'required']);
        $result = $this->transactionRepository->destroy($request->id);
        return $result ? redirect()->back()->with('success', 'Thành công') : redirect()->back()->withErrors(['Thất bại']);
    }

    public function addKeywordValue(Request $request)
    {
        $this->validateRequest($request, [
            'user_id' => 'required',
            'keyword_value' => 'required',
            'content_value' => 'required',
            'amount' => 'required',
        ]);

        $result = (new ValueTransactionRepository())->createTransaction(
            Auth::user(),
            $request->input()
        );

        return $result ?
            redirect()->back()->with('success', 'Thành công') :
            redirect()->back()->withErrors(['Thất bại']);
    }
}
