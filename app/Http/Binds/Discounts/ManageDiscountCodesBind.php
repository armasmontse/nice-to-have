<?php

namespace App\Http\Binds\Discounts;

use App\Http\Binds\CltvoBind;
use App\Models\Shop\Discounts\DiscountCode;

use Route;

class ManageDiscountCodesBind extends CltvoBind
{
    public static function Bind()
    {
        Route::bind('discount_code', function ($discount_code)
        {
            return DiscountCode::find($discount_code);
        });

        Route::bind('discount_code_trashed', function ($discount_code_trashed)
        {
            return DiscountCode::onlyTrashed()->find($discount_code_trashed);
        });
    }

}