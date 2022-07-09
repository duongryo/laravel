<?php

namespace RSolution\RCms\Services;

class ShareasaleService
{
    private $merchantId, $token, $secretKey, $myTimeStamp, $APIVersion;

    public function __construct(string $merchantId, string $token, string $secretKey)
    {
        $this->myTimeStamp = gmdate(DATE_RFC1123);
        $this->APIVersion = 2.9;
        //
        $this->merchantId = $merchantId;
        $this->token = $token;
        $this->secretKey = $secretKey;
    }

    private function buildHash($actionVerb)
    {
        $sig = $this->token . ':' . $this->myTimeStamp . ':' . $actionVerb . ':' . $this->secretKey;
        $sigHash = hash("sha256", $sig);
        return $sigHash;
    }

    private function buildUrl(string $action, array $params = [])
    {
        $base = [
            'merchantId' => $this->merchantId,
            'token' => $this->token,
            'version' => $this->APIVersion,
            'action' => $action,
        ];
        return "https://api.shareasale.com/w.cfm?" . http_build_query(array_merge($base, $params));
    }


    /**
     * Create reference sale base on root sale information
     *
     * @param string $rootOrderNumberId
     * @param string $rootDate 'm/d/Y' 04/15/2021 (date should be in eastern US time GMT-4)
     * @param string $newAmount
     * @param string $newOrderNumberId
     * @param string $newOrderNumberId
     * @return string
     */
    public function createReferenceSale(
        string $rootOrderNumberId,
        string $rootDate,
        string $newAmount,
        string $newOrderNumberId,
        $sku = null,
        string $type = 'sale'
    ) {
        $result = $this->excute("reference", [
            'date' => $rootDate,
            'ordernumber' => $rootOrderNumberId,
            'amount' => $newAmount,
            'tracking' => $newOrderNumberId,
            'transtype' => $type,
            'skulist' => $sku
        ]);

        return $result;
    }

    private function excute(string $action, array $params = [])
    {
        $url = $this->buildUrl($action, $params);

        $sigHash = $this->buildHash($action);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-ShareASale-Date: $this->myTimeStamp",
            "x-ShareASale-Authentication: $sigHash"
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $returnResult = curl_exec($ch);

        if ($returnResult) {
            //parse HTTP Body to determine result of request
            if (stripos($returnResult, "Error Code ")) {
                // error occurred
                trigger_error($returnResult, E_USER_ERROR);
            } else {
                // success
                return $returnResult;
            }
        } else {
            // connection error
            trigger_error(curl_error($ch), E_USER_ERROR);
        }

        curl_close($ch);
    }

    /**
     * Void transaction
     *
     * @param string $orderNumberId
     * @param string $reason
     * @param string|null $date 'm/d/Y'
     * @param integer $voidChildren - 1 for void all children
     * @return string
     */
    public function voidTransaction(
        string $orderNumberId,
        string $reason = 'Cancelled order',
        string $date = null,
        int $voidChildren = 0
    ) {
        $result = $this->excute("void", [
            'ordernumber' => $orderNumberId,
            'reason' => urlencode($reason),
            'date' => $date ? $date : date('m/d/Y'),
            'voidChildren' => $voidChildren,
        ]);

        return $result;
    }
}
