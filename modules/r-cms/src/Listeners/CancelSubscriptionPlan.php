<?php

namespace RSolution\RCms\Listeners;

use Carbon\Carbon;
use RSolution\RCms\Repositories\SubscriptionRepository;
use RSolution\RCms\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Events\SubscriptionDeleted;
use RSolution\RCms\Repositories\TransactionRepository;
use RSolution\RCms\Services\StripeService;

class CancelSubscriptionPlan implements ShouldQueue
{
    public $queue = 'high';
    private $subscriptionId;
    private $subscription;

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
     * @param  SubscriptionDeleted  $event
     * @return void
     */
    public function handle(SubscriptionDeleted $event)
    {
        $this->subscriptionId = $event->subscriptionId;

        $this->subscription = (new StripeService)->retrieveSubscription($this->subscriptionId);

        $this->cancelSubscription();
    }

    private function cancelSubscription()
    {
        $subscriptionRepository = new SubscriptionRepository;

        $rcmsSubscription = $subscriptionRepository->updateCustomerSubscription(
            $this->subscription->customer->id,
            $this->subscription
        );

        //Cancel the current activation
        $transaction = $rcmsSubscription->transactions()->latest()->first();
        if ($transaction->activation_id == $rcmsSubscription->user->activation->id) //
            (new TransactionRepository)->destroy($transaction->id);

        //
        (new TelegramService)->sendStripeLog(
            "Stripe subscription has been cancelled: {$rcmsSubscription->user->email}"
        );
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Exception $e)
    {
        //
        (new TelegramService)->sendStripeLog(
            "Stripe subscription cancel error: {$this->subscription->customer} - {$e->getMessage()}"
        );
    }
}
