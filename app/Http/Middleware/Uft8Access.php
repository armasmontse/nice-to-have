<?php

namespace App\Http\Middleware;

use Closure;

class Uft8Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_page("client::login.facebook") || is_page("client::login.facebook") ) {
            return $next($request);
        }

        return $next($request)
            ->header('charset', 'utf-8');
    }
}
