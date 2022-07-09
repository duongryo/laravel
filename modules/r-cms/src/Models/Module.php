<?php

namespace RSolution\RCms\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'tbl_r_cms_module';

    protected $fillable = [
        'module', 'type'
    ];

    public function limits()
    {
        return $this->hasMany(Limit::class);
    }

    public function logs()
    {
        return $this->hasMany(UserLog::class, 'module', 'module');
    }
}
