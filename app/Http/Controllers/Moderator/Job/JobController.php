<?php

namespace App\Http\Controllers\Moderator\Job;

use App\Http\Controllers\Moderator\ModeratorController;
use Illuminate\Http\Request;

class JobController extends ModeratorController
{
    public $view = 'moderator.job';
    public $uri  = 'moderator/job';

    /**
     * Method: GET
     *
     * Moderator list of job offers
     */
    public function index(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => [],
            ]
        ])->render();
    }
}
