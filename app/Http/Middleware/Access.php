<?php

namespace App\Http\Middleware;

use Closure, Route;
use Illuminate\Contracts\Auth\Guard;

class Access
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $this->auth->getUser()->can(Route::currentRouteAction()))
        {
            return abort(403);
        }

        return $next($request);
    }

}
