<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class CashOutStatusSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Status de cash outs";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "label";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Events\CashOutStatus";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "apply"     => false,
                "cancel"    => false,
                "slug"      => "solicitado",
                "label"     => "Solicitado"
            ],
            [
                "apply"     => true,
                "cancel"    => false,
                "slug"      => "pagado",
                "label"     => "Pagado"
            ],
            [
                "apply"     => false,
                "cancel"    => true,
                "slug"      => "cancelado",
                "label"     => "Cancelado"
            ],
        ];
    }

}
