<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class EventTemplateHeaderSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Templates views";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "view";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Events\EventTemplateHeader";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "view"  => "imagen_circular"
            ],
            [
                "view"  => "imagen_completa"
            ],
            [
                "view"  => "media_imagen"
            ],
        ];
    }

}
