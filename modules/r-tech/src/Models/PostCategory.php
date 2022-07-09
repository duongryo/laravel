<?php 

namespace RTech\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    /**
     * @var string 
     */
    protected $table = 'tbl_r_tech_post_category';

    /**
     * @var array 
     */
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];
}