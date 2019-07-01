<?php

namespace App\Http\Binds\Skus;

use App\Http\Binds\CltvoBind;

use Route;

class BagSkusBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        Route::bind('bag_sku', function ($sku_sku , $route) {
            $bag = $route->parameters()["active_bag"];
            if (!$bag) {
                return null;
            }
            return $bag->skus()->where(["sku" => $sku_sku])->with('product')->whereHas('product', function($q){
                return $q->Public();
            })->first();
        });
    }

}
