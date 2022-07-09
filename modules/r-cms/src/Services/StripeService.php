<?php

namespace RSolution\RCms\Services;

use Carbon\Carbon;
use RSolution\RCms\Repositories\ConfigRepository;
use Stripe\BillingPortal\Session as BillingPortalSession;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Stripe\Plan;
use Stripe\Product;
use Stripe\PromotionCode;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Subscription;

class StripeService
{
    const MODE_SUBSCRIPTION = 'subscription';
    const MODE_PAYMENT = 'payment';
    const MODE_ADDON = 'addon';
    const STATUS_PAID = 'paid';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_PAST_DUE = 'past_due';

    private $key;
    private $stripe;

    public function __construct()
    {
        $this->loadConfiguration();
        $this->buildStripeService();
    }

    private function loadConfiguration()
    {
        $configuration = (new ConfigRepository)->findByKey('subscription');
        if ($configuration) {
            $this->key = $configuration->value['key'];
        }
    }

    public function buildStripeService()
    {
        $this->stripe = new Stripe;
        $this->stripe->setApiKey($this->key);
        $this->stripeClient = new StripeClient($this->key);
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function createSession(
        $customerId,
        string $planId,
        string $successUrl,
        string $cancelUrl = null,
        int $quantity = 1,
        $mode = self::MODE_SUBSCRIPTION,
        bool $allowCoupon = false

    ) {
        try {
            $data = [
                "success_url" => $successUrl,
                "cancel_url" => $cancelUrl ? $cancelUrl : env('APP_URL'),
                "payment_method_types" => ["card"],
                "line_items" => [
                    [
                        "price" => $planId,
                        "quantity" => $quantity,
                    ],
                ],
                "mode" => $mode,
                "allow_promotion_codes" => $allowCoupon
            ];

            if ($customerId) {
                $data["customer"] = $customerId;
            }
            return (new Session())->create($data);
        } catch (\Exception $e) {
        }
    }

    public function retrieveSession(string $sessionId, array $expand = [
        "customer",
        "subscription",
        "subscription.customer",
        "subscription.latest_invoice",
        "subscription.plan"
    ])
    {
        return (new Session())->retrieve([
            "id" => $sessionId,
            "expand" => $expand
        ]);
    }

    public function createCustomer($email)
    {
        return (new Customer())->create([
            "email" => $email,
        ]);
    }

    public function retrieveSubscription($subscriptionId, array $expand = [
        "customer",
        "latest_invoice",
        "plan"
    ])
    {
        return (new Subscription())->retrieve([
            "id" => $subscriptionId,
            "expand" => $expand
        ]);
    }


    /**
     * Format stripe amount
     *
     * @param integer $value
     * @return integer
     */
    public function formatAmount(int $value, $round = true)
    {
        return $round ? round($value / 100) : round($value / 100, 2);
    }

    public function upgradeSubscription($subscriptionId, $planId, int $quantity = 1)
    {
        $subscription = $this->retrieveSubscription($subscriptionId);
        if ($subscription)
            return (new Subscription())->update(
                $subscriptionId,
                [
                    'proration_behavior' => 'always_invoice',
                    "items" => [
                        [
                            'id' => $subscription->items->data[0]->id,
                            "price" => $planId,
                        ],
                    ],
                ]
            );
    }

    public function retrieveCustomer($id,  array $expand = ["subscription"])
    {
        return (new Customer())->retrieve([
            "id" => $id,
            "expand" => $expand
        ]);
    }

    public function createBillingPortal($customerId, $returnUrl = null)
    {
        return (new BillingPortalSession())->create([
            "customer" => $customerId,
            "return_url" => $returnUrl ? $returnUrl : env('APP_URL'),
        ]);
    }

    public function retrievePaymentIntent(string $id, array $expand = ['invoice'])
    {
        return (new PaymentIntent())->retrieve([
            "id" => $id,
            "expand" => $expand
        ]);
    }

    public function createPromotionCode(
        string $coupon,
        string $code = null,
        string $customerId = null,
        string $expiredAt = null, //Unix timestamp
        int $maxRedemtion = null,
        bool $onlyFirstTimeOrder = false
    ) {
        return (new PromotionCode())->create([
            'coupon' => $coupon,
            'code' => $code,
            'customer' => $customerId,
            'expires_at' => $expiredAt,
            'max_redemptions' => $maxRedemtion,
            'restrictions' => [
                'first_time_transaction' => $onlyFirstTimeOrder
            ]
        ]);
    }

    public function retrievePromotionCode(string $id)
    {
        return (new PromotionCode())->retrieve([
            "id" => $id
        ]);
    }

    public function retrieveProduct(string $id)
    {
        return (new Product())->retrieve([
            "id" => $id,
        ]);
    }

    public function retrieveInvoice($invoiceId, array $expand = [
        'subscription',
        'customer'
    ])
    {
        return (new Invoice())->retrieve([
            "id" => $invoiceId,
            "expand" => $expand
        ]);
    }

    public function createSubscription($data)
    {
        return (new Subscription())->create($data);
    }

    public function updateSubscription(string $id, $data)
    {
        return (new Subscription())->update($id, $data);
    }

    public function retrivePromotionByCoupon(string $code)
    {
        $response = (new PromotionCode())->all([
            "code" => $code
        ]);

        return isset($response->data[0]) ? $response->data[0] : null;
    }
}
