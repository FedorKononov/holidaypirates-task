<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    protected $table = 'user_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'code'];

    /**
     * Many2Many connection with permissions
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\User\Permission', Permission::$group_pivot_table);
    }
}
