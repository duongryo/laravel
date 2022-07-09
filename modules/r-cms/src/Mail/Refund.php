<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class Refund extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->subject = App::isLocale('vi') ? 'Thông báo hoàn tiền' : 'Your refund inquiry has been updated!';
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (View::exists('emails.mail_refund'))
            return $this->view('emails.mail_refund', ['user' => $this->user]);
        else
            return $this->view('rcms::emails.mail_refund', ['user' => $this->user]);
    }
}
