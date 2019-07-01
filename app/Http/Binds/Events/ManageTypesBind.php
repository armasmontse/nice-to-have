<?php

namespace App\Http\Binds\Events;

use App\Http\Binds\CltvoBind;

use Route;
use App\Models\Events\Type;

class ManageTypesBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las tipos de evento
        Route::bind('type', function ($type_id) {
            return Type::with('languages')
                ->GetWithTranslations()
                ->find($type_id);
        });
    }

}
