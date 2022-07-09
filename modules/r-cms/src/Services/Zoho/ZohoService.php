<?php

namespace RSolution\RCms\Services\Zoho;

use Carbon\Carbon;
use RSolution\RCms\Repositories\ActivationRepository;
use RSolution\RCms\Repositories\ConfigRepository;
use RSolution\RCms\Repositories\UserRepository;
use RSolution\RCms\Services\TelegramService;

class ZohoService
{
    protected $clientId, $redirectUrl, $organizationId, $clientSecret;
    protected $accessToken, $refreshToken;

    public function __construct(string $clientId = null, string $clientSecret = null)
    {
        if ($clientId && $clientSecret) {
            $this->clientId = $clientId;
            $this->clientSecret = $clientSecret;
        } else
            $this->setDefaultConfiguration();
        //
        $this->redirectUrl = route('rcms.api.subscription.callback');
    }

    private function setDefaultConfiguration()
    {
        $configuration = (new ConfigRepository)->findByKey('subscription');
        if ($configuration) {
            $this->clientId = $configuration->value['client_id'];
            $this->clientSecret = $configuration->value['client_secret'];
            $this->organizationId = $configuration->value['organization_id'];
            $this->refreshToken =  $configuration->value['refresh_token'];
            $this->accessToken = $this->createAccessTokenFromRefreshToken($this->refreshToken);
        }
    }

    public function createOauthToken(string $code)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'code' => $code,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUrl,
            'grant_type' => 'authorization_code',
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return json_decode($server_output);
    }

    private function createAccessTokenFromRefreshToken(string $refreshToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token");
        curl_setopt($ch, CURLOPT_POST, true);
        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'refresh_token' => $refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUrl,
            'grant_type' => 'refresh_token',
        ]));
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);
        return isset($data->access_token) ? $data->access_token : null;
    }

    protected function submitGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
            "Authorization: Zoho-oauthtoken {$this->accessToken}",
            "X-com-zoho-subscriptions-organizationid: {$this->organizationId}",
            'Content-Type: application/json',
        ));
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }

    protected function submitPostRequest(string $url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
            "Authorization: Zoho-oauthtoken {$this->accessToken}",
            "X-com-zoho-subscriptions-organizationid: {$this->organizationId}",
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        //
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        //
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }
}
