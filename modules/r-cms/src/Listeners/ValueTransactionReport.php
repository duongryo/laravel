<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Repositories\ValueTransactionRepository;
use RSolution\RCms\Services\TelegramService;

class ValueTransactionReport implements ShouldQueue
{
    public $queue = 'high';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $this->sendReport($event->transaction);
    }

    private function sendReport($transaction)
    {
        try {
            $product = [];
            if ($transaction->content_value)
                $product[] = number_format($transaction->content_value) . ' content credit';
            //
            if ($transaction->keyword_value)
                $product[] = number_format($transaction->keyword_value) . ' keyword credit';
            //
            (new TelegramService)->sendTransactionMessage(
                'Admin',
                $transaction->member->email,
                $transaction->status == ValueTransactionRepository::STATUS_PAID ? 'purchase' : 'cancel',
                implode(" - ", $product),
                TelegramService::LIFETIME,
                $transaction->amount,
                $transaction->note
            );
        } catch (\Exception $e) {
            (new TelegramService)->sendLog($e->getMessage());
        }
    }
}
