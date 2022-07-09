<?php

namespace RSolution\RCms\Repositories;

use Illuminate\Support\Facades\URL;
use RSolution\RCms\Models\AffiliateTransaction;

class AffiliateTransactionRepository extends EloquentRepository
{
    const ACTION_REGISTER = 'register';
    const ACTION_PAID = 'paid';
    const ACTION_CANCEL = 'cancel';
    const STATUS_PAID = 1;
    const STATUS_PENDING = 0;

    public function getModel()
    {
        return AffiliateTransaction::class;
    }

    public function getRegisterCredit()
    {
        return 5;
    }

    /**
     * Pay transaction and Add credit to user by Transaction ID
     *
     * @param integer $id
     * @return void
     */

    public function pay(int $id)
    {
        $transaction = $this->find($id);
        if ($transaction) {
            (new UserRepository)->addCredit($transaction->user_id, $transaction->credit);
            $transaction->status = self::STATUS_PAID;
            $transaction->save();
        }
    }

    public function encryptCode($code)
    {
        return base64_encode($code);
    }

    public function decryptCode($code)
    {
        return base64_decode($code);
    }

    public function buildReffererLink($user)
    {
        return URL::to('/') . '/redirect?ref=' . $this->encryptCode($user->id);
    }

    public function getByUser(int $userId)
    {
        return $this->model
            ->with(['customer' => function ($query) {
                return $query->select('id', 'name', 'email')->get();
            }])->where('user_id', $userId)->get();
    }
}
