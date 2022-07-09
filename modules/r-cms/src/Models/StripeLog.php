<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class StripeLog extends Model
{
    protected $table = 'tbl_r_cms_stripe_log';

    protected $fillable = [
        'user_id', 'session_id', 'mode', 'plan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(StripePlan::class, 'plan_id', 'code');
    }
}
