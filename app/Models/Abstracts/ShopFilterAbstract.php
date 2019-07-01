<?php

namespace App\Models\Abstracts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Interfaces\ShopFilterInterface;

use URL;
use Lang;

abstract class ShopFilterAbstract extends Model implements ShopFilterInterface {


    public function shopFilterUrl($current_lang_iso)
    {
        $shop_url =  $current_lang_iso."/".Lang::get("routes.shop",[],$current_lang_iso)."/";
        return URL::to($shop_url.$this->shopFilterUri($current_lang_iso));
    }

    // abstract protected function shopFilterUri($current_lang_iso);


    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getObjectTypeAttribute()
    {
        return snake_case(array_last(explode('\\', get_called_class())));;
    }


}
