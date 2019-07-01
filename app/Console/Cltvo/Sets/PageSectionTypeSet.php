<?php

namespace App\Console\Cltvo\Sets;

use Illuminate\Console\Command;

class PageSectionTypeSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Tipos de secciones de páginas";

    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Pages\Sections\Type";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){

        return [
            [
                "label"             => "Especial",
                "description"       => "Sección que requiere información de modelos diferentes a los componenetes",
                "admin_view_path"   => "protected",
                "protected"         => true,
                "unlimited"         => false,
                'sortable'          => false
            ],
            [
                "label"             => "Fija",
                "description"       => "Sección que requiere información de una cantidad exacta de componentes",
                "admin_view_path"   => "multiple-fixed",
                "protected"         => false,
                "unlimited"         => false,
                'sortable'          => false
            ],
            [
                "label"             => "Múltiple limitada",
                "description"       => "Sección que requiere información de una cantidad exacta de componentes que pueden ordenarse",
                "admin_view_path"   => "multiple-limited",
                "protected"         => false,
                "unlimited"         => false,
                'sortable'          => true
            ],
            [
                "label"             => "Múltiple ilimitada",
                "description"       => "Sección que requiere información de una cantidad ilimitada de componentes que pueden ordenarse",
                "admin_view_path"   => "multiple-unlimited",
                "protected"         => false,
                "unlimited"         => true,
                'sortable'          => true
            ]
        ];
    }

}
