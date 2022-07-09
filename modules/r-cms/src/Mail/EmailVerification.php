<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class EmailVerification extends MailMessage
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyUrl, $user)
    {
        //
        $this->subject = App::isLocale('vi') ? 'Kích hoạt tài khoản' :  config('app.name') . ': Account activation';

        $this->view(
            $this->getTemplate(),
            [
                'user' => $user,
                'verifyUrl' => $verifyUrl
            ]
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    private function getTemplate()
    {
        return View::exists('emails.mail_verify') ?
            'emails.mail_verify' :
            'rcms::emails.mail_verify';
    }
}
