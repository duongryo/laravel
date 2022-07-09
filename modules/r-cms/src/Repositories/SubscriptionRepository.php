<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use RSolution\RCms\Models\Subscription;
use RSolution\RCms\Services\StripeService;

class SubscriptionRepository extends EloquentRepository
{
    const STATUS_LIVE = 1;
    const STATUS_CANCELLED = 0;
    const TYPE_UPGRADE = 'upgrade';
    const TYPE_RENEW = 'renew';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_YEAR = 'year';

    private $cancelUrl;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Subscription::class;
    }

    public function createHostedPage($user, $planId, $cancelUrl = null)
    {
        $plan = (new StripePlanRepository)->findByCode($planId);

        if ($plan) {
            $this->cancelUrl = $cancelUrl;
            if ($plan->type == StripePlanRepository::TYPE_VALUE) {
                return $this->createHostedPagePayment($user, $planId);
            }
            if (
                $plan->type == StripePlanRepository::TYPE_MONTHLY ||
                $plan->type == StripePlanRepository::TYPE_ANUAL
            )
                return $this->createHostedPageSubscription($user, $planId);
        }
    }

    private function createHostedPagePayment($user, $planId)
    {
        $stripeService = (new StripeService);
        if (!$user->subscription) {
            //If user doesn't have a customer Id -> create new 
            $customer = $stripeService->createCustomer($user->email);
            $subscription = (new SubscriptionRepository)->create([
                'user_id' => $user->id,
                'customer_id' => $customer->id
            ]);

            return $this->createStripeSession($user, $subscription->customer_id, $planId, StripeService::MODE_PAYMENT);
        } else
            return $this->createStripeSession($user, $user->subscription->customer_id, $planId, StripeService::MODE_PAYMENT);
    }

    private function createHostedPageSubscription($user, $planId)
    {
        $stripeService = (new StripeService);
        if (!$user->subscription) {
            //If user doesn't have a customer Id -> create new 
            $customer = $stripeService->createCustomer($user->email);
            (new SubscriptionRepository)->create([
                'user_id' => $user->id,
                'customer_id' => $customer->id
            ]);

            return $this->createStripeSession($user, $customer->id, $planId);
        } else {
            if ($user->subscription->subscription_id) {
                $subscription = $stripeService->retrieveSubscription($user->subscription->subscription_id);

                if ($subscription->status == StripeService::STATUS_ACTIVE) {
                    //Change subscription

                } else {
                    //Create new subscription 
                    return $this->createStripeSession($user, $user->subscription->customer_id, $planId);
                }
            } else
                return $this->createStripeSession($user, $user->subscription->customer_id, $planId);
        }
    }

    public function createHostedPageAddon($user, $planId)
    {
        $stripeService = (new StripeService);
        $mode = StripeService::MODE_ADDON;
        if (!$user->subscription) {
            //If user doesn't have a customer Id -> create new 
            $customer = $stripeService->createCustomer($user->email);
            (new SubscriptionRepository)->create([
                'user_id' => $user->id,
                'customer_id' => $customer->id
            ]);

            return $this->createStripeSession($user, $customer->id, $planId, $mode);
        } else {
            if ($user->subscription->subscription_id) {
                $subscription = $stripeService->retrieveSubscription($user->subscription->subscription_id);

                if ($subscription->status == StripeService::STATUS_ACTIVE) {
                    //Add addon into subscription

                } else {
                    //Create new subscription 
                    return $this->createStripeSession($user, $user->subscription->customer_id, $planId, $mode);
                }
            } else
                return $this->createStripeSession($user, $user->subscription->customer_id, $planId, $mode);
        }
    }

    private function createStripeSession(
        $user,
        $customerId,
        $planId,
        $mode = StripeService::MODE_SUBSCRIPTION
    ) {
        $stripeService = (new StripeService);

        $stripeLog = (new StripeLogRepository)->create([
            'user_id' => $user->id,
            'mode' => $mode,
            'plan_id' => $planId
        ]);

        $sessionMode = $mode == StripeService::MODE_ADDON ? StripeService::MODE_SUBSCRIPTION : $mode;

        $session = $stripeService->createSession(
            $customerId,
            $planId,
            route('rcms.api.subscription.callback') . '?id=' . $stripeLog->id,
            $this->cancelUrl,
            1,
            $sessionMode,
            true
        );

        if ($session) {
            $stripeLog->session_id = $session->id;
            $stripeLog->save();
            return [
                'status' => 'success',
                'type' => 'new_subscription',
                'session_id' => $session->id
            ];
        } else {
            $stripeLog->delete();
            return [
                'status' => 'error',
                'message' => 'can not create stripe session',
            ];
        }
    }

    public function callback($id)
    {
        $stripeLog = (new StripeLogRepository)->find($id);
        if ($stripeLog) {
            $stripeService = (new StripeService);
            $session = $stripeService->retrieveSession($stripeLog->session_id);
            if (
                $session &&
                $session->payment_status == StripeService::STATUS_PAID
            ) {
                //Payment Subscription
                if ($stripeLog->mode == StripeService::MODE_SUBSCRIPTION) {
                    $transaction = (new InvoiceRepository)->checkInvoice($session->subscription->latest_invoice->id);

                    if ($transaction) {
                        return [
                            'transaction' => $transaction,
                            'aff' => true
                        ];
                    }
                }

                //Payment Transaction
                if ($stripeLog->mode == StripeService::MODE_PAYMENT) {
                    $transaction = (new ValueTransactionRepository)->createTransaction(
                        (new UserRepository)->getAdmin(),
                        [
                            'user_id' => $stripeLog->user_id,
                            'content_value' => $stripeLog->plan->content_value,
                            'keyword_value' => $stripeLog->plan->keyword_value,
                            'price' => $stripeService->formatAmount($session->amount_total),
                            'amount' => $stripeService->formatAmount($session->amount_total),
                            'method' => 'stripe',
                            'invoice_id' => $session->payment_intent,
                            'note' => 'Stripe automation ' . $stripeLog->plan->name,
                        ]
                    );
                    if ($transaction) {
                        return [
                            'transaction' => $transaction,
                            'aff' => false
                        ];
                    }
                }

                //Payment Addon
                if ($stripeLog->mode == StripeService::MODE_ADDON) {
                    (new InvoiceRepository)->checkInvoice($session->subscription->latest_invoice->id);
                    return [
                        'aff' => false
                    ];
                }
            }
        }
    }

    public function createBillingPortal($user)
    {
        if (!empty($user->subscription->customer_id))
            $portal =  (new StripeService)->createBillingPortal(
                $user->subscription->customer_id
            );
        return $portal ? $portal->url : null;
    }

    public function findByCustomerId($customerId)
    {
        return $this->model->where('customer_id', $customerId)->first();
    }

    public function getCustomerByCustomerId($customerId)
    {
        $sub = $this->model->where('customer_id', $customerId)->first();
        return $sub ? $sub->user : null;
    }

    public function eventUpgradeCredit()
    {
    }

    public function findBySubscriptionId($subscriptionId)
    {
        return $this->model->where('subscription_id', $subscriptionId)->first();
    }

    public function updateCustomerSubscription($customerId, $subscription)
    {
        $rcmsSubscription = $this->findByCustomerId($customerId);
        //
        $status = $subscription->status == StripeService::STATUS_ACTIVE
            ? self::STATUS_LIVE
            : self::STATUS_CANCELLED;
        $periodStart = Carbon::createFromTimestamp($subscription->current_period_start);
        $periodEnd = Carbon::createFromTimestamp($subscription->current_period_end);
        //

        $rcmsSubscription->subscription_id = $subscription->id;
        $rcmsSubscription->status = $status;
        $rcmsSubscription->billing_cycle_anchor = Carbon::createFromTimestamp($subscription->billing_cycle_anchor);
        $rcmsSubscription->current_period_start = $periodStart;
        $rcmsSubscription->current_period_end = $periodEnd;
        $rcmsSubscription->interval = $periodEnd->diffInDays($periodStart) > 60 ? self::INTERVAL_YEAR : self::INTERVAL_MONTH;
        $rcmsSubscription->cancel_at_period_end = $subscription->cancel_at_period_end;
        $rcmsSubscription->save();
        //
        (new AddonRepository)->updateAddons(
            $rcmsSubscription,
            $this->getSubscriptionAddons($subscription)
        );
        //
        return $rcmsSubscription;
    }

    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;
    }

    private function getSubscriptionAddons($subscription)
    {
        $stripePlans = (new StripePlanRepository())->getAll();
        //Get all items price ID;
        $addons = [];
        $items = $subscription->items->data;
        foreach ($items as $item) {
            $temp = $stripePlans->where('code', $item->price->id)->first();
            if (!empty($temp)) {
                if ($temp->type == StripePlanRepository::TYPE_ADDON) {
                    $addons[] = (object)[
                        'addon' => $temp->addon,
                        'quantity' => $item->quantity
                    ];
                }
            }
        }
        return $addons;
    }

    public function sheduleToCancel($user, $cancelAtPeriodEnd = true)
    {
        $rcmsSubscription = $user->subscription;
        if (
            $rcmsSubscription
            && $rcmsSubscription->subscription_id
            && $rcmsSubscription->status == self::STATUS_LIVE
        ) {
            $stripeService = (new StripeService);
            $subscription = $stripeService->updateSubscription($rcmsSubscription->subscription_id, [
                'cancel_at_period_end' => $cancelAtPeriodEnd
            ]);

            $rcmsSubscription->cancel_at_period_end = $subscription->cancel_at_period_end;
            $rcmsSubscription->save();
            return $rcmsSubscription;
        }
    }
}
