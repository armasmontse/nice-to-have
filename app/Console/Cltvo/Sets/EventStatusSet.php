<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class EventStatusSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Status de eventos";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "label";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Events\EventStatus";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "active"    => true,
                "publish"   => false,
                "slug"      => "borrador",
                "label"     => "Inactivo"
            ],
            [
                "active"    => true,
                "publish"   => true,
                "slug"      => "publicado",
                "label"     => "Activo"
            ],
            [
                "active"    => false,
                "publish"   => true,
                "slug"      => "finalizado",
                "label"     => "Cerrado"
            ],
        ];
    }

}
