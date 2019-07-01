<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Events\Event;

class EventCookie
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
        session(["cookie_event" => $this->getEvent( $request ) ]);
        return $next($request);
    }

    protected function getEvent($request)
    {
        if ( is_page("client::events.shop")  ||  is_page("client::events.shop.single")) {
            return $request->route()->parameters()["public_event"] ;
        }

        $event_key = $request->cookie("event");

        // $event_key = "bmayfe261116"; // quitar eh integrar cuando el motor de eventos este terminado

        $event = Event::with("typeable")
            ->Open()
            ->where(["key" => $event_key ])
            ->first(); //

            if (!$event || !$event->in_time)  {
                return null;
            }
        return  $event;

    }

}
