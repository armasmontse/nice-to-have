<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class EventTemplateSectionTypeSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Templates sections types";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "label";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Events\EventTemplateSectionType";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                'slug'      => "texto",
                'label'     => "Texto",
                'rules'     => [
                    'title'     => true,
                    'link'      => false,
                    'html'      => true,
                    'iframe'    => false,
                    'content'   => false,
                    'photo'     => false,
                ]
            ],
            [
                'slug'      => "imagen",
                'label'     => "Imagen",
                'rules'     => [
                    'title'     => false,
                    'link'      => false,
                    'html'      => false,
                    'iframe'    => false,
                    'content'   => false,
                    'photo'     => true,
                ]
            ],
            [
                'slug'      => "video",
                'label'     => "Video",
                'rules'     => [
                    'title'     => true,
                    'link'      => true,
                    'html'      => false,
                    'iframe'    => false,
                    'content'   => false,
                    'photo'     => false,
                ]
            ],
            [
                'slug'      => "mapa",
                'label'     => "Mapa",
                'rules'     => [
                    'title'     => true,
                    'link'      => true,
                    'html'      => false,
                    'iframe'    => false,
                    'content'   => false,
                    'photo'     => false,
                ]
            ]

        ];
    }

    /**
     * metodo de introduccion de valores
     * @param array   $model_args argumentos que definiran el
     * @param Command $comand     comando actual
     */
    protected function ClvoSetUp(array $model_args, Command $comand){

        $model_class = $this->CltvoGetModelClass();

        $model = $model_class::where(["slug" => $model_args["slug"] ])->get()->first();

        if(!$model){
            if ($model_class::create($model_args)) {
                $comand->line(  '<info>'.$model_args[$this->model_label].':</info>'." successfully set.");
            }else{
                $comand->error('<error>'.$model_args[$this->model_label].':</error>'." not successfully set.");
            }
        }else {
            $comand->line('<comment>'.$model_args[$this->model_label].':</comment>'." previously set.");
        }
    }


}
