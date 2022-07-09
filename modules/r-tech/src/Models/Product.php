<?php 

namespace RTech\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var string 
     */
    protected $table = 'tbl_r_tech_product';

    /**
     * @var array 
     */
    protected $fillable = [
        'name',
        'label',
        'link',
        'logo',
        'images',
        'description',
        'display_order',
        'status',
        'created_at',
    ];

    public function getCreatedAtAttribute($date)
    {
        return date("d M Y", strtotime($date));
    }

}