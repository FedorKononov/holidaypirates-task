<?php

namespace App\Jobs\Event\Job;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\JobRepository;
use App\Repositories\UserRepository;
use App\Models\User\Group;
use Mail;

class Create extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $jobs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JobRepository $jobs, UserRepository $users)
    {
        $this->jobs = $jobs;
        $this->users = $users;
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

            // Moderators should be notified
            $moderators = Group::where('code', 'moderators')->first()->users()->take(20)->get();

            foreach ($moderators as $moderator)
            {
                Mail::send('emails.event.job.create.moderator', ['moderator' => $moderator, 'job' => $job_offer], function ($m) use ($moderator) {
                    $m->to($moderator->email, $moderator->name)->subject('New job offer for moderation');
                });
            }
        }
        else
        {
            // Move job_offer to active status
            $job_offer->statusShift('active');
        }

        // User should be notified
        Mail::send('emails.event.job.create.user', ['job' => $job_offer], function ($m) use ($job_offer) {
            $m->to($job_offer->user->email, $job_offer->user->name)->subject('New job offer from you');
        });

        $job->delete();
    }
}