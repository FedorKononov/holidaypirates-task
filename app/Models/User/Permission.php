<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = 'user_permission';

    public static $group_pivot_table = 'user_group_permission';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'code'];

    /**
     * Many2Many connection with groups
     */
    public function groups()
    {
        return $this->belongsToMany('App\Models\User\Group', self::$group_pivot_table);
    }

}