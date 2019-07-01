<?php

namespace App\Http\Requests\Users\Events\Templates\Sections;

use App\Http\Requests\Request;

class SortSectionsEventRequest extends Request
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
        $input= $this->all();

		$sections = isset($input['section_id'])  ? $input['section_id'] : [];

        $rules = [
            'section_id'  => 'required|array',
        ];

        foreach ($sections as $key => $section) {
            $rules['section_id.' . $key] = 'integer|exists:event_template_sections,id';
        }

        return $rules;

    }
}
