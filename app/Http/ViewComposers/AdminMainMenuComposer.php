<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use Route;

use Auth;


class AdminMainMenuComposer
{

	protected $current_route_name = "";
	protected $route_group_name_prefix = "admin::";


	protected $menu_items = [
		"Inicio" 		=> [
			"permission" => "admin_access",
			"routes" => [
				"index"	=> "Administrador"
			]
		],
		"Usuarios" 		=> [
			"permission" => "manage_users",
			"routes" => [
			// 	route_name => label // label vacio si no se quiere mostrar la ruta pero se quere que se active la seccion
				"users.create"	=> "Agregar usuario",
				"users.index"	=> "Lista de usuarios",
				"users.trash"	=> "Usuarios desactivados",
				"users.edit"	=> ""
			]

		],

		"Imágenes"		=> [
			"permission" => "photos_view",
			"routes" => [
				"photos.index"	=> "Media Manager"
			]
		],

		"Proveedores"		=> [
			"permission" => "manage_providers",
			"routes" => [
				"providers.index"	=> "Lista de proveedores"
			]
		],

		"Categorías"		=> [
			"permission" => "manage_categories",
			"routes" => [
				"categories.index"		=> "Lista de categorías",
				"subcategories.index"	=> "Lista de subcategorías"
			]
		],

		"Tipos"		=> [
			"permission" => "manage_types",
			"routes" => [
				"types.index"		=> "Lista de tipos de eventos",
				"subtypes.index"	=> "Lista de subtipos de eventos"
			]
		],
		"Productos" 		=> [
			"permission" => "manage_products",
			"routes" => [
				"products.create"=> "Agregar producto",
				"products.index"	=> "Lista de productos",
				"products.trash"	=> "Papelera de productos",
				"products.edit"	=> ""
			]

		],
		"Eventos" 		=> [
			"permission" => "manage_events",
			"routes" => [
				"events.index"	=> "Lista de eventos",
			]

		],

		"Retiros en efectivo" => [
			"permission" => "manage_cashouts",
			"routes" => [
				"cashouts.index"	=> "Lista de retiros",
			]

		],

		"Carritos" 		=> [
			"permission" => "manage_bags",
			"routes" => [
				"bags.index"	=> "Lista de carritos",
			]

		],

		'Códigos de descuento' 		=> [
			'permission' => 'manage_discount_codes',
			'routes' => [
				'discount_codes.create'		=> 'Agregar código de descuento',
				'discount_codes.index'		=> 'Lista de códigos de descuento',
				'discount_codes.edit'		=> '',
				'discount_codes.trash'		=> 'Códigos de descuento desactivados'
			]

		],

		// Pendiente
		'Páginas'			=> [
			'permission' 	=> 'manage_pages_contents',
			'routes' => [
				'pages.contents.index'	=> 'Lista de páginas',
				'pages.contents.edit'	=> '',
			]
		],

		// Pendiente
		'Estructura de páginas'			=> [
			'permission' 	=> 'manage_pages',
			'routes' => [
				'pages.create'			=> 'Agregar página',
				'pages.index'			=> 'Páginas',
				'pages.edit'			=> '',
				'pages.sections.index'	=> 'Secciones'

			]
		],

		"Ajustes" 		=> [
			"permission" => "system_config",
			"routes" => [
				"settings.index"	=> "Ajustes del sistema",
			]
		],
		"Rutas"		=> [
			"permission" => "routes_view",
			"routes" => [
				"site_map"	=> "Lista de rutas"
			]
		],
		"Manuales" 		=> [
			"permission" => "admin_access",
			"routes" => [
				"manuals"	=> "Vídeos"
			]
		],

	];

	public function __construct(){
		$this->current_route_name =  str_replace($this->route_group_name_prefix, "",  Route::currentRouteName()) ;
		$this->menu_items_collection = collect($this->menu_items);
    }

	public function compose(View $view)
	{
		$view->with('menu_items', $this->constructMenuMap() );

		$view->with('route_group_prefix', $this->route_group_name_prefix );
	}

	protected function isActiveSection(array $route_names = [])
	{
		return in_array($this->current_route_name, $route_names);
	}

	public function constructMenuMap()
	{
		$user = Auth::user();

		return $this->menu_items_collection->filter(function($menu_item) use ($user){
			return $user->hasPermission($menu_item['permission']);
		})->map(function($menu_item){
			return [
				'current'	=> $this->isActiveSection(array_keys($menu_item['routes'])),
				'sub_menu'	=> array_filter($menu_item["routes"], function($label){
					return !empty($label);
				})
			];
		});
	}
}
