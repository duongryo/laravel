<?php 

namespace RTech\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    /**
     * @var string 
     */
    protected $table = 'tbl_r_tech_system_config';

    /**
     * @var array 
     */
    protected $fillable = [
        'type',
        'key_name',
        'field_name',
        'value'
    ];
}