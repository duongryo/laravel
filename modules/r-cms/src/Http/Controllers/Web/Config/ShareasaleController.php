<?php

namespace RSolution\RCms\Http\Controllers\Web\Config;

use RSolution\RCms\Repositories\PlanRepository;

class ShareasaleController extends ConfigController
{
    public function getView()
    {
        return 'rcms::pages.config.shareasale.index';
    }

    public function getKey()
    {
        return 'shareasale';
    }

    public function index()
    {
        $data = $this->configRepository->findByKey($this->key);

        return view($this->view, ['data' => $data]);
    }
}
