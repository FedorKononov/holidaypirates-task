<?php

namespace App\Jobs\Event\Job;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    public function handle()
    {
        dd(123);
        
        $this->delete();
    }
}