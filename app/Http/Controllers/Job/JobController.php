<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;

class JobController extends Controller
{
    public $view = 'job';
    public $uri  = 'job';

    /**
     * Constructor
     */
    public function __construct(JobRepository $jobs)
    {
        $this->jobs = $jobs;

        // auth check
        $this->middleware('auth');
    }

    /**
     * List of user's job offers
     */
    public function index(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => auth()->user()->jobs()->orderBy('created_at', 'desc')->paginate(),
            ]
        ])->render();
    }

    /**
     * Form for job offer creation
     */
    public function create(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.form',
        ])->render();
    }

    /**
     * Create job offer
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->jobs->validatorRules());

        if ($validator->passes())
        {
            $fields = [
                'title' => e($request->get('title')),
                'description' => e($request->get('description')),
            ];

            if ($this->jobs->create($fields))
            {
                return redirect()->to($this->uri);
            }

            $validator->errors()->add('model_create_fail', true);
        }

        return redirect()->to($this->uri .'/create')->withErrors($validator)->withInput();
    }
}
