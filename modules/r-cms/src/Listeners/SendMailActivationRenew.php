<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Events\UserActivationRenew;
use RSolution\RCms\Mail\ActivationRenew;

class SendMailActivationRenew implements ShouldQueue
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
     * @param  RSolution\RCms\Events\UserActivationRenew  $event
     * @return void
     */
    public function handle(UserActivationRenew $event)
    {
        $mail = (new ActivationRenew($event->user, $event->transaction))->onQueue('medium');
       
        Mail::to($event->user)->queue($mail);
    }
}
