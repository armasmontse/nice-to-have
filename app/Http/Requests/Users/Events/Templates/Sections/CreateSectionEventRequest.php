<?php

namespace App\Http\Requests\Users\Events\Templates\Sections;

use App\Http\Requests\Request;

class CreateSectionEventRequest extends Request
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
            'section_type_id'  => 'required|integer|exists:event_template_section_types,id',
        ];

        return $rules;

    }
}
