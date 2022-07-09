<?php

namespace RSolution\RCms\Mail;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class PasswordReset extends MailMessage
{
    use SerializesModels;

    private $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        //
        $this->subject = App::isLocale('vi') ? 'Khôi phục mật khẩu' : 'Password reset';

        $this->view(
            $this->getTemplate(),
            [
                'url' => $url
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
        return View::exists('emails.mail_reset_pw') ?
            'emails.mail_reset_pw' :
            'rcms::emails.mail_reset_pw';
    }
}
