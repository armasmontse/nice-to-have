<?php

namespace App\Http\Requests\Client\Bag;

use App\Http\Requests\Request;
// use \Illuminate\Http\Request;

use App\User;

class AddToBagRequest extends Request
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
        $new_bag = $this->route()->parameters()['new_bag'];

        $rules = [
            "sku"       => "required|exists:skus,sku|published:sku|not_in_bag:".$new_bag->id,
            "quantity"  => "required|integer|min:1",
        ];

        // if ($new_bag->event) {
        //     $rules['sku'] .= "|product_not_in_event:".$new_bag->event->id;
        // }

        return $rules;
    }

    public function messages()
    {
        return [

            'sku.required'              =>  'Es necesario que selecciones un producto',
            'sku.exists'                =>  'El producto seleccionado no existe',
            'sku.published'             =>  'El producto seleccionado no está publicado',
            'sku.not_in_bag'            =>  'Ya haz agregado anteriormente este producto a tu bolsa',
            'sku.product_not_in_event'  =>  'Whoops, parece que ese producto ya esta en la mesa de regalos del evento.',
            'quantity.required'         =>  'Es necesario que selecciones la cantidad de productos',
            'quantity.integer'          =>  'La cantidad de productos tiene que ser un valor entero',
            'quantity.min'              =>  'Elije al menos un producto',

        ];
    }
}
