<?php

namespace App\Console\Cltvo\Sets;

use App\Console\Cltvo\Sets\CltvoSet;
use Illuminate\Console\Command;

use App\Role;
use App\Permission;

class AssociatePermissionRoleSet extends CltvoSet
{
    /**
     * Etiqueta a desplegarse par ainformar final
     */
    protected $label =  "Associate permissions and roles";

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
                "role"          => "super_admin",
                "permissions"   => []
            ],
            [
                "role"          => "admin",
                "permissions"   => [
					"admin_access",
					"system_config",

                    "manage_users",
					"manage_photos",

                    "manage_pages_contents",

                    "manage_providers",
					"manage_types",
					"manage_subtypes",

					"manage_categories",
					"manage_subcategories",
                    "manage_products",

                    "associate_photos",

                    "manage_events",
                    "manage_bags",
                    "manage_cashouts",

                    'manage_discount_codes'
                ]
            ],
        ];
    }

    /**
     * metodo de introduccion de valores
     * @param array   $model_args argumentos que definiran el
     * @param Command $comand     comando actual
     */
    protected function ClvoSetUp(array $model_args, Command $comand){
        $role = Role::where(["slug"=> $model_args["role"]])->get()->first();

        if (!$role) {
            $comand->error($model_args["role"]." role not exist.");
            return ;
        }

        if( $role->isSuperAdmin() ){
            foreach (Permission::get() as $permission) {
                $this->AssociatePermissionAndRole($role,$permission,$comand);
            }
        }

        foreach ($model_args["permissions"] as $permission_slug) {
            $permission = Permission::where(["slug"=> $permission_slug])->get()->first();
            if (!$permission) {
                $comand->error($permission_slug." permission not exist.");
                return ;
            }
            $this->AssociatePermissionAndRole($role,$permission,$comand);
        }
    }

    protected function AssociatePermissionAndRole(Role $role, Permission $permission,Command $comand)
    {
        if(!$role->permissions()->get()->find($permission)){
            if ($role->permissions()->save($permission)) {
                $comand->line('<info>'.$permission->label.':</info>'." successfully associated with ".$role->label.".");
            }else{
                $comand->line('<error>'.$permission->label.':</error>'." not successfully associated with ".$role->label.".");
            }
        }else {
            $comand->line('<comment>'.$permission->label.':</comment>'." previously associate with ".$role->label.".");
        }
    }

}
