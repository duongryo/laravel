<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'tbl_r_cms_config';

    protected $fillable = [
        'key', 'value'
    ];

    // public function getValueAttribute($value)
    // {
    //     return json_decode($value);
    // }

    protected $casts = [
        'value' => 'array'
    ];
}
