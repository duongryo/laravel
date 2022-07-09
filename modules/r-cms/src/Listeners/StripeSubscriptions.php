<?php

namespace RSolution\RCms\Listeners;

use RSolution\RCms\Repositories\SubscriptionRepository;
use RSolution\RCms\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Events\SubscriptionDeleted;
use RSolution\RCms\Events\SubscriptionWebhook;
use RSolution\RCms\Repositories\InvoiceRepository;

class StripeSubscriptions implements ShouldQueue
{
    public $queue = 'high';
    private $transaction = null;
    private $event;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionWebhook  $event
     * @return void
     */
    public function handle(SubscriptionWebhook $event)
    {
        $this->event = $event->data;
        try {
            $this->checkWebhook();
        } catch (\Exception $e) {
            (new TelegramService)->sendLog("Event {$this->event->id} {$this->event->type} has error : {$e->getMessage()}");
        }
    }

    private function checkWebhook()
    {
        if ($this->event->type == 'invoice.payment_succeeded') {
            $invoice = $this->event->data->object;
            $this->transaction = (new InvoiceRepository)->checkInvoice($invoice->id);
        }

        if ($this->event->type == 'customer.subscription.deleted') {
            $subscriptionId = $this->event->data->object->id;
            //
            event(new SubscriptionDeleted($subscriptionId));
        }

        if ($this->event->type == 'customer.subscription.updated') {
            $subscription = $this->event->data->object;
            (new SubscriptionRepository)->updateCustomerSubscription(
                $subscription->customer,
                $subscription
            );
        }

        $this->sendLog();
    }

    private function sendLog()
    {
        $message = "Event type: " . $this->event->type;
        if (isset($this->event->data->object->customer)) {
            $customerId = $this->event->data->object->customer;
            $subscription = (new SubscriptionRepository)->findByCustomerId($customerId);
            $message = $message . "- Customer ID:" . $customerId . " - " . @$subscription->member->email;
        }
        if ($this->transaction)
            $message = $message . " .Transaction " . $this->transaction->id . " was created";
        else
            $message = $message . " .No transaction";

        (new TelegramService)->sendStripeLog($message);
    }
}
