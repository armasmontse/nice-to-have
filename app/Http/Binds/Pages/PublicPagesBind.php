<?php

namespace App\Http\Binds\Pages;

use App\Http\Binds\CltvoBind;
use App\Models\Pages\Page;
use Route;

class PublicPagesBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        // para las páginas
        Route::bind('public_page', function ($page_slug) {
            return Page::notMain()->whereNull('parent_id')->published()->getModelBySlug($page_slug)->get()->first();
        });

        Route::bind('public_child_page', function ($page_slug,$route) {
            $public_page = $route->parameters()["public_page"];
            return $public_page ? $public_page->childs()->published()->getModelBySlug($page_slug)->get()->first() : null;
        });

    }

}
