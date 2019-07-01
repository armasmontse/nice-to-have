<?php

namespace App\Http\Requests\Client\Events;

use App\Http\Requests\Request;

class EventsSearchRequest extends Request
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
            's'    => 'string|max:255',
        ];
    }

    public function messages()
    {
        return [
            's'        => 'El campo de busqueda debe ser una texto',
            's'        => 'El campo de busqueda no debe exdeder los 255 caracteres',
        ];
    }
}
