<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class ValueTransaction extends Model
{
    protected $table = 'tbl_r_cms_keyword_value_transaction';

    protected $fillable = [
        'user_id',
        'manager_id',
        'keyword_value',
        'price',
        'discount',
        'amount',
        'method',
        'invoice_id',
        'note',
        'status',
        'content_value'
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
