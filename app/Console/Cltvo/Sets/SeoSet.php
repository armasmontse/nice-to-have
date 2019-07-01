<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class BagStatusSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Bag statuses";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "label";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Shop\BagStatus";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "active"        => true,
                "paid"          => false,
                "cancel"        => false,
                "slug"          => "activo",
                "label"         => "Activo"
            ],
            [
                "active"        => false,
                "paid"          => false,
                "cancel"        => false,
                "slug"          => "pago-pendiente",
                "label"         => "Pago pendiente"
            ],
            [
                "active"        => false,
                "paid"          => true,
                "cancel"        => false,
                "slug"          => "pagado",
                "label"         => "Pagado"
            ],
            [
                "active"        => false,
                "paid"          => true,
                "cancel"        => false,
                "slug"          => "en-proceso",
                "label"         => "En proceso"
            ],
            [
                "active"        => false,
                "paid"          => true,
                "cancel"        => false,
                "slug"          => "entregado",
                "label"         => "Entregado"
            ],

            [
                "active"        => false,
                "paid"          => true,
                "cancel"        => true,
                "slug"          => "cancelado",
                "label"         => "Cancelado"
            ],

            [
                "active"        => false,
                "paid"          => true,
                "cancel"        => true,
                "slug"          => "devuelto",
                "label"         => "Devuelto"
            ],

            [
                "active"        => false,
                "paid"          => false,
                "cancel"        => true,
                "slug"          => "expirado",
                "label"         => "Expirado"
            ],




        ];
    }

}
