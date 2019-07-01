<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Category;

class ManageCategoriesBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las categorias
        Route::bind('category', function ($category_id) {
            return Category::with('languages')->GetWithTranslations()->find($category_id);
        });
    }

}
