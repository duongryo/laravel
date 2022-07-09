<?php

namespace RSolution\RCms\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RSolution\RCms\Services\TelegramService;

class SubscriptionWebhook
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
