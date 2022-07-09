<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\UserLogRepository;
use RSolution\RCms\Repositories\UserRepository;
use RSolution\RCms\Repositories\PlanRepository;
use Rap2hpoutre\FastExcel\FastExcel;

class ChartLogController extends Controller
{

    private $userLogRepository;
    private $today;

    public function __construct()
    {
        $this->userLogRepository = new UserLogRepository;
        $this->today = Carbon::now()->format('Y-m-d');
    }

    public function index(Request $request)
    {
        $data = $this->userLogRepository->getDataChart($request, $this->today);
        $plans = (new PlanRepository)->getAll();

        return view('rcms::pages.chart_log.index', compact(['data', 'plans']));
    }

    public function exportDataIndex(Request $request)
    {
        $data = $this->userLogRepository->getDataChart($request, $this->today);

        $export = [];
        foreach ($data->table as $value){
            $export[] = [
                'module' => $value->module,
                'total' => $value->total
            ];
        }
        
        return (new FastExcel($export))->download('data.xlsx');
    }

    public function show($module, request $request)
    {
        $data = $this->userLogRepository->getDataChartModule($module, $request);
        $plans = (new PlanRepository)->getAll();

        return view('rcms::pages.chart_log.report', compact(['data', 'plans']));
    }
}
