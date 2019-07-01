<?php

namespace App\Http\Middleware\Cltvo;

use Closure;

class CLtvoTestUrls
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
        if (!env('CLTVO_DEV_MODE')) {
            if ($request->ajax() || $request->wantsJson()){
                return response('Unauthorized.', 403);
            } else {
                return abort(403);
            }
        }
        return $next($request);
    }
}
