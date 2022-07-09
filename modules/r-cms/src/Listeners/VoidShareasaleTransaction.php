<?php

namespace RSolution\RCms\Listeners;

use RSolution\RCms\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Events\TransactionDestroyed;
use RSolution\RCms\Repositories\ConfigRepository;
use RSolution\RCms\Repositories\TransactionRepository;
use RSolution\RCms\Services\ShareasaleService;

class VoidShareasaleTransaction implements ShouldQueue
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
     * @param  TransactionDestroyed  $event
     * @return void
     */
    public function handle(TransactionDestroyed $event)
    {
        try {
            $transaction = $event->transaction;
            $configuration = (new ConfigRepository)->findByKey('shareasale', true);

            if (
                $configuration &&
                $transaction->status == TransactionRepository::STATUS_CANCELLED &&
                $transaction->invoice_id
            ) {
                $shareasaleService = new ShareasaleService(
                    $configuration['merchant_id'],
                    $configuration['token'],
                    $configuration['secret_key']
                );
                $result = $shareasaleService->voidTransaction(
                    $transaction->invoice_id,
                    'Cancelled order',
                    $transaction->created_at->setTimezone('GMT-4')->format('m/d/Y'),
                );
                (new TelegramService)->sendLog("Shareasale: " . trim($result) . " - Invoice ID: " . $transaction->invoice_id);
            }
        } catch (\Exception $e) {
            (new TelegramService)->sendLog($e->getMessage());
        }
    }
}
