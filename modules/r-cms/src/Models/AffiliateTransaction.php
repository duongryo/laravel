<?php

namespace RSolution\RCms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AffiliateTransaction extends Model
{
    protected $table = 'tbl_r_cms_aff_transaction';

    protected $fillable = [
        'user_id', 'customer_id', 'action', 'transaction_id', 'credit', 'note', 'status'
    ];

    protected $hidden = [
        'user_id', 'customer_id', 'updated_at'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
