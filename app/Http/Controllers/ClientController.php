<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use View;

use App\Models\Shop\Bag;

use Illuminate\Support\Facades\Route;

class ClientController extends Controller
{

    public $cookie_bags = [];
    public $event_close_bag = null;

    public $cookie_event = null;

    public $show_empty_copy = false;

    public function constructThisController()
    {
        // Show no copy alert
        $this->show_empty_copy = $this->user && $this->user->hasPermission('system_config');
        View::share('show_empty_copy', $this->show_empty_copy); // pasar a todas las vistas

    // pasamos todas las bolsas
		$this->event_close_bag = session("event_close_bag");	// bolsa de bloqueo
		View::share("event_close_bag",$this->event_close_bag); // pasar a todas las vistas

        $this->cookie_bags = session("cookie_bags");
        View::share("cookie_bags",$this->cookie_bags); // pasar a todas las vistas
		$this->content_bags = $this->getBagsContent();
        View::share("content_bags",$this->content_bags); // pasar a todas las vistas

    // pasamos el evento
        $this->cookie_event = session("cookie_event");
        View::share("cookie_event",$this->cookie_event); // pasar a todas las vistas

    }

    protected function getBagsContent()
    {
        return collect($this->cookie_bags)->map(function($bag_key){
            return Bag::getBagQuantitiesByKey($bag_key);
        });
    }

    protected function getMapBagsContent($display)
    {
        $cookie_event = $this->cookie_event ;
        return $this->content_bags->filter(function($item){
            return $item["total"] > 0;
        })->map(function($bag,$key) use ($display,$cookie_event) {

            $bag_object = Bag::where(["key" => $bag["key"] ])->first();
            $salida = $display[$key];
            $salida['total_items']  = $bag["total"];
            $salida['cart_url']     = route("client::bags.index");

            $salida['bag']     = [
                "bag_key"               => $bag_object->key,
                "bag_slug"              => $bag_object->bagType->slug,
                "bag"                   => $bag_object,
                "products"              => $bag_object->getProducts(),
                "products_in_event"     => $cookie_event ?  $cookie_event->getEventProtectedBagProducts() : collect([]),
            ];
            return $salida;
        });
    }

}
