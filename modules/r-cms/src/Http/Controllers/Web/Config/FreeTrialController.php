<?php

namespace RSolution\RCms\Http\Controllers\Web\Config;

use RSolution\RCms\Repositories\PlanRepository;

class FreeTrialController extends ConfigController
{
    public function getView()
    {
        return 'rcms::pages.config.free_trial.index';
    }

    public function getKey()
    {
        return 'free_trial';
    }

    public function index()
    {
        $data = $this->configRepository->findByKey($this->key);
        $plans =  (new PlanRepository)->getAll();

        return view($this->view, ['data' => $data, 'plans' => $plans]);
    }
}
