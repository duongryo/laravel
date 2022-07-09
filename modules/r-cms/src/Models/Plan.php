<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'tbl_r_cms_plan';

    protected $fillable = [
        'name', 'anual_price', 'monthly_price', 'credit', 'stripe_monthly_id', 'stripe_anual_id'
    ];
}
