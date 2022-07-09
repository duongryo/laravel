<?php

namespace RSolution\RCms\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use RSolution\RCms\Repositories\AffiliateTransactionRepository;

class CheckAffiliateRegister implements ShouldQueue
{
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
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        if ($event->user->ref_id) {
            $affiliateTransactionRepository = new AffiliateTransactionRepository;
            $transaction = $affiliateTransactionRepository->create([
                'user_id' => $event->user->ref_id,
                'customer_id' => $event->user->id,
                'action' => AffiliateTransactionRepository::ACTION_REGISTER,
                'credit' => $affiliateTransactionRepository->getRegisterCredit()
            ]);
            //Pay this transaction
            $affiliateTransactionRepository->pay($transaction->id);
        }
    }
}
