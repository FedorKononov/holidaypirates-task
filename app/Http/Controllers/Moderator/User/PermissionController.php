<?php

namespace App\Http\Controllers\Moderator\User;

use App\Http\Controllers\Moderator\ModeratorController;
use App\Models\User\Permission;
use Illuminate\Http\Request;

class PermissionController extends ModeratorController
{
    public $view = 'moderator.user.permission';
    public $uri  = 'moderator/permission';

    /**
     * Moderator list of permissions
     */
    public function index(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => Permission::orderBy('created_at', 'desc')->paginate(),
            ]
        ])->render();
    }

    /**
     * Form for Permission create
     */
    public function create(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.form',
        ])->render();
    }

    /**
     * Create Permission
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'code'  => 'required|regex:/^[@._a-zA-Z]+$/|max:255|unique:'. (new Permission)->getTable(),
        ]);

        if ($validator->passes())
        {
            $fields = [
                'title' => e($request->get('title')),
                'code'  => $request->get('code'),
            ];

            if (Permission::create($fields))
            {
                return redirect()->to($this->uri);
            }

            $validator->errors()->add('model_create_fail', true);
        }

        return redirect()->to($this->uri .'/create')->withErrors($validator)->withInput();
    }
}
