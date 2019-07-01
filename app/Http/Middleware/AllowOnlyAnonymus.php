<?php

namespace App\Http\Middleware;

use Closure;
use Response;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use Redirect;

class AllowOnlyAnonymus
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

        if ($current_user) {
            if (is_page("client::bag.checkout.register")) {
                $parameters = $request->route()->parameters();
                if (isset($parameters["active_bag"] )  && $parameters["active_bag"] ) {
                    return Redirect::route("client::bag.checkout:get",$parameters["active_bag"]->key);
                }
            }

            if (is_page("client::event.register")) {
                return Redirect::route("user::events.create",$current_user->name);
            }

            return redirect($current_user->getHomeUrl());
        }


        // abort_if(is_page("client::event.register") || is_page("client::bag.checkout.register"), 404);

        return $next($request);
    }
}
