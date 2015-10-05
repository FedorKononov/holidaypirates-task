<?php

namespace App\Jobs\Event\Job;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
;
use App\Repositories\JobRepository;

class Create extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $jobs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JobRepository $jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function fire($job, $data)
    {
        $job_offer = $this->jobs->find($data['job_id']);

        if (empty($job_offer))
            throw new \Exception('Job not found');

        $job_offer->load('user');

        if (empty($job_offer->user))
            throw new \Exception('Job user not found');

        // User have no published job offers
        if (empty($job_offer->user->active_jobs))
        {
            // Move job to moderations status
            $job_offer->statusShift('moderation');

            // Moderator should be notified

            // User should be notified
        }


        else
        {
            // Move job_offer to active status
            $job_offer->statusShift('active');
        }

        $this->delete();
    }
}