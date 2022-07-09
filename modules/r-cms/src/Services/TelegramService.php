<?php

namespace RSolution\RCms\Services;

use Carbon\Carbon;

class TelegramService
{
    const PARSE_MODE_HTML = 'HTML';
    const PARSE_MODE_MARKDOWN = 'MarkdownV2';
    const LIFETIME = -1;
    //https://api.telegram.org/bot945151095:AAHNux9jpUJ6iH0VlY-ZYyIVgrX8u05sUiM/getUpdates

    private $botToken, $parseMode;

    public function __construct($parseMode = self::PARSE_MODE_HTML)
    {
        $this->botToken = config('rcms-services.telegram.bot_token');
        //Set Parse mode;
        $this->parseMode = $parseMode;
    }

    public function sendMessage($message)
    {
        $this->sendRequest(
            config('rcms-services.telegram.realtime_group'),
            $message
        );
    }

    public function sendLog($message)
    {
        $this->sendRequest(
            config('rcms-services.telegram.log_group'),
            $message
        );
    }

    public function sendStripeLog($message)
    {
        $this->sendRequest(
            config('rcms-services.telegram.stripe_log_group'),
            $message
        );
    }

    public function sendDailyReport($message)
    {
        $this->sendRequest(
            config('rcms-services.telegram.daily_report_group'),
            $message
        );
    }

    private function sendRequest($groupId, $message)
    {
        $url = 'https://api.telegram.org/bot' . $this->botToken . '/sendMessage?chat_id=' . $groupId . '&parse_mode=' . $this->parseMode . '&text=' . urlencode($message);
        @file_get_contents($url);
    }

    public function sendTransactionMessage(
        string $system = 'Admin',
        string $user,
        string $action,
        string $product,
        int $duration,
        int $cost = 0,
        string $note = null
    ) {
        $time = now()->format('Y-m-d H:i');
        $formattedDuration = $duration == self::LIFETIME ? "Lifetime" : number_format($duration) . " days";

        $message = "<b>SUBSCRIPTION RELATED</b>\n\n";
        $message .= "<b>System     :</b> {$system}\n";
        $message .= "<b>User          :</b> {$user}\n";
        $message .= "<b>Action      :</b> " . ucfirst($action) . "\n";
        $message .= "<b>Product   :</b> " . ucfirst($product) . "\n";
        $message .= "<b>Duration :</b> " . $formattedDuration . "\n";
        $message .= "<b>Cost           :</b> $" . number_format($cost) . "\n";
        $message .= "<b>Time          :</b> {$time}\n";
        if ($note)
            $message .= "<b>Note          :</b> " . ucfirst($note) . "\n ";
        //
        $this->sendRequest(
            config('rcms-services.telegram.realtime_group'),
            $message
        );
    }
}
