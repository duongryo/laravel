<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\AddonTransaction;
use RSolution\RCms\Services\TelegramService;

class AddonTransactionRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return AddonTransaction::class;
    }

    public function findByInvoiceId($addon, $invoiceId)
    {
        return $this->model
            ->where('addon', $addon)
            ->where('invoice_id', $invoiceId)
            ->first();
    }

    /**
     * Check and create transaction
     *
     * @param [type] $invoiceId
     * @param [type] $data (object)['addon'=>'addon', 'quantity'=> 1, ]
     * @return void
     */
    public function createTransaction($invoice, $data)
    {
        if (
            empty($this->findByInvoiceId($data->addon, $invoice->id))
        ) {
            $rcmsSubscription = (new SubscriptionRepository)->findByCustomerId($invoice->customer->id);

            $this->create([
                'user_id' => $rcmsSubscription->user_id,
                'addon' => $data->addon,
                'price' => $data->price,
                'quantity' => $data->quantity,
                'discount' => $data->discount,
                'amount' => $data->amount,
                'coupon' => '',
                'method' => 'stripe',
                'invoice_id' => $invoice->id,
                'subscription_id' => $rcmsSubscription->subscription_id,
                'note' => 'Stripe automation: ' . $data->note
            ]);

            $this->sendReport($rcmsSubscription, $data);
        };
    }

    private function sendReport($rcmsSubscription, $data)
    {
        (new TelegramService)->sendTransactionMessage(
            'Admin',
            $rcmsSubscription->user->email,
            'upgrade',
            ucfirst(str_replace("_", " ", $data->addon)) . " addon",
            $rcmsSubscription->interval == SubscriptionRepository::INTERVAL_MONTH ? 30 : 365,
            $data->amount,
            'Stripe automation: ' . $data->note
        );
    }
}
