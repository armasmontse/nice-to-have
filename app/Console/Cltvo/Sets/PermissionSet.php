<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class PermissionSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "permissions";

    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Permission";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "slug"  => "admin_access",
                "label"  => "Acceso al admin"
            ],
            [
                "slug"  => "system_config",
                "label" => "Configuración del sistema"
            ],
            [
                "slug"  => "manage_users",
                "label"  => "Manejo de usuarios"
            ],
            [
                "slug"  => "manage_photos",
                "label" => "Manejo de imagenes"
            ],
            [
                "slug"  => "photos_view",
                "label" => "Ruta de imagenes"
            ],
            [
                "slug"  => "manage_pages_contents",
                "label" => "Manejo de contenidos de páginas"
            ],
            [
                "slug"  => "manage_pages",
                "label" => "Manejo de páginas"
            ],
            [
                "slug"  => "routes_view",
                "label" => "Ver rutas"
            ],
            [
                "slug"  => "manage_providers",
                "label" => "Manejo de proveedores"
            ],
            [
                "slug"  => "manage_types",
                "label" => "Manejo de tipos de eventos"
            ],
            [
                "slug"  => "manage_subtypes",
                "label" => "Manejo de subtipos de eventos "
            ],
            [
                "slug"  => "manage_categories",
                "label" => "Manejo de categorias"
            ],
            [
                "slug"  => "manage_subcategories",
                "label" => "Manejo de subcategorias"
            ],
            [
                "slug"  => "manage_products",
                "label" => "Manejo de productos"
            ],
            [
                "slug"  => "associate_photos",
                "label" => "asociar imagenes"
            ],
            [
                "slug"  => "manage_events",
                "label" => "Ruta de eventos"
            ],
            [
                "slug"  => "manage_cashouts",
                "label" => "Ruta de Cashouts"
            ],
            [
                "slug"  => "manage_bags",
                "label" => "Manejo de bolsas"
            ],
            [
                'slug'  => 'manage_discount_codes',
                'label' => 'Manejo de códigos de descuento'
            ],
        ];
    }

}
