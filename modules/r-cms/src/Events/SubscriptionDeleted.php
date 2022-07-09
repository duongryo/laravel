<?php

namespace RSolution\RCms\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscriptionId;

    /**
     * Create a new event instance.
     *
     */
    public function __construct($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }
}
