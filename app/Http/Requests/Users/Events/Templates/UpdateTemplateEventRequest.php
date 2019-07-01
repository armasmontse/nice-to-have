<?php

namespace App\Http\Requests\Users\Events\Templates;

use App\Http\Requests\Request;

class UpdateTemplateEventRequest extends Request
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
            'template'  => 'required|integer|exists:event_template_headers,id',
            'palette'   => 'required|integer|exists:color_palettes,id'
        ];

        return $rules;

    }
}
