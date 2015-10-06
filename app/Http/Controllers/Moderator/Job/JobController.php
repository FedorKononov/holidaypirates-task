<?php

namespace App\Http\Controllers\Moderator\Job;

use App\Http\Controllers\Moderator\ModeratorController;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;

class JobController extends ModeratorController
{
    public $view = 'moderator.job';
    public $uri  = 'moderator/job';

    /**
     * Constructor
     */
    public function __construct(JobRepository $jobs)
    {
        $this->jobs = $jobs;

        parent::__construct();
    }

    /**
     * Moderator list of job offers
     */
    public function index(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => $this->jobs->with('user')->orderBy('created_at', 'desc')->paginate(),
            ]
        ])->render();
    }

    /**
     * Approve or Reject job offer
     */
    public function statusShift($id, $status, Request $request)
    {
        $validator = \Validator::make(['id' => $id, 'status' => $status], [
            'id' => 'required|integer',
            'status' => 'required|in:active,rejected'
        ]);

        if ($validator->passes())
        {
            $job = $this->jobs->find($id);

            if (!empty($job))
            {
                $job->statusShift($status);
            }
        }

        return redirect()->to($this->uri);
    }
}
