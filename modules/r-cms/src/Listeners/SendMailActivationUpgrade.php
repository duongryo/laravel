<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Events\UserActivationUpgrade;
use RSolution\RCms\Mail\ActivationUpgrade;

class SendMailActivationUpgrade implements ShouldQueue
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
     * @param  RSolution\RCms\Events\UserActivationUpgrade  $event
     * @return void
     */
    public function handle(UserActivationUpgrade $event)
    {
        $method = $event->transaction->method;
        if ($method != 'free_trial' && $method != 'appsumo') {
            $mail = (new ActivationUpgrade($event->user, $event->transaction))->onQueue('medium');

            Mail::to($event->user)->queue($mail);
        }
    }
}
