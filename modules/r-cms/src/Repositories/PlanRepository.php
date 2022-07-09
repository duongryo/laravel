<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\Plan;

class PlanRepository extends EloquentRepository
{
    const PLAN_FREE = 1;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Plan::class;
    }

    public function getNamePlanFree()
    {
        return $this->find(self::PLAN_FREE)->name;
    }
}
