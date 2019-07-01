<?php

namespace App\Http\Binds\Products;

use App\Http\Binds\CltvoBind;
use App\Models\Products\Provider;

use Route;

class PublicProvidersBind extends CltvoBind
{
    public static function Bind(){
        Route::bind('provider_slug', function ($provider_slug) {
            return Provider::where('slug', $provider_slug)->first();
        });
    }
}