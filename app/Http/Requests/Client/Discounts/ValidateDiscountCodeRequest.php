<?php

namespace App\Http\Requests\Client\Discounts;

use App\Http\Requests\Request;
use App\User;

class ValidateDiscountCodeRequest extends Request
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
            'discount_code'  => 'present|alpha_num|discount_code_exists|discount_code_valid|discount_code_not_used'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'discount_code.present'                 =>  'El campo código de descuento debe estar presente en el formulario',
            'discount_code.alpha_num'               =>  'El código de descuento debe ser alfanumérico',
            'discount_code.discount_code_exists'    =>  'El código de descuento no existe',
            'discount_code.discount_code_valid'     =>  'El código de descuento ya no está vigente',
            'discount_code.discount_code_not_used'  =>  'El código de descuento ya fue utilizado'
        ];
    }
}