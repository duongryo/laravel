<?php

namespace RSolution\RCms\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RSolution\RCms\Models\Transaction;

class TransactionDestroyed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
