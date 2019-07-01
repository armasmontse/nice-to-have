<?php

namespace App\Http\Middleware;

use Closure;
use Response;

class AllowOnlyAjaxRequests
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
        if(!$request->ajax()) {
            // Handle the non-ajax request
            return Response::json([
                'message' => ["Unauthorized"]
            ], 401);
        }

        return $next($request);
    }
}
