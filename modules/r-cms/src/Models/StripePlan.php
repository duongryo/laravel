<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    protected $table = 'tbl_r_cms_stripe_plan';

    protected $fillable = [
        'plan_id', 'code', 'keyword_value', 'content_value', 'type', 'addon'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
