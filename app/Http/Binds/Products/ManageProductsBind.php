<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Product;

class ManageProductsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para la papelera
        Route::bind('erasable_product', function ($product_id) {
            return Product::with("languages")
                ->GetWithTranslations()
                ->find($product_id);
        });

    // para editar
        Route::bind('product_editable', function ($product_id) {
            return Product::with(
                    "languages",
                    "publish",
                    "photos",
                    "skus",
                    // "productSections",
                    "subcategories",
                    "subtypes",
                    "productsRelated"
                )
                ->GetWithTranslations()
                ->find($product_id);
        });

    // para la recovery
        Route::bind('product_trashed', function ($product_id) {
                return Product::onlyTrashed()
                ->with("languages")
                ->GetWithTranslations()
                ->find($product_id);

        });

    // para el wishlist
        Route::bind('wishlist_product', function ($product_id, $route) {
                $user = $route->parameters()["user"];
                return $user->products()
                    ->withTrashed()
                    ->find($product_id);

        });


    }

}
