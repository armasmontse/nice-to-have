<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Setting;

use App\Models\Shop\Bag;
use Request;

class ClientBagsMenuComposer
{
	public function compose(View $view)
	{
		$menu_labels = [
			"personal"                  => "para mi",
			// "regalo"                    => "para alguien",
			"agregar-a-mesa-de-regalos" => "para mesa de regalos",
		];

		$route_parameters = Request::route()->parameters();

		$current_key = isset($route_parameters["active_bag"]) ? $route_parameters["active_bag"]->key : null;

		$menu_items = collect(session("cookie_bags"))->map(function($bag_key,$key) use ($menu_labels,$current_key){
			return [
				"url"       => route("client::bags.index") ,
				"active"    => $current_key == $bag_key,
				"label"     => $menu_labels[$key],
				"slug" 		=> $key,
			];
		});

		$view->with('menu_items',$menu_items);
	}
}
