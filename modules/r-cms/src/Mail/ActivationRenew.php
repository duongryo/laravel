<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class ActivationRenew extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    private $user;
    private $transaction;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $transaction)
    {
        //
        $this->subject = App::isLocale('vi') ? 'Cám ơn bạn đã ở lại với chúng tôi' : 'Congratulations on your purchase!';
        $this->user = $user;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (View::exists('emails.activation_renew'))
            return $this->view('emails.activation_renew', ['user' => $this->user, 'transaction' => $this->transaction]);
        else
            return $this->view('rcms::emails.activation_renew', ['user' => $this->user, 'transaction' => $this->transaction]);
    }
}
