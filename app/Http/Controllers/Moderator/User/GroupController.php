<?php

namespace App\Http\Controllers\Moderator\User;

use App\Http\Controllers\Moderator\ModeratorController;
use App\Models\User\Group;
use Illuminate\Http\Request;

class GroupController extends ModeratorController
{
    public $view = 'moderator.user.group';
    public $uri  = 'moderator/group';

    /**
     * Moderator list of groups
     */
    public function index(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => Group::orderBy('created_at', 'desc')->paginate(),
            ]
        ])->render();
    }

    /**
     * Form for group create
     */
    public function create(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.form',
        ])->render();
    }

    /**
     * Create group
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'code'  => 'required|alpha|max:255|unique:'. (new Group)->getTable(),
        ]);

        if ($validator->passes())
        {
            $fields = [
                'title' => e($request->get('title')),
                'code'  => $request->get('code'),
            ];

            if (Group::create($fields))
            {
                return redirect()->to($this->uri);
            }

            $validator->errors()->add('model_create_fail', true);
        }

        return redirect()->to($this->uri .'/create')->withErrors($validator)->withInput();
    }
}
