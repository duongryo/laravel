<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class ZohoPlan extends Model
{
    protected $table = 'tbl_r_cms_zoho_plan';

    protected $fillable = [
        'plan_id', 'code'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
