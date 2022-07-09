<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    protected $table = 'tbl_r_cms_activation';

    protected $fillable = [
        'user_id', 'plan_id', 'status', 'expiration_date'
    ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'activation_id', 'id');
    }
}
