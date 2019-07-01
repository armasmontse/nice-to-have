<?php
namespace App\Models\Traits\User;

use App\Role;
use Auth;
use App\User;

trait PermissionRoleTrait {

    /**
     * genera la colleccion de roles de este usuario
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function roleLists()
    {
        return $this->roles->pluck("id")->toArray();
    }

    /**
     * Asigna un role a un usuario
     * @param  Role $roleSlug a ser asignado
     */
    public function assignRole(Role $role)
    {
        if (!$this->roles()->find($role->id) ) {
            return $this->roles()->save($role);
        }
        return false;
    }

    /**
     * Asigna un role a un usuario
     * @param  string $roleSlug Nombre del role
     */
    public function assignRoleBySlug($role_slug)
    {
        $role = Role::getRoleBySlug($role_slug);
        if ($role) {
            return $this->assignRole($role);
        }
        return false;
    }

    /**
     * Asigna un role a un usuario por id
     */
     public function assignRoleByID($role_id)
     {
        $role = Role::find($role_id);
        if ($role) {
            return $this->assignRole($role);
        }
        return false;
     }

    /**
     * Asigna un role a un usuario
     * @param  Role $roleSlug a ser asignado
     */
    public function detachRole(Role $role)
    {
        if ($this->roles()->find($role->id) ) {
            return $this->roles()->detach($role);
        }
        return false;
    }


    /**
     * Asigna un role a un usuario
     * @param  string $roleSlug Nombre del role
     */
    public function detachRoleBySlug($role_slug)
    {
        $role = Role::getRoleBySlug($role_slug);
        if ($role) {
            return $this->detachRole($role);
        }
        return false;
    }

    public function hasNoRoles()
    {
        return $this->roles->count() == 0;
    }

    public function getFirstRoleId()
    {
        $firstRole = $this->roles->first();
        return $firstRole ?  $firstRole->id : null ;
    }


    /**
     * verifica si un usuario es superadmin
     * @return boolean
     */
    public function isSuperAdmin()
    {
        return $this->roles()->CollectSuperAdminRoles()->count() > 0;
    }


    /**
     * Verifica que un usuario   tenga los permisos
     * @return boolean true en caso asignado , false en caso contrario
     */
    public function hasPermission($permissionSlug)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (is_array($permissionSlug)) {
            return $this->roles()->with("permissions")->whereHas("permissions",function($q) use ($permissionSlug){
                $q->whereIn("slug",$permissionSlug);
            })->get()->count() > 0;
        }

        return $this->roles()->with("permissions")->whereHas("permissions",function($q) use ($permissionSlug){
            $q->where("slug",$permissionSlug);
        })->get()->count() > 0;
    }


///////////////////////////////////
    public function rolesListToSelect()
    {
        if ($this->isSuperAdmin() ) {
            $roles = role::get();
        }else{
            $roles = role::CollectNotSuperAdminRoles();
        }

        return $roles->pluck("label","id")->toArray();
    }


    public function scopeSuperAdminFilter($query, User $user = null)
    {
        $user = is_null($user) ? Auth::user() : $user;
        if (!$user || !$user->isSuperAdmin()) { // si no es super admin que no modifique super admins
            return $query->whereDoesntHave("roles",function($q) {
                $q->where("slug" , "=", Role::SUPER_ADMIN_SLUG);
            });
        }
        return $query;

    }
}
