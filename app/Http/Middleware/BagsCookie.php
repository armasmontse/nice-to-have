<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Shop\BagType;
use App\Models\Shop\Bag;

class BagsCookie
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
		$event_close_bag = $this->getEventCloseBags( $request) ;
		session(["event_close_bag" => $event_close_bag ]);

		if ($event_close_bag) {
			$cookie_bags = [];
			$cookie_bags[$event_close_bag->bagType->slug] = $event_close_bag->key;
		}else{
			$cookie_bags = $this->getBags( $request);
		}
		
        session(["cookie_bags" => $cookie_bags ]);
        return $next($request);
    }

	protected function getEventCloseBags($request)
	{
		$cookie_event_close_bag_key = $request->cookie("close_bag");

		$user = $this->auth->user();
		if (!$user) {
			return null;
		}
		$bags = $user->bags()
			->actives()
			->eventSpecialNotProtected()
			->get()
		 ;

		$bag = null;
		if ($cookie_event_close_bag_key) {
			$bag = $bags->where("key",$cookie_event_close_bag_key)->first();
		}

		if (!$bag) {
			$bag = $bags->first();
		}

		return $bag;
	}


    protected function getBags($request)
    {
        $cookie_bags = $request->cookie("bags");
        $cookie_bags = is_array( $cookie_bags ) ? $cookie_bags  : [];
        $user = $this->auth->user();

        return  BagType::NotSpecial( session("cookie_event") )->get()->mapWithKeys(function($bag_type ) use ($cookie_bags,$user){
            if (isset($cookie_bags[$bag_type->slug])) {

                $bag = null;

                $query_bags = Bag::ActivesFor($user);

                if ( !$user ) {
                    if ( $cookie_bags[$bag_type->slug] != $bag_type->default_key ) {

                            $query_bags = $query_bags->ByKey($cookie_bags[$bag_type->slug]);

                        if ($bag_type->event) {
                            $query_bags = $query_bags->ForEvent( session("cookie_event")  );
                        }

                        $bag = $query_bags->first();
                    }
                }else{
                    $query_bags = $query_bags->ByTypeId($bag_type->id);

                    if ($bag_type->event) {
                        $query_bags = $query_bags->ForEvent( session("cookie_event")  );
                    }

                    $type_bags = $query_bags->get();

                    $bag = $type_bags->where("key",$cookie_bags[$bag_type->slug] )->first() ;

                    if (!$bag) {
                        $bag = $type_bags->first();
                    }

                }
                return [
                    $bag_type->slug => ($bag ? $bag->key : $bag_type->default_key),
                ];
            }else {
                if ($user) {

                    $query_bags = Bag::ActivesFor($user)
                        ->ByTypeId($bag_type->id);
                    if ($bag_type->event) {
                        $query_bags = $query_bags->ForEvent( session("cookie_event")  );
                    }
                    $bag = $query_bags->first();

                    return [
                        $bag_type->slug => ($bag ? $bag->key : $bag_type->default_key),
                    ];
                }else{
                    return [
                        $bag_type->slug => $bag_type->default_key,
                    ];
                }
            }

        })->toArray();
    }
}
