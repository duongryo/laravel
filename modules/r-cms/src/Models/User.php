<?php

namespace RSolution\RCms\Models;

use App\Models\User as AppUser;
use RSolution\RCms\Notifications\EmailVerificationNotification;
use RSolution\RCms\Notifications\ResetPasswordNotification;

class User extends AppUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $rcmsFillable = [
        'provider',
        'provider_id',
        'last_name',
        'birth',
        'gender',
        'phone',
        'avatar',
        'ref_id',
        'language',
        'status',
        'keyword_value',
        'config'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $rcmsHidden = [
        'updated_at', 'ref_id', 'provider', 'provider_id'
    ];


    protected $rcmsCasts = [
        'config' => 'object'
    ];

    public function __construct(array $attributes = [])
    {
        $this->fillable = array_merge(
            parent::getFillable(),
            $this->rcmsFillable
        );

        $this->hidden = array_merge(
            parent::getHidden(),
            $this->rcmsHidden
        );


        $this->casts = array_merge(
            parent::getCasts(),
            $this->rcmsCasts
        );

        parent::__construct($attributes);
    }

    public function activation()
    {
        return $this->hasOne(Activation::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    public function agent()
    {
        return $this->hasOne($this, 'id', 'ref_id');
    }

    public function referrals()
    {
        return $this->hasMany($this, 'ref_id', 'id');
    }

    public function planInfo()
    {
        return $this->hasOne(Plan::class, 'id', 'plan');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function valueTransactions()
    {
        return $this->hasMany(ValueTransaction::class, 'user_id', 'id');
    }
}
