<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Setting;

class ClientMainMenuComposer
{
	public function compose(View $view)
	{

		$menu_items = [
			[
				"selected"	=> is_exact_page("client::pages.show",["nosotros"]), // pendiente
				"link"		=> route("client::pages.show","nosotros"),
				"label"		=> "Nosotros",
			],
			[
				"selected"	=> in_pages(["client::event.register",'user::events.create']), // pendiente
				"link"		=> route("client::event.register"),
				"label"		=> "Crea un Evento",
			],
			[
				"selected"	=>  in_pages([
								"client::shop.index",
								"client::single.show",
								"client::shop.filters.category",
								"client::shop.filters.subcategory",
								"client::shop.filters.subtype",
								"client::shop.filters.type"
							]),
				"link"		=> route("client::shop.index"),
				"label"		=> "Tienda",
			],
			[
				"selected"	=> in_pages([
					"client::events.shop",
					"client::events.shop.single",
					"client::events.search"
				]),
				"link"		=> route("client::events.search"),
				"label"		=> "Mesa de regalos",
			],

		];

		$view->with('menu_items',$menu_items);
	}
}
