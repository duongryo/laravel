<?php

namespace RSolution\RCms\Services\Zoho;

class Plans extends ZohoService
{
    const API_URL = 'https://subscriptions.zoho.com/api/v1/plans';

    public function detail(string $planCode)
    {
        return $this->submitGetRequest(self::API_URL . "/{$planCode}");
    }
}
