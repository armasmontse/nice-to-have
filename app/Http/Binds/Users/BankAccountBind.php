<?php

namespace App\Http\Binds\Users;

use App\Http\Binds\CltvoBind;

use Route;

class CardsBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        Route::bind('bank_account', function ($bank_account_id , $route) {
            $user = $route->parameters()["user"];
            return $user->bank_accounts()->find($bank_account_id);
        });
    }

}
