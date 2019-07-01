<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;

use Route;
use Auth;
use App\Models\Products\Product;

class PublicProductsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        Route::bind('public_product', function ($product_slug) {

            $user = Auth::user();

            $products = Product::with([
                "publish",
                "photos",
                "skus",
                "productSections",
                "productSections.languages",
                "productsRelated" => function($query) use($user){
                    if (!$user || !$user->hasPermission("manage_products") ) {
                        $query = $query->public();
                    }
                }
            ]);

            if (!$user || !$user->hasPermission("manage_products") ) {
                $products = $products->public();
            }

            return $products->GetModelBySlug($product_slug)->first();
        });
    }

}
