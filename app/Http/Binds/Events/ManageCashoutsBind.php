<?php

namespace App\Http\Binds\Events;

use App\Http\Binds\CltvoBind;

use Route;

use App\Models\Events\CashOut;

class ManageCashoutsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
    // para los retiros
        Route::bind('cashout', function ($cashout_id) {
            return CashOut::find($cashout_id);
        });
    }

}
