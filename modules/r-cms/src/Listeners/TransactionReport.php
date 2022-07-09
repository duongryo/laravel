<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Repositories\TransactionRepository;
use RSolution\RCms\Services\TelegramService;

class TransactionReport implements ShouldQueue
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
            $action =
                $transaction->status == TransactionRepository::STATUS_CANCELLED ?
                'Cancel' :
                ucfirst($transaction->type);

            (new TelegramService)->sendTransactionMessage(
                $transaction->manager->name,
                $transaction->member->email,
                $action,
                $transaction->toPlanInfo->name,
                $transaction->plan_time,
                $transaction->amount,
                $transaction->note
            );
        } catch (\Exception $e) {
            (new TelegramService)->sendLog($e->getMessage());
        }
    }
}
