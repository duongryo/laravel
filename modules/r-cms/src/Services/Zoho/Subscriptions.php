<?php

namespace RSolution\RCms\Services\Zoho;

class Subscriptions extends ZohoService
{
    const API_URL = 'https://subscriptions.zoho.com/api/v1/subscriptions';

    public function detail(string $id)
    {
        return $this->submitGetRequest(self::API_URL . "/{$id}");
    }
}
