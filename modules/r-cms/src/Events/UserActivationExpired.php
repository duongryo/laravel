<?php

namespace RSolution\RCms\Events;

use Illuminate\Queue\SerializesModels;
use RSolution\RCms\Models\User;

class UserActivationExpired
{
    use SerializesModels;

    public $user;
    public $planExpired;
    public $isRefund;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $planExpired, $isRefund = false)
    {
        $this->user = $user;
        $this->planExpired = $planExpired;
        $this->isRefund = $isRefund;
    }
}
