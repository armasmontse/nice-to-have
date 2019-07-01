<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\Request;

class UpdateEmailRequest extends Request
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
            "password" => "required|password_check:".$this->user->password,
            "email" => "required|email|max:255|unique:users,email,".$this->user->id.",id|not_in:".$this->user->email
        ];
    }

    public function messages()
    {
        return [
            'password.required'         =>  'Olvidaste ingresar tu contraseña.',
            'password.password_check'   =>  'La contraseña que ingresaste es incorrecta.',

            'email.required'            =>  'Olvidaste ingresar tu correo electrónico.',
            'email.email'               =>  'Ingresa una dirección de correo electrónico válida.',
            'email.max'                 =>  'El campo correo electrónico no puede ser mayor a 255 caracteres.',
            'email.unique'              =>  'La dirección de correo electrónico ya ha sido registrada.',
            'email.not_in'              =>  'La dirección de correo electrónico es inválida.',
        ];
    }
}
