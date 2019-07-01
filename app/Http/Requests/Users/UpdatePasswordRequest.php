<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;

class UpdatePasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "old_password" => "required|password_check:".$this->user->password,
            "password" => "required|confirmed|min:6"

        ];
    }

    public function messages()
    {
        return [

            'old_password.required'         =>  'Olvidaste ingresar tu contraseña.',
            'old_password.password_check'   =>  'La contraseña que ingresaste es incorrecta.',

            'password.required'             =>  'Olvidaste ingresar una nueva contraseña.',
            'password.confirmed'            =>  'Confirma tu contraseña.',
            'password.min'                  =>  'Tu contraseña debe ser de al menos 6 caracteres.',

        ];
    }
}
