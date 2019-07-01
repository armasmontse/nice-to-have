<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Subcategory;

class ManageSubcategoriesBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las subcategorias
        Route::bind('subcategory', function ($subcategory_id) {
            return Subcategory::with('languages')
                ->GetWithTranslations()
                ->find($subcategory_id);
        });
    }

}
