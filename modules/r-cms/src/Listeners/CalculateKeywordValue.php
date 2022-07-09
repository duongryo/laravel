<?php

namespace RSolution\RCms\Listeners;

use RSolution\RCms\Events\ValueTransactionCreated;
use RSolution\RCms\Repositories\UserRepository;
use RSolution\RCms\Repositories\ValueTransactionRepository;

class CalculateKeywordValue
{
    //public $queue = 'high';

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
     * @param  ValueTransactionCreated  $event
     * @return void
     */
    public function handle(ValueTransactionCreated $event)
    {
        $transaction = $event->transaction;
        if ($transaction->status == ValueTransactionRepository::STATUS_PAID) {
            if ($transaction->content_value) {
                (new UserRepository)->addContentValue(
                    $transaction->user_id,
                    $transaction->content_value
                );
                //
            }
            if ($transaction->keyword_value) {
                (new UserRepository)->addKeywordValue(
                    $transaction->user_id,
                    $transaction->keyword_value
                );
            }
        }
    }
}
