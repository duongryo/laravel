<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Events\ValueTransactionCreated;
use RSolution\RCms\Models\ValueTransaction;

class ValueTransactionRepository extends EloquentRepository
{
    const STATUS_PAID = 1;
    const STATUS_CANCELLED = 0;
    const TYPE_KEYWORD = 'keyword_value';
    const TYPE_CONTENT = 'content_value';
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return ValueTransaction::class;
    }

    /**
     * Create Transaction
     *
     * @param [type] $manager
     * @param [type] $data [            
     * 'user_id' => 'required',
     * 'keyword_value' => 'required',
     * 'content_value' => 'required',
     * 'price' => 'no required',
     * 'discount' => 'no required',
     * 'amount' => 'no required',
     * 'method' => 'no required',
     * 'invoice_id' => 'no required',
     * 'note' => string|no required ],
     * @return void
     */
    public function createTransaction($manager, $data, $sendMail = true)
    {
        if (isset($data['invoice_id'])) {
            if ($this->findByInvoiceId($data['invoice_id']))
                return null;
        }

        $transaction = $this->create(
            array_merge(
                [
                    'manager_id' => $manager->id,
                    'status' => self::STATUS_PAID
                ],
                $data
            )
        );

        event(new ValueTransactionCreated($transaction, $sendMail));

        return $transaction;
    }

    public function findByInvoiceId($id)
    {
        return $this->model->where('invoice_id', $id)->first();
    }
}
