<?php

namespace App\Http\Controllers\Users\Bags;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Models\Shop\Bag;

use App\Models\Events\Event;

use App\Models\Address\Country;

use App\User;

use Redirect;

class BagEventController extends ClientController
{
    public function index(User $user, Event $personal_event)
    {
        abort_if(!$personal_event->is_finish || !$personal_event->is_close_bag_active, 404);

        $event_close_bag = $personal_event->getCloseBag();

        if ($this->event_close_bag->key != $event_close_bag->key) {
            return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
        }

        $display = [
            "retirar-mesa-de-regalos" => [
                'title'       => 'Mi mesa de regalos',
                'content'     => 'Compras que hicieron a tu evento y que vas a retirar para se envíen a tu domicilio.'
            ]
        ];

		$given_skus = $personal_event->getEventProtectedBag()->skus->map(function ($item) {
		    return $item->sku;
		});

        $address = $personal_event->getMainAddress();

        $data = [
            'address_in_zmvm'       => $address ? $address->in_zmvm : false ,
            "personal_event"        => $personal_event,
            'mexico_states_and_mun' => Country::getMexicoStatesiWithMunicipies(),
            'current_bags'          => $this->getMapBagsContent($display),
            "bag"                   => $event_close_bag,
			'given_skus'			=> $given_skus,
            'is_event_shop'         => true,
            'is_bag'                => true,
        ];

        return view("users.events.cart", $data);
    }
}
