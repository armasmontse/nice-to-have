<?php

namespace App\Http\Middleware\Cltvo;

use Closure;
use Response;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class PreviousUrl
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    protected $NotCltvoPreviousURL = [
        'client::login.facebook.callback',
        'client::login.facebook',
        'client::pass_reset_email',
        'client::pass_reset:get',
        'client::login:post',
        'client::logout',
        'client::login:get',
        'client::register:post',
        'client::register:get',
        'client::pass_reset:post',
        'client::pass_reset_token',
        'client::pass_set:get',
        'client::pass_set:patch',
    ];

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
        $route_uri = $request->url();

        if (!$current_user &&
            !in_array($request->route()->getName(), $this->NotCltvoPreviousURL ) &&
            !$request->ajax()
        ) {
            session(['CltvoPreviousURL' => $route_uri ]);
        }

        return $next($request);
    }
}
