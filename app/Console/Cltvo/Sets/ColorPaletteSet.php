<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class ColorPaletteSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Color palletes";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "color_1";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Events\ColorPalette";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "color_1"   => "EDF1F2",
                "color_2"   => "B1BCBE",
                "color_3"   => "D0D8DA"
            ],
            [
                "color_1"   => "D7473E",
                "color_2"   => "FCFBF6",
                "color_3"   => "F6F0E0"
            ],
            [
                "color_1"   => "498FCD",
                "color_2"   => "6BCD80",
                "color_3"   => "EDF1F2"
            ],
            [
                "color_1"   => "F7CC9F",
                "color_2"   => "CABCCB",
                "color_3"   => "EDF1F2"
            ],
            [
                "color_1"   => "F9E8CA",
                "color_2"   => "FFFFFF",
                "color_3"   => "E5E5E5"
            ],
            [
                "color_1"   => "FFFFFF",
                "color_2"   => "FFFDE6",
                "color_3"   => "A5D1C4"
            ],
        ];
    }

}
