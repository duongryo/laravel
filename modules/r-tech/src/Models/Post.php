<?php 

namespace RTech\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @var string 
     */
    protected $table = 'tbl_r_tech_post';

    /**
     * @var array 
     */
    protected $fillable = [
        'name',
        'user_id',
        'content',
        'images',
        'meta_desc',
        'slug',
        'status',
        'created_at',
        'tag'
    ];

    public function getCreatedAtAttribute($date)
    {
        return date("d M Y", strtotime($date));
    }

}