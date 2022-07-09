<?php

namespace RSolution\RCms\Events;

use Illuminate\Queue\SerializesModels;
use RSolution\RCms\Models\Transaction;
use RSolution\RCms\Models\User;

class UserActivationRenew
{
    use SerializesModels;

    public $user;
    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Transaction $transaction
     */
    public function __construct(User $user, Transaction $transaction)
    {
        $this->user = $user;
        $this->transaction = $transaction;
    }
}
