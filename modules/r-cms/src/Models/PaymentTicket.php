<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTicket extends Model
{
    protected $table = 'tbl_r_cms_payment_ticket';

    protected $fillable = [
        'value', 'status', 'user_id'
    ];

    protected $casts = [
        'value' => 'array'
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
