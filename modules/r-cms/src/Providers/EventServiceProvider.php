<?php

namespace RSolution\RCms\Providers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RSolution\RCms\Events\SubscriptionDeleted;
use RSolution\RCms\Events\SubscriptionWebhook;
use RSolution\RCms\Events\TransactionCreated;
use RSolution\RCms\Events\TransactionDestroyed;
use RSolution\RCms\Events\UserActivationExpired;
use RSolution\RCms\Events\UserActivationRenew;
use RSolution\RCms\Events\UserActivationUpgrade;
use RSolution\RCms\Events\ValueTransactionCreated;
use RSolution\RCms\Listeners\CalculateKeywordValue;
use RSolution\RCms\Listeners\CancelSubscriptionPlan;
use RSolution\RCms\Listeners\CheckAffiliateRegister;
use RSolution\RCms\Listeners\CheckShareasaleReference;
use RSolution\RCms\Listeners\FreeTrial;
use RSolution\RCms\Listeners\SendMailActivationExpired;
use RSolution\RCms\Listeners\SendMailActivationRenew;
use RSolution\RCms\Listeners\SendMailActivationUpgrade;
use RSolution\RCms\Listeners\SendMailValuePurchase;
use RSolution\RCms\Listeners\SendMailWelcome;
use RSolution\RCms\Listeners\StripeSubscriptions;
use RSolution\RCms\Listeners\TransactionReport;
use RSolution\RCms\Listeners\ValueTransactionReport;
use RSolution\RCms\Listeners\VoidShareasaleTransaction;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserActivationExpired::class => [
            SendMailActivationExpired::class
        ],
        UserActivationUpgrade::class => [
            SendMailActivationUpgrade::class
        ],
        UserActivationRenew::class => [
            SendMailActivationRenew::class
        ],
        Verified::class =>  [
            FreeTrial::class,
            //SendMailWelcome::class,
            CheckAffiliateRegister::class
        ],
        TransactionCreated::class => [
            CheckShareasaleReference::class,
            TransactionReport::class
        ],
        TransactionDestroyed::class => [
            VoidShareasaleTransaction::class,
            TransactionReport::class
        ],
        SubscriptionWebhook::class => [
            StripeSubscriptions::class
        ],
        SubscriptionDeleted::class => [
            CancelSubscriptionPlan::class
        ],
        ValueTransactionCreated::class => [
            CalculateKeywordValue::class,
            SendMailValuePurchase::class,
            ValueTransactionReport::class
        ]
    ];
}
