<?php

namespace RSolution\RCms\Repositories;

use Carbon\Carbon;
use RSolution\RCms\Services\StripeService;
use RSolution\RCms\Services\TelegramService;

class InvoiceRepository
{
    public function checkInvoice($invoiceId)
    {
        $stripeService = (new StripeService);
        $stripePlans = (new StripePlanRepository)->getAll();
        $invoice = $stripeService->retrieveInvoice($invoiceId);
        $rcmsSubscription = (new SubscriptionRepository)->updateCustomerSubscription(
            $invoice->customer->id,
            $invoice->subscription
        );

        foreach ($invoice->lines->data as $item) {
            $temp = $stripePlans->where('code', $item->price->id)->first();

            if (!empty($temp)) {
                if (
                    $temp->type == StripePlanRepository::TYPE_MONTHLY ||
                    $temp->type == StripePlanRepository::TYPE_ANUAL
                ) {
                    //Plan activation
                    if ($invoice->subscription->status == StripeService::STATUS_ACTIVE) //
                        $transaction = $this->createTransactionActivation(
                            $invoice,
                            $item,
                            $rcmsSubscription
                        );
                } elseif ($temp->type == StripePlanRepository::TYPE_ADDON) {
                    //
                    $discount = $this->getDiscountAmount($item->discount_amounts);
                    $amount = $item->amount - $discount;
                    $price = $item->price->unit_amount;
                    //Addon activation
                    (new AddonTransactionRepository)->createTransaction($invoice, (object)[
                        'addon' => $temp->addon,
                        'quantity' => $item->quantity,
                        'amount' => $stripeService->formatAmount($amount, false),
                        'discount' => $stripeService->formatAmount($discount, false),
                        'price' =>  $stripeService->formatAmount($price, false),
                        'note' => $item->description
                    ]);
                }
            }
        }

        return isset($transaction) ? $transaction : null;
    }

    private function createTransactionActivation(
        $invoice,
        $subscriptionPlan,
        $rcmsSubscription
    ) {
        //Check if Invoice ID is valid ( The ID which does not have any transaction)
        if (
            !(new TransactionRepository)->findByInvoiceId($invoice->id)
        ) {
            //
            $type = $invoice->billing_reason == 'subscription_cycle' ?
                SubscriptionRepository::TYPE_RENEW :
                SubscriptionRepository::TYPE_UPGRADE;

            //Switch to Upgrade in case user's activation expired before renew
            if (
                $type == SubscriptionRepository::TYPE_RENEW &&
                !$rcmsSubscription->user->activation
            ) {
                $type = SubscriptionRepository::TYPE_UPGRADE;
            }

            $activation = $this->buildActivation(
                $invoice,
                $subscriptionPlan,
                $rcmsSubscription->user,
                $type
            );

            if ($activation) {
                $admin = (new UserRepository)->getAdmin();
                $transaction = $type == SubscriptionRepository::TYPE_UPGRADE
                    ? (new ActivationRepository)->upgrade($admin, $activation)  //
                    : (new ActivationRepository)->renew($admin, $activation);

                return $transaction;
            }
        }
    }

    private function buildActivation(
        $invoice,
        $subscriptionPlan,
        $user,
        $type
    ) {
        $subscription = $invoice->subscription;
        $nextBillingDate = Carbon::createFromTimestamp($subscription->current_period_end);
        $plan = (new StripePlanRepository)->findByCode($subscriptionPlan->plan->id);
        $planTime = $this->calculatePlanTime($user, $nextBillingDate, $type, $plan);
        $stripeService = (new StripeService);

        if ($planTime)
            return [
                'user_id' => $user->id,
                'amount' => $stripeService->formatAmount(
                    $subscriptionPlan->amount - $this->getDiscountAmount($subscriptionPlan->discount_amounts)
                ),
                'price' => $stripeService->formatAmount($subscriptionPlan->plan->amount),
                'from_plan' => $user->plan,
                'to_plan' => $plan->plan_id,
                'plan_time' => $planTime,
                'note' => 'Stripe subscription',
                'method' => 'stripe',
                'invoice_id' => $invoice->id,
                'subscription_id' => $subscription->id,
                'price_code' => $subscriptionPlan->plan->id,
                'coupon' => isset($invoice->discount) ?
                    $this->getCouponCode($invoice->discount) :
                    null
            ];
        else
            $this->errorMessage($user->email, 'Renew plan time = 0');
    }

    private function calculatePlanTime($user, $nextBillingDate, $type, $plan)
    {
        if ($type == SubscriptionRepository::TYPE_UPGRADE) {
            return $nextBillingDate
                ->startOfDay()
                ->diffInDays(now()->startOfDay());
        } else {
            if ($user->activation->plan_id == $plan->plan_id) {
                $expirationDate = Carbon::parse($user->activation->expiration_date);
                if ($expirationDate < $nextBillingDate)
                    return $nextBillingDate->startOfDay()->diffInDays($expirationDate->startOfDay());
                else
                    $this->errorMessage($user->email, 'Invalid next billing date');
            } else {
                $this->errorMessage($user->email, 'Renew plan not match');
            }
        }
    }

    private function getCouponCode($discount)
    {
        $data = (new StripeService)->retrievePromotionCode($discount->promotion_code);
        return isset($data) && isset($data->code) ? $data->code : null;
    }

    private function getDiscountAmount($discountAmounts)
    {
        $temp = collect($discountAmounts);
        return $temp->sum('amount');
    }

    private function errorMessage($email, $code = null)
    {
        $message = 'Fail ' . $code;
        (new TelegramService)->sendStripeLog($message . ' : ' . $email);
        abort(500);
    }

    public function retrieveInvoice($invoiceId)
    {
        return (new StripeService)->retrieveInvoice($invoiceId, []);
    }
}
