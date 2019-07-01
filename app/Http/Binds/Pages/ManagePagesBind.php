<?php

namespace App\Http\Binds\Pages;

use App\Http\Binds\CltvoBind;
use App\Models\Pages\Page;
use Route;

class ManagePagesBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las páginas
        Route::bind('page_edit_content', function ($page_id) {
            return Page::with([
                    "languages",
                    "publish",
                    "sections",
                    "sections.type",
                    "sections.components",
                    "sections.components.photos",
                    "sections.components.languages",
                ])
                ->where(["id" => $page_id])->first();
        });

        Route::bind('page_edit', function ($page_id) {
            return Page::with([
                    "languages",
                    "sections",
                    "childs",
                    "parent"
                ])
                ->where(["id" => $page_id])->first();
        });

    }

}
