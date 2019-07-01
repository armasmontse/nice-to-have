<?php

namespace App\Http\Binds;

use App\Http\Binds\CltvoBind;
use App\Photo;

use Route;

class ManagePhotosBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){
        // para las fotos
            Route::bind('photo', function ($photo_id) {
                return Photo::GetWithTranslations()->with("languages")->find($photo_id);
            });

    }

}
