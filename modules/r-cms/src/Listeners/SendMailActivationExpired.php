<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Events\UserActivationExpired;
use RSolution\RCms\Mail\ActivationExpired;
use RSolution\RCms\Mail\PaymentRemind;
use RSolution\RCms\Mail\Refund;
use RSolution\RCms\Repositories\PlanRepository;

class SendMailActivationExpired implements ShouldQueue
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
     * @param  RSolution\RCms\Events\UserActivationExpired  $event
     * @return void
     */
    public function handle(UserActivationExpired $event)
    {
        if ($event->isRefund) {
            //refund action
            $mail = (new Refund($event->user))->onQueue('medium');
            Mail::to($event->user)->queue($mail);
        } else {
            $plan = (new PlanRepository())->find($event->planExpired);
            if (isset($plan->name) && $plan->name != 'Trial') {
                //send mail Expired
                $mail = (new ActivationExpired($event->user, $event->planExpired))->onQueue('medium');
                Mail::to($event->user)->queue($mail);

                //Send mail remind
                $mail = (new PaymentRemind($event->user, $plan->name))->onQueue('medium');
                Mail::to($event->user)->queue($mail);
            }
        }
    }
}
