<?php

namespace RSolution\RCms\Listeners;

use RSolution\RCms\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Events\TransactionCreated;
use RSolution\RCms\Repositories\ConfigRepository;
use RSolution\RCms\Repositories\StripePlanRepository;
use RSolution\RCms\Repositories\TransactionRepository;
use RSolution\RCms\Services\ShareasaleService;

class CheckShareasaleReference implements ShouldQueue
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
     * @param  TransactionCreated  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        try {
            $transaction = $event->transaction;
            $configuration = (new ConfigRepository)->findByKey('shareasale', true);

            if (
                $configuration &&
                $transaction->type == TransactionRepository::TYPE_RENEW &&
                $transaction->invoice_id &&
                $transaction->subscription_id
            ) {
                $shareasaleService = new ShareasaleService(
                    $configuration['merchant_id'],
                    $configuration['token'],
                    $configuration['secret_key']
                );
                $result = $shareasaleService->createReferenceSale(
                    $transaction->root->invoice_id,
                    $transaction->root->created_at->setTimezone('GMT-4')->format('m/d/Y'),
                    min($transaction->amount, $transaction->price),
                    $transaction->invoice_id,
                    (new StripePlanRepository)->getSku($transaction->stripePlan)
                );
                (new TelegramService)->sendLog("Shareasale: " . trim($result) . " - Invoice ID: " . $transaction->invoice_id);
            }
        } catch (\Exception $e) {
            (new TelegramService)->sendLog($e->getMessage());
        }
    }
}
