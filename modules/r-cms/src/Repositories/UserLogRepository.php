<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RSolution\RCms\Models\UserLog;

class UserLogRepository extends EloquentRepository
{
    const SHOW = 1;
    const HIDDEN = 0;

    protected $module;

    public function getModel()
    {
        return UserLog::class;
    }

    public function setLog($userId, $action, $message, $module, $visibility = self::HIDDEN)
    {
        $this->model->create([
            'user_id' => $userId,
            'action' => $action,
            'message' => $message,
            'visibility' => $visibility,
            'module' => $module
        ]);
    }

    public function getVisibililyLogs($userId, $limit = 10)
    {
        $data = $this->model
            ->where('user_id', $userId)
            ->where('visibility', self::SHOW)
            ->latest()
            ->limit($limit)
            ->get();
        $logs = [];
        foreach ($data as $item) {
            $logs[] = [
                'message' => $item->message,
                'time' => Carbon::parse($item->created_at)->format('H:m d/m/Y')
            ];
        }
        return $logs;
    }

    public function getUserLogs($userId, $limit = 10)
    {
        return $this->model->where('user_id', $userId)->latest()->paginate($limit);
    }

    public function getLogReport($range, $plan = null, $limit = 10)
    {
        $query =  $this->model::select('user_id', DB::raw('count(*) as total'))
            ->with('user')
            ->whereDate('created_at', '>=', $range[0])
            ->whereDate('created_at', '<=', $range[1])
            ->whereHas('user', function ($q) use ($plan) {
                if (!is_null($plan))
                    $q->where('plan', $plan);
            })
            ->groupBy('user_id');

        if (!is_null($limit))
            return $query = $query->paginate($limit);

        return $query->get();
    }

    public function countModuleLogs($userId, $module, $action = 'check', $type = 'daily')
    {
        $date = Carbon::now();
        return $this->model
            ->whereDate('created_at', '>=', $date)
            ->where('user_id', $userId)
            ->where('module', $module)
            ->where('action', $action)
            ->count();
    }

    public function getSystemReport($date)
    {
        return $this->model
            ->select('module', DB::raw('sum(value) as total'))
            ->whereDate('created_at', $date)
            ->groupBy('module')
            ->get();
    }

    public function filter($request, $id = null)
    {
        $query = $this->model::query();
        $range = $this->formatRange($request);

        if ($id)
            $query->where('user_id', $id);
        else {
            $query->select('user_id', DB::raw('count(*) as total'))->groupBy('user_id');
        }

        if ($range)
            $query->whereDate('created_at', '>=', $range[0])->whereDate('created_at', '<=', $range[1]);

        if (!empty($request->module))
            $query->where('module', $request->module);

        $query->orderBy('id', 'DESC');

        return $query->paginate($request->limit ? $request->limit : 10);
    }

    private function formatRange($request)
    {
        if (!empty($request->startDate) && !empty($request->endDate))
            return [$request->startDate, $request->endDate];
        else
            return null;
    }

    public function getDataChart($request, $today)
    {
        // get data in 3 days
        $startDate = !empty($request->startDate) ? $request->startDate : Carbon::parse($today)->subDays(3);
        $endDate   = !empty($request->endDate) ? $request->endDate : $today;

        $range  = $this->getRangeBetweenDay(Carbon::parse($startDate), Carbon::parse($endDate));

        return (object) [
            'chart' => $this->getDataChartOverview($request->plan, $range),
            'table' => $this->getDataModuleOverview($request->plan, $range),
            'range' => array_keys($range)
        ];
    }

    private function getRangeBetweenDay($from, $to)
    {
        for ($d = $from; $d->lte($to); $d->addDay())
            $dates[$d->toDateString()] = 0;
        return $dates;
    }

    private function getDataChartOverview($plan = null, $range)
    {
        $data = $query =  $this->model
            ->select('*')
            ->whereDate('created_at', '>=', current(array_keys($range)))
            ->whereDate('created_at', '<=', last(array_keys($range)))
            ->whereHas('user', function ($q) use ($plan) {
                if (!is_null($plan))
                    $q->where('plan', $plan);
            })
            ->get()
            ->groupBy('module');

        $data = $query->map(function ($data) {
            return $data->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->toDateString();
            })->map->sum('value');
        })->toArray();

        return $this->formaDataChartOverview($data, $range);
    }

    private function formaDataChartOverview($data, $range)
    {
        $chart = [];

        foreach ($data as $key => $value) {
            $chart[] = (object) [
                'name' => $key,
                'data' => (count($value) == count($range))
                    ? array_values($value)
                    : array_values($this->formatDefaultDay($value, $range))
            ];
        }
        //
        return $chart;
    }

    private function formatDefaultDay($arrDay, $range)
    {
        $result = array_merge($arrDay, array_diff_key($range, $arrDay));
        ksort($result);
        return $result;
    }

    private function getDataModuleOverview($plan, $range)
    {
        return $this->model
            ->select('*', DB::raw('SUM(value) as total'))
            ->whereDate('created_at', '>=', current(array_keys($range)))
            ->whereDate('created_at', '<=', last(array_keys($range)))
            ->whereHas('user', function ($q) use ($plan) {
                if (!is_null($plan))
                    $q->where('plan', $plan);
            })
            ->groupBy('module')
            ->get();
    }


    public function getDataChartModule($module, $request)
    {
        return (object) [
            'chart'  => $this->getDataChartModuleDetail($module, $request),
            'table'  => $this->getDataModuleDetail($module, $request),
            'module' => $module
        ];
    }

    private function getDataChartModuleDetail($module, $request)
    {
        $range = $this->formatRange($request);
        $plan = $request->plan;

        return $this->model
            ->select('*')
            ->where('module', $module)
            ->whereDate('created_at', '>=', $range[0])
            ->whereDate('created_at', '<=', $range[1])
            ->whereHas('user', function ($q) use ($plan) {
                if (!is_null($plan))
                    $q->where('plan', $plan);
            })
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->toDateString();
            })->map->sum('value')->toArray();
    }

    private function getDataModuleDetail($module, $request)
    {
        $range = $this->formatRange($request);
        $plan = $request->plan;

        $query = $this->model
            ->select('*', DB::raw('SUM(value) as total'))
            ->where('module', $module)
            ->whereDate('created_at', '>=', $range[0])->whereDate('created_at', '<=', $range[1]);

            if($request->column && $request->sort)
                $query = $query->orderBy($request->column, $request->sort);
            else
                $query = $query->latest();

           $query =  $query->whereHas('user', function ($q) use ($plan) {
                if (!is_null($plan))
                    $q->where('plan', $plan);
            })->groupBy("user_id");

        return $query->paginate($request->limit ? $request->limit : 10);
    }

    public function filterUserLogs($request, $id)
    {
        $query = $this->model::query();
        $range = $this->formatRange($request);

        $query->where('user_id', $id);

        if ($range)
            $query->whereDate('created_at', '>=', $range[0])->whereDate('created_at', '<=', $range[1]);

        if (!empty($request->module))
            $query->where('module', 'like', '%' . $request->module . '%');

        $query->orderBy('id', 'DESC');

        return (object)[
            'all' => $query->get(),
            'data' => $query->paginate($request->limit ? $request->limit : 10),
            'total' => $query->sum('value')
        ];
    }
}
