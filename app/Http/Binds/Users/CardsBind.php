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
        Route::bind('card', function ($card_id , $route) {
            $user = $route->parameters()["user"];
            return $user->cards()->find($card_id);
        });
    }

}
