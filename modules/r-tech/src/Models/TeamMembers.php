<?php 

namespace RTech\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMembers extends Model
{
    /**
     * @var string 
     */
    protected $table = 'tbl_r_tech_team_members';

    /**
     * @var array 
     */
    protected $fillable = [
        'name',
        'images',
        'description',
        'position',
        'display_order',
        'status',
        'created_at',
        'updated_at',
    ];
}