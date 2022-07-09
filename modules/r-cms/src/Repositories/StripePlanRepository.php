<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\StripePlan;

class StripePlanRepository extends EloquentRepository
{
    const PLAN_FREE = 1;
    const TYPE_VALUE = 'value';
    const TYPE_ADDON = 'addon';
    const TYPE_MONTHLY = 'monthly';
    const TYPE_ANUAL = 'anual';

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return StripePlan::class;
    }

    public function getAllWithPlan(int $limit = 10, $paginate = true)
    {
        return $paginate ?
            $this->model->with('plan')->latest()->paginate($limit) :
            $this->model->with('plan')->latest()->get();
    }

    public function findByPlanId(int $planId)
    {
        return $this->model->where('plan_id', $planId)->latest()->first();
    }

    public function findByCode(string $code)
    {
        return $this->model->where('code', $code)->latest()->first();
    }

    public function getSku($stripePlan)
    {
        $sku = $stripePlan && $stripePlan->plan ?
            strtolower($stripePlan->plan->name . "_" . $stripePlan->type) :
            'undefined';
        return $sku;
    }
}
