<?php

namespace RSolution\RCms\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Mail\EmailVerification;

class EmailVerificationNotification extends VerifyEmail //implements ShouldQueue
{
    //use Queueable;

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $mail = (new EmailVerification($verificationUrl, $notifiable));

        return $mail;
    }
}
