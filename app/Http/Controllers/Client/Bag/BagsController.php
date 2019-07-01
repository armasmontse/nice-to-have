<?php

namespace App\Http\Controllers\Client\Bag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Setting;

use App\Models\Shop\Bag;

use Redirect;


class BagsController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if ($this->event_close_bag) {
			return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        $display = [
            "personal"  => [
                'title'       => 'Comprar para mi',
                'content'     => 'Compras que fueron seleccionadas como personales que se enviarán a tu dirección de envío'
            ],
            // "regalo" => [
            //     'title'       => 'Comprar y regalar',
            //     'content'     => 'Decidiste hacer un regalo. Se deberá hacer un checkout por dirección de envío'
            // ],
            "agregar-a-mesa-de-regalos" => [
                'title'       => 'Comprar para mesa de regalos',
                'content'     => 'Seleccionaste uno o varios regalos para enviar a los festejados'
            ]
        ];

        $current_bags = $this->getMapBagsContent($display);

        $data = [
            'current_bags'      => $current_bags,
            'is_event_shop'     => true,
            'is_bag'            => true
        ];

        return view('client.shopping-cart.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bag $active_bag)
    {
        // dd($active_bag);
        if (isset($this->cookie_bags[$active_bag->bagType->slug]) &&  $this->cookie_bags[$active_bag->bagType->slug] !=  $active_bag->key ) {
            $this->cookie_bags[$active_bag->bagType->slug] = $active_bag->key;
            return Redirect::route("client::bags.index")->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
        }

        $data = [
            "bag_key"               => $active_bag->key,
            "bag_slug"              => $active_bag->bagType->slug,
            "bag"                   => $active_bag,
            "products"              => $active_bag->getProducts(),
            "products_in_event"     => $this->cookie_event ?  $this->cookie_event->getEventProtectedBagProducts() : collect([]),
            'is_event_shop'    =>     false
        ];

        return view("client.shopping-cart.show",$data);
    }


}
