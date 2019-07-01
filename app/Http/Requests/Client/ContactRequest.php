<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

class ContactRequest extends Request
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
            'full_name'    => 'required|string',
            'email'        => 'required|email|string',
            'phone'        => 'required|string',
            'message'      => 'required|string',
            // 'interest'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required'        => 'No olvides ingresar tu nombre.',
            'full_name.string'          => 'Whoops! hay algo mal en tu nombre.',
            'email.required'            => 'Es necesario que ingreses un correo electrónico para podernos comunicar contigo.',
            'email.email'               => 'Ingresa un email valido.',
            'email.string'              => 'Whoops! hay algo mal en tu email.',
            'phone.required'            => 'Ingresa un teléfono de contacto',
            'phone.string'              => 'Whoops! hay algo mal en tu teléfono.',
            'message.required'          => 'Hey, no olvides ingresar tu mensaje.',
            'message.string'            => 'Whoops! hay algo mal en tu mensaje.',
            // 'interest.required'         => 'Selecciona la opción de tu interés',
        ];
    }
}
