<?php

namespace App\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Event;

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
     * Regestring events callbacks
     */
    public static function boot()
    {
        self::created(function ($model)
        {
            /**
             * Firing event.job.create queue job
             */
            Event::fire('event.job.create', ['param' => [
                'job_id' => $model->id,
            ]]);
        });

        self::creating(function ($model)
        {
            /**
             * Setting some initial fields
             */
            $model->user_id = auth()->user()->id;
            $model->status  = config('models.job.statuses.pending');
        });

        parent::boot();
    }

    /**
     * Basic validator rules
     */
    public function validatorRules($id = null)
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:1024',
        ];
    }
}
