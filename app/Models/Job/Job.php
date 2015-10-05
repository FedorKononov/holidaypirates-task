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
        return $this->BelongsTo('App\Models\User\User');
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

    /**
     * Status shifting method
     */
    public function statusShift($status)
    {
        $moves_available = config('models.job.status_moves.'. $this->status, []);

        if (!in_array($status, $moves_available))
            return false;

        $this->status = $status;

        if ($this->save())
        {
            if (method_exists($this, 'onStatusMoved'. $status))
            {
                $this->{'onStatusMoved'. $status}();
            }

            return true;
        }

        return false;
    }

    /**
     * Callback for active status movement
     */
    protected function onStatusMovedActive()
    {
        $this->user->active_jobs++;
        $this->user->save();
    }
}
