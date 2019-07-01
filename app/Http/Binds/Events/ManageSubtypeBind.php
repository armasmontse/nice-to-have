<?php

namespace App\Http\Binds\Events;

use App\Http\Binds\CltvoBind;

use Route;
use App\Models\Events\Subtype;

class ManageSubtypeBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para las subtipos de evento
        Route::bind('subtype', function ($subtype_id) {
            return Subtype::with('languages')
                ->GetWithTranslations()
                ->find($subtype_id);
        });
    }

}
