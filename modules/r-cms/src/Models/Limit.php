<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $table = 'tbl_r_cms_limit';

    protected $fillable = [
        'module_id', 'plan_id', 'limit',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
