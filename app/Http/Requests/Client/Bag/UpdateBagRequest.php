<?php

namespace App\Http\Requests\Client\Bag;

use App\Http\Requests\Request;
// use \Illuminate\Http\Request;

use App\User;

class UpdateBagRequest extends Request
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
        $rules = [
            "quantity"  => "required|integer|min:1",
        ];

        return $rules;
    }

    public function messages()
    {
        return [

            'quantity.required'         =>  'Es necesario que selecciones la cantidad de productos',
            'quantity.integer'          =>  'La cantidad de productos tiene que ser un valor entero',
            'quantity.min'              =>  'Elige al menos un producto',

        ];
    }
}
