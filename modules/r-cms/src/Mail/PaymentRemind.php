<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class PaymentRemind extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    private $user;
    private $planExpired;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $planExpired)
    {
        //
        $this->subject = App::isLocale('vi') ? 'Thông báo nhắc nhở thanh toán' : "We’ve run into a problem with your WriterZen $planExpired subscription!";
        $this->user = $user;
        $this->planExpired = $planExpired;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (View::exists('emails.mail_payment_remind'))
            return $this->view('emails.mail_payment_remind', ['user' => $this->user]);
        else
            return $this->view('rcms::emails.mail_payment_remind', ['user' => $this->user]);
    }
}
