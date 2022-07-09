<?php

namespace RSolution\RCms\Services\Zoho;

class HostedPages extends ZohoService
{
    const API_URL = 'https://subscriptions.zoho.com/api/v1/hostedpages';

    public function list()
    {
        return $this->submitGetRequest(self::API_URL);
    }

    public function detail(string $id)
    {
        return $this->submitGetRequest(self::API_URL . "/{$id}");
    }

    public function create(string $planCode, string $email, string $customerId = null)
    {
        $data = [
            'customer' => [
                'display_name' => $email,
                'email' => $email,
            ],
            'plan' => [
                'plan_code' => $planCode
            ],
            'redirect_url' => $this->redirectUrl,
        ];

        if ($customerId)
            $data['customer_id'] = $customerId;

        return $this->submitPostRequest(self::API_URL . '/newsubscription', $data);
    }

    public function upgrade(string $planCode, string $subscriptionId)
    {
        return $this->submitPostRequest(self::API_URL . '/updatesubscription', [
            'subscription_id' => $subscriptionId,
            'plan' => [
                'plan_code' => $planCode
            ],
            'redirect_url' => $this->redirectUrl
        ]);
    }
}
