<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $table = 'tbl_r_cms_daily_report';

    protected $fillable = [
        'date', 'usage', 'system'
    ];

    protected $casts = [
        'usage' => 'array',
        'system' => 'array'
    ];
}
