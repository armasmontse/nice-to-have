<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

use App\User;

use App\Role;

class AdminsUserSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Admin Users";

    /**
     * nombre de la clase a ser sembrada
     */
    protected function CltvoGetModelClass(){
        return "";
    }

    /**
     * valores a ser introducidos en la base
     */
    protected function CltvoGetItems(){
        return [
            [
                [
                    'name'              => 'mara-loera',
                    'first_name'        => 'Mara',
                    'last_name'         => 'Loera',
                    'email'             => 'mara@nicetohave.com.mx',
                    'password'          => bcrypt(str_random(10)),
                    'active'            => true
                ],
				[
					'name'              => 'admin-cultivo',
					'first_name'        => 'admin',
					'last_name'         => 'cultivo',
					'email'             => 'admin@elcultivo.mx',
					'password'          => 'admin',
					'active'            => true
				],
            ]

        ];
    }

    /**
     * metodo de introduccion de valores
     * @param array   $model_args argumentos que definiran el
     * @param Command $comand     comando actual
     */
    protected function ClvoSetUp(array $model_args, Command $comand){

        foreach ($model_args as $args) {

            $user = User::withTrashed()->where(["name" => $args["name"]  ])->orWhere(["email" => $args["email"]  ])->get()->first();

            if(!$user){
                $user = User::CltvoCreate($args);
                if ($user) {
                    $comand->line('<info>'.$args["name"].':</info>'." successfully set.");
                }else{
                    $comand->line('<error>'.$args["name"].':</error>'." not successfully set.");
                    return;
                }
            }else {
                $comand->line('<comment>'.$args["name"].':</comment>'." previously set.");
            }

            $admin = Role::getAdmin();

            if ($admin) {
                if (!$user->roles()->get()->find($admin) ) {
                    if ($user->roles()->save($admin)) {
                        $comand->line('<info>'.$admin->label.':</info>'." successfully associated with ".$args["name"].".");
                    }else{
                        $comand->line('<error>'.$admin->label.':</error>'." not successfully associated with ".$args["name"].".");
                        return;
                    }
                }else {
                    $comand->line('<comment>'.$admin->label.':</comment>'." role previously associate with ".$args["name"].".");
                }

            }else{
                $comand->error("Role not exist.");
                return;
            }

        }

    }

}
