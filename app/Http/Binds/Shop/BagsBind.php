<?php

namespace App\Http\Binds\Shop;

use App\Http\Binds\CltvoBind;

use Route;
use Auth;

use App\Models\Shop\Bag;
use App\Models\Shop\BagType;
use App\Models\Shop\BagStatus;

use App\User;


class BagsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las bolsas activas
        Route::bind('active_bag', function ($bag_key, $route) {
            $user = Auth::user();

            $bag = Bag::ActivesFor($user)
                ->ByKey($bag_key)
                ->first();

            if (!$bag || $bag->bagType->protected) {
                return null;
            }

            if ($bag->bagType->event && !$bag->bagType->special) {
                if (!session("cookie_event") || $bag->event_id != session("cookie_event")->id ) {
                    return null;
                }
            }

            return $bag;
        });

    // para las nuevas bolsas activas
        Route::bind('new_bag', function ($bag_key, $route) {

            $user = Auth::user();

            $default_keys = BagType::getDefaultKeys( session("cookie_event") );

            if ( isset($default_keys[$bag_key]) ) {
                $bag = null;

                if ($user) {
                    $bags = Bag::with("bagType")
                        ->ActivesFor($user)
                        ->where([ 'bag_type_id'   => $default_keys[$bag_key]->id ]);

                    if ($default_keys[$bag_key]->event) {
                        $bags = $bags->ForEvent(session("cookie_event"));
                    }

                    $bag = $bags->first();
                }

                return $bag ? $bag : Bag::createBag($user,$default_keys[$bag_key], session("cookie_event") );
            }

            $bag = Bag::with("bagType")
                ->ActivesFor($user)
                ->ByKey($bag_key)
                ->first();

            if (!$bag || !$bag->bagType->event) {
                return $bag;
            }

			if ($bag->bagType->special) {
				return $bag;
			}

            if (!session("cookie_event")) {
                return null;
            }

            if ($bag->event_id == session("cookie_event")->id) {
                return $bag;
            }

            $bag = null;

            if ($user) {
                $bag = Bag::with("bagType")
                    ->ActivesFor($user)
                    ->where([ 'bag_type_id' => $bag->bagType->id ])
                    ->ForEvent(session("cookie_event"))
                    ->first();
            }

            return $bag ? $bag : Bag::createBag($user,$bag->bagType, session("cookie_event") );

        });

    // para las bolsas activas
        Route::bind('personal_bag', function ($bag_key, $route) {
            $user = $route->parameters()["user"];
            return  $user ? $user->bags()->InActives()->where(["key" => $bag_key])->first() : null;
        });

    // para las bolsas activas
        Route::bind('personal_admin_bag', function ($bag_key, $route) {

			if (is_page("user::bag.thankyou-page.show")) {
				$user = $route->parameters()["user"];
				return  $user ? $user->bags()->InActives()->where(["key" => $bag_key])->first() : null;
			}

            if (Auth::user()->hasPermission('manage_bags')) {
				 return Bag::where(["key" => $bag_key])->get()->first();
			}
            return null;
        });

    // para las bolsas activas
        Route::bind('admin_bag', function ($bag_key, $route) {
            $current_user = Auth::user();

            if ($current_user->hasPermission('manage_bags')) { return Bag::with('bagBilling', 'bagBilling.address', 'bagBilling.address.country', 'bagStatus', 'bagType', 'bagUser', 'bagShipping', 'bagShipping.address', 'bagShipping.address.country', 'bagPayment' )->where(["key" => $bag_key])->get()->first(); }
        });

    // para las bolsas activas
        Route::bind('admin_payed_bag', function ($bag_key, $route) {
            $current_user = Auth::user();

            if ($current_user->hasPermission('manage_bags')) { return Bag::with('bagBilling', 'bagBilling.address', 'bagBilling.address.country', 'bagStatus', 'bagType', 'bagUser', 'bagShipping', 'bagShipping.address', 'bagShipping.address.country', 'bagPayment' )->where(["key" => $bag_key])->whereHas('bagStatus', function($query){
                $query->where('paid', true);
            })->get()->first(); }
        });

    // Para las bolsas que son para regalar
        Route::bind('present_bag', function ($bag_key, $route) {

            $bag = Bag::where(['key' => $bag_key])
            ->with('bagStatus', 'bagType')
            ->whereHas('bagStatus', function($q){
                $q->where([
                    ['paid', '=', 1],
                    ['cancel', '=', 0]
                ]);
            })
            ->whereHas('bagType', function($q){
                $q->where('event', '<>', 1);
            })
            ->whereNotNull('print_message')
            ->first();

            return $bag;
        });

    }
}
