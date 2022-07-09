<?php

namespace RSolution\RCms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use RSolution\RCms\Repositories\ConfigRepository;

class ActivationExpired extends Mailable implements ShouldQueue
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
        $this->subject = App::isLocale('vi') ? 'Thông báo hết hạn' : 'Your activation is expired';
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
        $freeTrial = (new ConfigRepository)->findByKey('free_trial');

        if (isset($freeTrial->value['plan_id']) && $freeTrial->value['plan_id'] == $this->planExpired) {

            $email         = 'mail_trial_expired';
            $this->subject = App::isLocale('vi') ? 'Thời gian gói dùng thử của bạn đã hết hạn' : 'Your Free Trial Period Has Expired';

        } else
            $email = 'activation_expired';

        return $this->view(View::exists("emails.$email")
            ? "emails.$email"
            : "rcms::emails.$email", ['user' => $this->user]);
    }
}
