<?php

namespace RSolution\RCms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RSolution\RCms\Repositories\AddonTransactionRepository;
use RSolution\RCms\Repositories\TransactionRepository;
use RSolution\RCms\Repositories\ValueTransactionRepository;


class TransactionController extends ApiController
{
    private $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository;
    }

    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => $this->transactionRepository->getByUserWithPlan(Auth::user()->id)
        ]);
    }

    public function getValueTransaction()
    {
        return response()->json([
            'status' => 200,
            'data' => (new ValueTransactionRepository())->getByUser(Auth::user()->id)
        ]);
    }

    public function getAddonTransaction()
    {
        return response()->json([
            'status' => 200,
            'data' => (new AddonTransactionRepository())->getByUser(Auth::user()->id)
        ]);
    }
}
