<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'tbl_r_cms_user_log';

    protected $fillable = [
        'user_id', 'action', 'message', 'visibility', 'module', 'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
