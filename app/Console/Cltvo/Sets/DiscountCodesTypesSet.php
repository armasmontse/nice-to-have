<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class DiscountCodesTypesSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse para informar final
     */
    protected $label = 'Códigos de descuento';

    /**
     * Nombre de la clase a ser seteada
     */
    protected function CltvoGetModelClass(){
        return 'App\Models\Shop\Discounts\DiscountCodeType';
    }

    /**
     * Valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                'name'      => 'porcentaje_descuento',
                'label'     => 'Porcentaje de descuento',
                'percent'   => true,
                'shipment'  => false,
                'value'     => false
            ],
            [
                'name'      => 'envio_gratis',
                'label'     => 'Envío gratis',
                'percent'   => false,
                'shipment'  => true,
                'value'     => false
            ],
            [
                'name'      => 'credito',
                'label'     => 'Crédito',
                'percent'   => false,
                'shipment'  => false,
                'value'     => true
            ],
        ];
    }

}
