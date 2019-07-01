<?php

namespace App\Http\Binds\Skus;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Product;
use App\Models\Skus\Sku;

class ManageSkusBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        Route::bind('product_sku', function ($sku_sku , $route) {
            $product = $route->parameters()["product_editable"];
            return $product->skus()->GetWithTranslations()->where(["sku" => $sku_sku])->first();
        });
    }

}
