<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    private $dashboardRepository;

    public function __construct()
    {
        $this->dashboardRepository = new DashboardRepository;
    }

    public function index(Request $request)
    {
        $data = $this->dashboardRepository->getReport($request);


        return view('rcms::pages.dashboard.index', ['data' => $data]);
    }
}
