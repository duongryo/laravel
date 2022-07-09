<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use RSolution\RCms\Models\Limit;

class LimitRepository extends EloquentRepository
{
    const PLAN_FREE = 1;
    const PLAN_PREMIUM = 2;
    const PLAN_PLATINUM = 3;


    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Limit::class;
    }

    public function getPlanName($planId)
    {
        $plan = (new PlanRepository)->find($planId);
        return $plan ? $plan->name : null;
    }

    public function getLimit($module, $planId)
    {
        return (new ModuleRepository)->getLimit($module, $planId);
    }

    public function getUsage($user, $module)
    {
        $usage = (new ModuleRepository)->getUsage($module, $user);
        return $usage;
    }

    /**
     * Check Usage And Set Message
     *
     * @param [type] $user
     * @param [type] $module
     * @param string $action
     * @param [type] $message
     * @param integer $value
     * @return bool
     */
    public function checkUsageAndSetMessage($user, $module, $action = 'check', $message = null, $value = 1)
    {
        $userLogRepository = new UserLogRepository;

        $usage = $this->getUsage($user, $module);

        if ($usage['available'] >= $value) {
            if (
                $this->isValueModule($module) &&
                $usage['monthly_available'] < $value
            ) {
                //
                $valueOneTime = $value - $usage['monthly_available'];
                //
                if ($module == ModuleRepository::TYPE_KEYWORD_VALUE)
                    $user->keyword_value = $user->keyword_value - $valueOneTime;
                else
                    $user->content_value = $user->content_value - $valueOneTime;
                //
                $user->save();
                //
                $this->setUsage(
                    $user->id,
                    $module,
                    $action,
                    $message,
                    $usage['monthly_available']
                );

                $this->setUsage(
                    $user->id,
                    $module . '_one_time',
                    $action,
                    $message,
                    $valueOneTime
                );

                return true;
                //
            } else {
                $this->setUsage(
                    $user->id,
                    $module,
                    $action,
                    $message,
                    $value
                );
                return true;
            }
        } else
            return false;
    }

    private function isValueModule($module)
    {
        return
            $module == ModuleRepository::TYPE_KEYWORD_VALUE ||
            $module == ModuleRepository::TYPE_CONTENT_VALUE ?
            true :
            false;
    }

    //
    public function getData()
    {
        $result = new \stdClass();
        $result->plans = (new PlanRepository)->getAll();
        $result->limits = $this->getAll();
        $result->modules = (new ModuleRepository)->getAll();
        $result->data = [];

        foreach ($result->modules as $module) {
            $temp = [];
            foreach ($result->plans as $plan) {
                $value = $result->limits->where('plan_id', $plan->id)->where('module_id', $module->id)->first();
                $temp[] = [
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'module_id' => $module->id,
                    'limit' => $value ? $value->limit : 0
                ];
            }
            $result->data[] = [
                'module' => $module->module,
                'type' => $module->type,
                'values' => $temp
            ];
        }

        return $result;
    }

    public function updateOrCreate($limits)
    {
        foreach ($limits as $moduleId => $plans) {
            foreach ($plans as $planId => $limit)
                $this->model->updateOrCreate(
                    ['plan_id' => $planId, 'module_id' => $moduleId],
                    ['limit' => $limit]
                );
        }
    }

    public function deleteByKey($key, $value)
    {
        $this->model->where($key, $value)->delete();
    }

    public function getAllUsage($user)
    {
        return (new ModuleRepository)->getAllUsage($user);
    }

    public function setUsage($userId, $module, $action, $message, $value)
    {
        return (new UserLogRepository)->create(
            [
                'user_id' => $userId,
                'module' => $module,
                'action' => $action,
                'message' => $message,
                'value' => $value
            ]
        );
    }
}
