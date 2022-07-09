<?php

namespace RSolution\RCms\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RSolution\RCms\Repositories\ModuleRepository;
use RSolution\RCms\Repositories\UserLogRepository;
use RSolution\RCms\Repositories\UserRepository;
use RSolution\RCms\Repositories\PlanRepository;

use Rap2hpoutre\FastExcel\FastExcel;

class UserLogController extends Controller
{
    const PAGE_LIMIT = 20;

    private $userLogRepository;
    private $today;

    public function __construct()
    {
        $this->userLogRepository = new UserLogRepository;
        $this->today = Carbon::now()->format('Y-m-d');
    }

    public function index(Request $request)
    {
        $startDate = !empty($request->startDate) ? $request->startDate : $this->today;
        $endDate   = !empty($request->endDate) ? $request->endDate : $this->today;
        $range = [$startDate, $endDate];

        $data = $this->userLogRepository->getLogReport(
            $range,
            $request->plan,
            self::PAGE_LIMIT
        );

        return view('rcms::pages.user_log.index', [
            'data'  => $data,
            'range' => $range,
            'plans'  => (new PlanRepository)->getAll()
        ]);
    }

    public function exportDataIndex(Request $request)
    {
        $range = [$request->startDate, $request->endDate];
        $data = $this->userLogRepository->getLogReport($range, $request->plan, null);
        $export = [];

        foreach ($data as $value){
            $export[] = [
                'email' => $value->user->email,
                'total' => $value->total,
            ];
        }

        return  (new FastExcel($export))->download('data.xlsx');
    }

    public function show($id, request $request)
    {
        $user = (new UserRepository)->find($id);
        $data = $this->userLogRepository->filterUserLogs($request, $id);
        $modules = (new ModuleRepository)->getAll();

        return view('rcms::pages.user_log.report', [
            'data' => $data->data,
            'user' => $user,
            'total' => $data->total,
            'modules' => $modules
        ]);
    }

    public function exportDataDetail($id, Request $request)
    {
        $user = (new UserRepository)->find($id);
        $data = $this->userLogRepository->filterUserLogs($request, $id);
        
        foreach ($data->all as $value){
            $export[] = [
                'action' => $value->action,
                'module' => $value->module,
                'message' => $value->message,
                'count' => $value->value,
                'created_at' => $value->created_at,
            ];
        }

        return  (new FastExcel($export))->download('data.xlsx');
    }
}
