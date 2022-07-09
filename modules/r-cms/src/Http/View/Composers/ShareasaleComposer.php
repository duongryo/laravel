<?php

namespace RSolution\RCms\Http\View\Composers;

use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use RSolution\RCms\Models\Transaction;
use RSolution\RCms\Repositories\ConfigRepository;
use RSolution\RCms\Repositories\StripePlanRepository;

class ShareasaleComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $configuration = (new ConfigRepository)->findByKey('shareasale');
        if ($configuration && $configuration->value['merchant_id']) {
            $transaction = Session::pull('transaction');

            $view->with([
                'merchantId' => $configuration->value['merchant_id'],
                'invoiceId' => $transaction ? $transaction->invoice_id : null,
                'amount' =>  $transaction ? $transaction->amount : null,
                'sku' => $transaction ? (new StripePlanRepository)->getSku($transaction->stripePlan) : null
            ]);
        }
    }
}
