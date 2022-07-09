<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class KeywordValuePurchase extends Mailable 
//implements ShouldQueue
{
    const MAIL_TEMPLATE = 'keyword_value_purchase';

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
        $this->subject = App::isLocale('vi') ? 'Thông báo' : 'Congratulations on your purchase!';
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
        if (View::exists('emails.' . self::MAIL_TEMPLATE))
            return $this->view('emails.' . self::MAIL_TEMPLATE, ['user' => $this->user, 'transaction' => $this->transaction]);
        else
            return $this->view('rcms::emails.' . self::MAIL_TEMPLATE, ['user' => $this->user, 'transaction' => $this->transaction]);
    }
}
