<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Route;

class AdminController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        $data = [
            'items' => [
                [
                    'icon'          => '&#xf0c0;',
                    'label'         => 'Usuarios',
                    'route_name'    => 'users.index',
                    'permission'    => 'manage_users',
                ],
                [
                    'icon'  => '&#xf03e;',
                    'label' => 'Imágenes',
                    'route_name' => 'photos.index',
                    'permission'    => 'photos_view',
                ],
                [
                    'icon'  => '&#xf0d1;',
                    'label' => 'Proveedores',
                    'route_name' => 'providers.index',
                    'permission'    => 'manage_providers',
                ],
                [
                    'icon'  => '&#xf0ca;',
                    'label' => 'Categorías',
                    'route_name' => 'categories.index',
                    'permission'    => 'manage_categories',
                ],
                [
                    'icon'  => '&#xf02d;',
                    'label' => 'Tipos',
                    'route_name' => 'types.index',
                    'permission'    => 'manage_types',
                ],
                [
                    'icon'  => '&#xf000;',
                    'label' => 'Productos',
                    'route_name' => 'products.index',
                    'permission'    => 'manage_products',
                ],
                [
                    'icon'  => '&#xf274;',
                    'label' => 'Eventos',
                    'route_name' => 'events.index',
                    'permission'    => 'manage_events',
                ],
                [
                    'icon'  => '&#xf07a;',
                    'label' => 'Carritos',
                    'route_name' => 'bags.index',
                    'permission'    => 'manage_bags',
                ],
                [
                    'icon'  => '&#xf02c;',
                    'label' => 'Códigos de descuento',
                    'route_name' => 'discount_codes.index',
                    'permission'    => 'manage_discount_codes',
                ],
				[
					'icon'  => '&#xf0e8;',
					'label' => 'Páginas',
					'route_name' => 'pages.contents.index',
					'permission'    => 'manage_pages_contents',
				],
                [
                    'icon'  => '&#xf013;',
                    'label' => 'Ajustes del Sistema',
                    'route_name' => 'settings.index',
                    'permission'    => 'system_config',
                ],
                [
                    'icon'  => '&#xf08e;',
                    'label' => 'Rutas',
                    'route_name' => 'site_map',
                    'permission'    => 'routes_view',
                ],
                [
                    'icon'  => '&#xf03d;',
                    'label' => 'Manuales',
                    'route_name' => 'manuals',
                    'permission'    => 'admin_access',
                ],
            ]
        ];
        return view('admin.index', $data);
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function manuals() {
        return view('admin.manuals');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function siteMap()
    {
        $data =[
            "routes"  => collect(Route::getRoutes())
                ->sortBy(function($route){
                    $route_name_parts =  explode(".",$route->getName());

                    if (isset($route_name_parts[1])) {
                        return str_replace(".".end($route_name_parts), "", $route->getName() );
                    }

                    $route_name_parts =  explode("::",$route->getName());

                    return isset($route_name_parts[1]) ? $route_name_parts[0] : $route->getName();
                })
                // ->groupBy(function($route,$key){
                //     $route_name_parts =  explode(".",$route->getName());
                //
                //     if (isset($route_name_parts[1])) {
                //         return str_replace(".".end($route_name_parts), "", $route->getName() );
                //     }
                //
                //     $route_name_parts =  explode("::",$route->getName());
                //
                //     return isset($route_name_parts[1]) ? $route_name_parts[0] : "errores";
                // })->map(function($route_group){
                //     return $route_group->sortBy(function($route){
                //         return $route->getName();
                //     });
                // })
        ];
        return view('admin.site-map',$data);
    }


}
