<?php
namespace App\Http\ViewComposers\Admin;

use Illuminate\Contracts\View\View;

use Route;

use Auth;


class AdminMainMenuComposer
{

	protected $current_route_name = "";
	protected $route_group_name_prefix = "admin::";

	protected function getMenuItems()
	{
		return collect([
			$this->setMenuItem("Inicio",[
				$this->setSubMenuItem("index", "admin_access","Administrador"),
			]),

			$this->setMenuItem("Usuarios",[
				$this->setSubMenuItem("users.create","manage_users","Agregar usuario"),
				$this->setSubMenuItem("users.index", "manage_users","Lista de usuarios"),
				$this->setSubMenuItem("users.trash", "manage_users","Usuarios desactivados"),
				$this->setSubMenuItem("users.edit", "manage_users",""),
			]),

			$this->setMenuItem("Imágenes",[
				$this->setSubMenuItem("photos.index", "photos_view","Media Manager"),
			]),

			$this->setMenuItem("Páginas",[
				$this->setSubMenuItem("pages.contents.index", "manage_pages_contents","Lista de páginas"),
				$this->setSubMenuItem("pages.contents.edit", "manage_pages_contents",""),

				$this->setSubMenuItem("pages.create","manage_pages","Agregar página"),
				$this->setSubMenuItem("pages.index", "manage_pages","Administrar páginas"),
				$this->setSubMenuItem("pages.edit", "manage_pages",""),

				$this->setSubMenuItem("pages.sections.index", "manage_pages","Administrar secciones"),
			]),


			$this->setMenuItem("Ajustes",[
				$this->setSubMenuItem("settings.index", "system_config","Ajustes del sistema"),
			]),

			$this->setMenuItem("Rutas",[
				$this->setSubMenuItem("site_map", "routes_view","Lista de rutas"),
			]),

			$this->setMenuItem("Manuales",[
				$this->setSubMenuItem("manuals", "admin_access","Videos"),
			]),

		]);
	}

	public function __construct(){
		$this->current_route_name =  str_replace($this->route_group_name_prefix, "",  Route::currentRouteName()) ;
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
		return $this->getMenuItems()->filter(function($menu_item) use ($user){
					$permissions = $menu_item->routes->pluck("permission");
					return $user->hasPermission($permissions->unique()->toArray());
				})->map(function($menu_item) use ($user){

					return (object) [
						"label"			=> $menu_item->label,
						"current"		=> $this->isActiveSection($menu_item->routes->pluck("name")->toArray()),
						"sub_menu"		=> $menu_item->routes->filter(function($sub_menu_item) use ($user){
							return !empty($sub_menu_item->label) && $user->hasPermission($sub_menu_item->permission);
						}),
					];
				});
	}

	protected function setSubMenuItem($route_name, $permission, $label)
	{
		return (object) [
			"name"			=> $route_name,
			"permission" 	=> $permission,
			"label"			=> $label
		];
	}


	protected function setMenuItem($label, array $sub_menu)
	{
		return (object) [
			"label"			=> $label,
			"routes"		=> collect($sub_menu),
		];
	}
}
