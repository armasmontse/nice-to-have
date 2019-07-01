<?php

namespace App\Http\Binds\Shop;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Category;
use App\Models\Products\Subcategory;
use App\Models\Events\Subtype;
use App\Models\Events\Type;

class FilterProductsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las subcategorias
        Route::bind('public_category', function ($category_slug) {
            return Category::with('languages')->GetModelBySlug($category_slug)->first();
        });
    // para las subcategorias
        Route::bind('public_subcategory', function ($subcategory_slug) {
            return Subcategory::with('languages')->GetModelBySlug($subcategory_slug)->first();
        });
    // para las tipos de evento
        Route::bind('public_type', function ($type_slug) {
            return Type::with('languages')->GetModelBySlug($type_slug)->first();
        });
    // para las subtipos de evento
        Route::bind('public_subtype', function ($subtype_slug) {
            return Subtype::with('languages')->GetModelBySlug($subtype_slug)->first();
        });
    }

}
