<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\ZohoPlan;

class ZohoPlanRepository extends EloquentRepository
{
    const PLAN_FREE = 1;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return ZohoPlan::class;
    }

    public function getAllWithPlan(int $limit = 10)
    {
        return $this->model->with('plan')->latest()->paginate($limit);
    }

    public function getZohoPlanByPlanId(int $planId)
    {
        return $this->model->where('plan_id', $planId)->latest()->first();
    }

    public function getZohoPlanByCode(string $code)
    {
        return $this->model->where('code', $code)->latest()->first();
    }
}
