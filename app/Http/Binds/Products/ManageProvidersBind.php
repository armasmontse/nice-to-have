<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Products\Provider;

class ManageProvidersBind extends CltvoBind
{
    public static function Bind(){
        // para los povedores
        Route::bind('provider', function ($provider_id) {
            return Provider::find($provider_id);
        });
    }
}
