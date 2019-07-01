<?php

namespace App\Http\Requests\Admin\Users;

use App\Http\Requests\Request;
use App\User;
use App\Role;

class CreateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_users') ) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'roles' => 'required',
            'roles.*' => 'required|exists:roles,id'
        ];

        if (!$this->user->isSuperAdmin()) {
            $roleSAdmin = Role::GetSuperAdmin();
            $rules['roles.*'] .= '|not_in:'.$roleSAdmin->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.max' => 'El nombre debe tener 255 caracteres como máximo.',

            'last_name.required' => 'El apellido es obligatorio.',
            'last_name.max' => 'El apellido debe tener 255 caracteres como máximo.',

            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'email.max' => 'El email debe tener 255 caracteres como máximo',
            'email.unique' => 'El email proporcionado ya existe.',

            'roles.required' => 'Asignar un rol es obligatorio.',
            'roles.*.required' => 'Asignar un rol es obligatorio.',
            'roles.*.exist' => 'El rol asignado no existe.',
        ];
    }

}
