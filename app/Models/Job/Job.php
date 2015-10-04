<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * Creator of job offer
     */
    public function user()
    {
        return $this->HasOne('App\Models\User\User');
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'status'];

    /**
     * Basic validator rules
     */
    public function validatorRules($id = null)
    {
        return [
            
        ];
    }
}
