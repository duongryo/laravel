<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Events\ValueTransactionCreated;
use RSolution\RCms\Mail\KeywordValuePurchase;
use RSolution\RCms\Repositories\ValueTransactionRepository;

class SendMailValuePurchase implements ShouldQueue
{
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
        if (
            $event->transaction->status == ValueTransactionRepository::STATUS_PAID
            && $event->sendMail
        ) {
            $mail = (new KeywordValuePurchase($event->user, $event->transaction))->onQueue('medium');

            Mail::to($event->user)->queue($mail);
        }
    }
}
