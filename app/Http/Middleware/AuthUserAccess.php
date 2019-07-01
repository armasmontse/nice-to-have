<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class AuthUserAccess
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
        $current_user = $this->auth->user();
        $user_id    = $current_user->id;
        $user_name  = $current_user->name;

        $parameters = $request->route()->parameters();

        if (
            ( isset($parameters["user_id"]) && $user_id != $parameters["user_id"] )  ||
            ( isset($parameters["user_name"]) && $user_name != $parameters["user_name"]  ) ||
            ( isset($parameters["user"]) && $current_user != $parameters["user"]  )

            ) {
            if ($request->ajax() || $request->wantsJson()){
                return response('Unauthorized.', 401);
            } else {
                return abort(401);
            }
        }

        return $next($request);
    }
}
