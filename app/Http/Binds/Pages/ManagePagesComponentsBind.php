<?php

namespace App\Http\Binds\Pages;

use App\Http\Binds\CltvoBind;
use App\Models\Pages\Sections\Section;
use Route;

class ManagePagesComponentsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las secciones de las páginas
        Route::bind('section_component', function ($component_id,$route) {
            $page_section = $route->parameters()["page_section"];
            return $page_section ? $page_section->components()->where(["id" => $component_id ])->get()->first() : null;
        });
    }

}
