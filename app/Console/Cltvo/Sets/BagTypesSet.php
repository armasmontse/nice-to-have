<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

class BagTypesSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Bag Types";

    /**
     * etiqueta del display del modelo
     * @var string
     */
    protected $model_label =  "label";


    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "App\Models\Shop\BagType";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                "event"         => true,
                "special"       => true,
                "protected"     => true,
                'register_user' => false,
                "slug"          => "mesa-de-regalos",
                "label"         => "Mesa de regalos protegida",
                "default_key"   => "000000000000000",
            ],
            [
                "event"         => true,
                "special"       => true,
                "protected"     => false,
                'register_user' => false,
                "slug"          => "retirar-mesa-de-regalos",
                "label"         => "Mi mesa de regalos",
                "default_key"   => "100000000001000",
            ],
            [
                "event"         => true,
                "special"       => false,
                "protected"     => false,
                'register_user' => false,
                "slug"          => "agregar-a-mesa-de-regalos",
                "label"         => "Mesa de regalos",
                "default_key"   => "100000000000100",
            ],
            // [
            //     "event"         => false,
            //     "special"       => false,
            //     "protected"     => false,
            //     'register_user' => true,
            //     "slug"          => "regalo",
            //     "label"         => "Regalo",
            //     "default_key"   => "100000000000010",
            // ],
            [
                "event"         => false,
                "special"       => false,
                "protected"     => false,
                'register_user' => false,
                "slug"          => "personal",
                "label"         => "Personal",
                "default_key"   => "100000000000000",
            ],
        ];
    }

    /**
     * metodo de introduccion de valores
     * @param array   $model_args argumentos que definiran el
     * @param Command $comand     comando actual
     */
    protected function ClvoSetUp(array $model_args, Command $comand){

        $model_class = $this->CltvoGetModelClass();

        $args = $model_args;
        if(isset($args['translations']))
        {
            unset($args['translations']);
        }
        $model = $model_class::where(["slug" => $args["slug"]])->get()->first();

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
