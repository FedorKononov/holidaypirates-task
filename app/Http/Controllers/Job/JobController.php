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
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * List of job offers
     */
    public function index(Request $request)
    {
        $auth_user = auth()->user();

        $items = $this->jobs->where('status', config('models.job.statuses.active'));

        if ($auth_user)
            $items = $this->jobs->orWhere('user_id', $auth_user->id);

        $items = $items->with('user')->orderBy('created_at', 'desc');

        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => $items->paginate(),
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
