<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Mail\UserWelcome;

class SendMailWelcome
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
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $mail = (new UserWelcome($event->user))->onQueue('medium');
        
        Mail::to($event->user)->queue($mail);
    }
}
