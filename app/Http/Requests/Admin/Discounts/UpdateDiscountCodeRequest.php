<?php

namespace App\Http\Requests\Admin\Discounts;

use App\Http\Requests\Request;
use App\Models\Shop\Discounts\DiscountCode;

class UpdateDiscountCodeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_discount_codes') ) {
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
            'initial_date'  => 'present|date|date_format:Y-m-d|before_or_equal:end_date',
            'end_date'      => 'present|date|date_format:Y-m-d|after_or_equal:initial_date'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'initial_date.present'          => 'La fecha de inicio debe estar presente.',
            'initial_date.date'             => 'La fecha de inicio debe ser una fecha válida.',
            'initial_date.date_format'      => 'La fecha de inicio debe tener el formato correcto.',
            'initial_date.before_or_equal'  => 'La fecha de inicio debe ser anterior o igual a la fecha de caducidad.',

            'end_date.present'              => 'La fecha de caducidad debe estar presente.',
            'end_date.date'                 => 'La fecha de caducidad debe ser una fecha válida.',
            'end_date.date_format'          => 'La fecha de caducidad debe tener el formato correcto.',
            'end_date.after_or_equal'       => 'La fecha de caducidad debe ser posterior o igual a la fecha de inicio.'
        ];
    }

}
