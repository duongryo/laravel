<?php

namespace RSolution\RCms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'tbl_r_cms_transaction';

    protected $fillable = [
        'activation_id',
        'user_id',
        'manager_id',
        'price',
        'discount',
        'amount',
        'coupon',
        'type',
        'from_plan',
        'to_plan',
        'plan_time',
        'note',
        'status',
        'invoice_id',
        'subscription_id',
        'method',
        'price_code'
    ];

    protected $hidden = [
        'activation_id',
        'manager_id',
        'user_id',
        'subscription_id'
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function activation()
    {
        return $this->hasOne(Activation::class, 'id', 'activation_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }

    public function fromPlanInfo()
    {
        return $this->hasOne(Plan::class, 'id', 'from_plan');
    }

    public function toPlanInfo()
    {
        return $this->hasOne(Plan::class, 'id', 'to_plan');
    }

    public function root()
    {
        return $this->hasOne($this, 'subscription_id', 'subscription_id');
    }

    public function stripePlan()
    {
        return $this->hasOne(StripePlan::class, 'code', 'price_code');
    }
}
