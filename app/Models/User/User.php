<?php

namespace App\Models\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    public static $group_pivot_table = 'user_group_user';

    /**
     * Container for loading permissions list
     */
    protected $cpermissions = [];

    /**
     * Many2Many connection with groups
     */
    public function groups()
    {
        return $this->BelongsToMany('App\Models\User\Group', self::$group_pivot_table);
    }

    /**
     * User's job offers
     */
    public function jobs()
    {
        return $this->HasMany('App\Models\Job\Job');
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'active_jobs'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Basic validator rules
     */
    public function validatorRules($id = null)
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:'. $this->table .',email'. ($id ? ','. $id : ''),
            'password' => ($id ? '' : 'required|') . 'confirmed|min:6',
        ];
    }

    /**
     * Determine user's permission to an access 
     *
     * @param  string
     * @return bool
     */
    public function can($access)
    {
        if ($this->isSuperAdmin())
            return true;

        $permissions = $this->permissions;

        if (empty($permissions))
            return false;

        return in_array($access, $permissions['permissions']);
    }

    /**
     * Determine user's admin group membership
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return (bool) $this->hasGroup('admins');
    }

    /**
     * Determine user's group membership
     *
     * @param  array|string
     * @return array|bool
     */
    public function hasGroup($groups)
    {
        $groups = (array) $groups;

        $permissions = $this->permissions;

        if (empty($permissions))
            return false;

        $has_groups = array_intersect($groups, $permissions['groups']);

        return !empty($has_groups) ? $has_groups : false;
    }

    /**
     * Loading user permissions
     *
     * @return array
     */
    public function getPermissionsAttribute()
    {
        // if property was already filled
        if (!empty($this->cpermissions))
            return $this->cpermissions;

        foreach ($this->groups as $group)
        {
            $this->cpermissions['groups'][$group->id] = $group->code;

            foreach ($group->permissions as $permission)
                $this->cpermissions['permissions'][$permission->id] = $permission->code;
        }

        return $this->cpermissions;
    }
}
