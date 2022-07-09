<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use RSolution\RCms\Models\Module;


class ModuleRepository extends EloquentRepository
{
    const TYPE_KEYWORD_VALUE = 'keyword_value';
    const TYPE_CONTENT_VALUE = 'content_value';
    const TYPE_CUSTOM = 'custom';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Module::class;
    }

    public function findByModule($module)
    {
        return $this->model->where('module', $module)->first();
    }

    public function getLimit($module, $planId)
    {
        $module = $this->model->where('module', $module)->with(['limits' => function ($q) use ($planId) {
            $q->where('plan_id', $planId);
        }])->first();

        if ($module) {
            $limit = $module->limits->first();
            return $limit ? $limit->limit : 0;
        }
        return 0;
    }

    public function getUsage($moduleName, $user)
    {
        $planId = $user->plan;
        $module = $this->model->where('module', $moduleName)->with([
            'limits' => function ($q) use ($planId) {
                $q->where('plan_id', $planId);
            },
        ])->first();

        return $this->calculateUsage($module, $user);
    }

    private function calculateUsage($module, $user, $usage = null)
    {
        if ($module) {
            if ($usage === null) {
                $date = $this->calculateTimeRange($user, $module->type);

                $usage = $module->logs()
                    ->where('user_id', $user->id)
                    ->where('created_at', '>=', $date)
                    ->sum('value');
            }

            $limit = $module->limits->first() ? $module->limits->first()->limit : 0;

            $available = max($limit - $usage, 0);


            $result = [
                'module' => $module->module,
                'type' => $module->type,
                'limit' => $limit,
                'usage' => round($usage),
                'available' => $available
            ];

            if (
                $result['module'] == self::TYPE_KEYWORD_VALUE ||
                $result['module'] == self::TYPE_CONTENT_VALUE
            ) {
                $value = $result['module'] == self::TYPE_KEYWORD_VALUE ? $user->keyword_value : $user->content_value;
                $result['monthly_available'] = $result['available'];
                $result['one_time_available'] = $value;
                $result['available'] = $result['available'] + $value;
            }

            return $result;
        } else
            return [
                'module' => null,
                'type' => null,
                'limit' => 0,
                'usage' => 0,
                'available' => 0
            ];
    }

    private function calculateTimeRange($user, $type = 'daily')
    {
        if ($type == 'daily') {

            if ($user->activation && $user->activation->created_at->isToday()) {
                return $user->activation->created_at;
            } else {
                return now()->startOfDay();
            }
        } else {
            if ($user->activation) {
                if (
                    now()->format('m-y') ==
                    $user->activation->created_at->format('m-y')
                )
                    return $user->activation->created_at;
                else {
                    $billingCycleDay = $user->activation->created_at->format('d');
                    $today = now()->format('d');
                    if ($today < $billingCycleDay)
                        return now()->subMonth()->firstOfMonth()->addDays($billingCycleDay - 1);
                    else
                        return now()->firstOfMonth()->addDays($billingCycleDay - 1);
                }
            } else
                return now()->firstOfMonth();
        }
    }

    public function getAllUsage($user)
    {
        $date = $this->calculateTimeRange($user, 'monthly');
        $modules = $this->model->with([
            'limits' => function ($q) use ($user) {
                $q->where('plan_id', $user->plan);
            },
            'logs' => function ($q) use ($user, $date) {
                $q->where('user_id', $user->id)
                    ->where('created_at', '>=', $date);
                //->sum('value');
            }
        ])->get();

        $result = $modules->map(function ($module) use ($user) {
            $date = $this->calculateTimeRange($user, $module->type);
            $usage = $module->logs->where('created_at', '>=', $date)->sum('value');

            return $this->calculateUsage($module, $user, $usage);
        });

        return $result;
    }

    public function getDailyReport($date)
    {
        $temp = $this->model->where('type', '!=', self::TYPE_CUSTOM)->select('module')->get();
        $logs = (new UserLogRepository)->getSystemReport($date);
        $custom = ['content_value_one_time', 'keyword_value_one_time'];
        $modules = array_merge($temp->pluck('module')->toArray(), $custom);
        $report = [];
        foreach ($modules as $item) {
            $report[] = (object)[
                'module' => $item,
                'total' => $logs->where('module', $item)->sum('total')
            ];
        }
        
        return $report;
    }
}
