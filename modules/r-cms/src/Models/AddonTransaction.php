<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class AddonTransaction extends Model
{
    protected $table = 'tbl_r_cms_addon_transaction';

    protected $fillable = [
        'user_id',
        'addon',
        'price',
        'quantity',
        'discount',
        'amount',
        'coupon',
        'method',
        'invoice_id',
        'subscription_id',
        'note',
        'status'
    ];
}
