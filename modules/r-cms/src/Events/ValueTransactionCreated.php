<?php

namespace RSolution\RCms\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use RSolution\RCms\Models\ValueTransaction;

class ValueTransactionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;
    public $user;
    public $sendMail;
    /**
     * Create a new event instance.
     *
     * @param ValueTransaction $transaction
     */
    public function __construct(ValueTransaction $transaction, Bool $sendMail = true)
    {
        $this->transaction = $transaction;
        $this->user = $transaction->member;
        $this->sendMail = $sendMail;
    }
}
