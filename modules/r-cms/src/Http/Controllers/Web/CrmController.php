<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\PlanRepository;
use RSolution\RCms\Repositories\TransactionRepository;

class CrmController extends Controller
{
    private $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
    }

    public function index(Request $request)
    {
        $overview = $this->transactionRepository->getDataOverview();
        $data     = $this->transactionRepository->filter($request);
        $plans = (new PlanRepository)->getAll();
        return view('rcms::pages.crm.index', compact('overview', 'data', 'plans'));
    }
}
