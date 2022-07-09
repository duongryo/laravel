<?php

namespace RSolution\RCms\Http\Controllers\Web\Config;

use Illuminate\Http\Request;
use RSolution\RCms\Services\Zoho\ZohoService;

class SubscriptionController extends ConfigController
{
    public function getView()
    {
        return 'rcms::pages.config.subscription.index';
    }

    public function getKey()
    {
        return 'subscription';
    }

    public function index()
    {
        $data = $this->configRepository->findByKey($this->key);

        return view($this->view, ['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->configRepository->create([
            'key' => $this->key,
            'value' => ['key' => $request->key]
        ]);
        return redirect()->back()->with('success', 'Thành công');
    }
}
