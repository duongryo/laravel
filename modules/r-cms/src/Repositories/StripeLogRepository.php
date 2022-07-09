<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\StripeLog;

class StripeLogRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return StripeLog::class;
    }
}
