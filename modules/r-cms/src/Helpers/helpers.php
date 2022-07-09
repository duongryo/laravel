<?php
//Clean Domain
if (!function_exists('cleanDomain')) {
    function cleanDomain($domain)
    {
        $domain = trim($domain);
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www.', '', $domain);
        $domain = str_replace(' ', '', $domain);
        $domain = str_replace('/', '', $domain);
        return $domain;
    }
}

//Clean Sub Domain
if (!function_exists('cleanSubDomain')) {
    function cleanSubDomain($domain)
    {
        $domain = trim($domain);
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace(' ', '', $domain);
        $domain = str_replace('/', '', $domain);
        return $domain;
    }
}

//Convert TextArea to Array '/n'
if (!function_exists('cleanExplode')) {
    function cleanExplode($text, $lowercase = false)
    {
        $result = [];
        $rows = explode("\n", $text);
        foreach ($rows as $row) {
            $row = trim($row);
            if (!empty($row))
                $result[] = $lowercase ? mb_strtolower($row, 'UTF-8') : $row;
        }
        return formatArrayUnique($result);
    }
}

//Convert TextArea to Array URL '/n'
if (!function_exists('cleanExplodeUrl')) {
    function cleanExplodeUrl($text)
    {
        $result = [];
        $rows = explode("\n", $text);
        foreach ($rows as $row) {
            $row = trim($row);
            if ($row != null && $row != '' && filter_var($row, FILTER_VALIDATE_URL))
                $result[] = mb_strtolower($row, 'UTF-8');
        }
        return formatArrayUnique($result);
    }
}

//Convert text to array idd
if (!function_exists('convertBulkId')) {
    function convertBulkId($id)
    {
        $array_ = explode(",", $id);
        $array = [];
        foreach ($array_ as $item) {
            if (is_numeric($item)) {
                array_push($array, $item);
            }
        }
        return $array;
    }
}

//Proxy Get Content
if (!function_exists('proxyGetContent')) {
    function proxyGetContent($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_PROXY, 'http://zproxy.lum-superproxy.io:22225');
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, config('services.proxy.key'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}

if (!function_exists('proxyGetStatus')) {
    function proxyGetStatus($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_PROXY, 'http://zproxy.lum-superproxy.io:22225');
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, config('services.proxy.key'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $httpcode;
    }
}

//Telegram
if (!function_exists('sendTelegramMessage')) {
    function sendTelegramMessage($message)
    {
        $chat_id = config('services.telegram.group_logs');
        $bot_token = config('services.telegram.rtool_bot_token');
        $url = 'https://api.telegram.org/bot' . $bot_token . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=HTML&text=' . urlencode($message);
        @file_get_contents($url);
    }
}

//Url Exist
if (!function_exists('urlExists')) {
    function urlExists($url)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($httpCode >= 200 && $httpCode <= 400) {
            return true;
        } else {
            return false;
        }
        curl_close($handle);
    }
}

//Valid Url
if (!function_exists('validUrl')) {
    function validUrl($url)
    {
        if (parse_url($url, PHP_URL_SCHEME) != "")
            return $url;
        else
            return 'https://' . $url;
    }
}

//Same Domain
if (!function_exists('areSameDomain')) {
    function areSameDomain($domainA, $domainB)
    {
        $domainA = parse_url($domainA);
        $domainB = parse_url($domainB);
        if (!empty($domainA['scheme']) && !empty($domainB['scheme']) && !empty($domainA['host']) && !empty($domainB['host']))
            if ($domainA['scheme'] == $domainB['scheme'] && $domainA['host'] == $domainB['host'])
                return 1;
        return 0;
    }
}

//format array unique
if (!function_exists('formatArrayUnique')) {
    function formatArrayUnique($data)
    {
        $temp = array_unique($data);
        $result = [];
        foreach ($temp as $item) {
            $result[] = $item;
        }
        return $result;
    }
}

//format micro amount
if (!function_exists('formatMicroAmount')) {
    function formatMicroAmount($amount, bool $microToAmount = true)
    {
        if ($microToAmount)
            return $amount / 1000000;
        return $amount * 1000000;
    }
}

//format Vn string
if (!function_exists('formatVnString')) {
    function formatVnString($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }
}
