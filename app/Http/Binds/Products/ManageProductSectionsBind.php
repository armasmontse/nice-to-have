<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Product;
use App\Models\Products\ProductSection;

class ManageProductSectionsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        Route::bind('product_section', function ($section_id , $route) {
            $product = $route->parameters()["product_editable"];
            return $product->productSections()->GetWithTranslations()->find($section_id);
        });
    }

}
