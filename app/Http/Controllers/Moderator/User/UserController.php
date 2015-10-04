<?php

namespace App\Http\Controllers\Moderator\User;

use App\Http\Controllers\Moderator\ModeratorController;
use App\Repositories\UserRepository;
use App\Models\User\Group;
use Illuminate\Http\Request;

class UserController extends ModeratorController
{
    public $view = 'moderator.user.user';
    public $uri  = 'moderator/user';

    /**
     * Constructor
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        parent::__construct();
    }

    /**
     * Moderator list of users
     */
    public function index(Request $request)
    {
        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.index',
            'vars' => [
                'items' => $this->users->orderBy('created_at', 'desc')->paginate(),
            ]
        ])->render();
    }

    /**
     * Form for user editing
     */
    public function edit($uid, Request $request)
    {
        $user = $this->users->find($uid);

        if (!$user)
            return abort('404');

        $user->load(['groups']);

        return view()->make($this->baseview)->with([
            'content_template' => $this->view .'.form',
            'vars' => [
                'user'   => $user,
                'groups' => Group::all(),
            ]
        ])->render();
    }

    /**
     * Updating user
     */
    public function update($uid, Request $request)
    {
        $validator = \Validator::make($request->all(), $this->users->getModel()->validatorRules($request->get('id')));

        if ($validator->passes())
        {
            $groups = Group::whereIn('id', $request->get('groups'))->lists('id')->toArray();

            $user = $this->users->find($request->get('id'));

            if (empty($user))
                $validator->errors()->add('user_not_found', true);

            if ( ! $validator->errors()->count())
            {
                $fields = [
                    'email' => $request->get('email'),
                    'name'  => e($request->get('name')),
                ];

                if ($request->get('password'))
                    $fields['password'] = $request->get('password');

                $user->fill($fields);

                if ($user->save())
                {
                    $user->groups()->sync($groups);

                    return redirect()->to($this->uri);
                }

                $validator->errors()->add('model_edit_fail', true);
            }
        }

        return redirect()->to($this->uri .'/'. $request->get('id') .'/edit')->withErrors($validator)->withInput();
    }
}
