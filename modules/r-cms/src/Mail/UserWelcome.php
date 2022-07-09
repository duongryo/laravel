<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class UserWelcome extends Mailable
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
        $this->subject = App::isLocale('vi') ? 'Chào mừng thành viên mới' : 'Welcome To ' . config('app.name') . ' -  Your One-Stop Content Solution';
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (View::exists('emails.mail_welcome'))
            return $this->view('emails.mail_welcome', ['user' => $this->user]);
        else
            return $this->view('rcms::emails.mail_welcome', ['user' => $this->user]);
    }
}
