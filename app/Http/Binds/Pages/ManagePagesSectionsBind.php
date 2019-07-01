<?php

namespace App\Http\Binds\Pages;

use App\Http\Binds\CltvoBind;
use App\Models\Pages\Sections\Section;
use Route;

class ManagePagesSectionsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las secciones de las páginas
        Route::bind('page_section', function ($section_id) {
            return Section::with([
                    "type",
                    "pages",
                    "components"
                ])
                ->where(["id" => $section_id])->first();
        });
    }

}
