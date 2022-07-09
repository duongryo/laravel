<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $table = 'tbl_r_cms_addon';

    protected $fillable = [
        'subscription_id', 'addon', 'quantity'
    ];
}
