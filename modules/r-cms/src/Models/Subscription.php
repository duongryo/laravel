<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'tbl_r_cms_subscription';

    protected $fillable = [
        'user_id',
        'customer_id', //Stripe customer ID
        'subscription_id', // Stripe subscription ID
        'status',
        'current_period_start',
        'current_period_end',
        'billing_cycle_anchor',
        'interval'
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'subscription_id', 'subscription_id');
    }

    public function addons()
    {
        return $this->hasMany(Addon::class, 'subscription_id', 'id');
    }
}
