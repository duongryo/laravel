<?php

namespace RSolution\RCms\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use RSolution\RCms\Mail\PasswordReset;

class ResetPasswordNotification extends ResetPassword 
{
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $mail = (new PasswordReset($url));

        return $mail;
    }
}
