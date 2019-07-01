<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

class ConfirmAttendanceRequest extends Request
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
            'g-recaptcha-response' => 'required|captcha',
            'inputname'            => 'required|string',
            'email'                => 'required|string',
        ];
    }

    public function messages()
    {
        return [

            'g-recaptcha-response.required' =>  'Antes de enviar tu confirmación de asistencia, necesitamos confirmar que eres un ser humano. Marca la casilla reCAPTCHA y haz clic en el botón "ENVIAR".',
            'g-recaptcha-response.captcha'  =>  'Encontramos un error con el campo reCAPTCHA',

            'inputname.required'            =>  'Olvidaste ingresar los nombres de los invitados.',
            'inputname.string'              =>  'Ingresa los nombres separados por comas.',

            'email.required'                =>  'Olvidaste ingresar los nombres de los invitados.',
            'email.string'                  =>  'Ingresa una dirección de correo electrónico válida',
        ];
    }
}
