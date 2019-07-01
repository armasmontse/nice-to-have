<?php

namespace App\Http\Requests\Admin\Pages\Sections;

use App\Http\Requests\Request;

class UpdatePageSectionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_pages') ) {
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
        $page_section   = $this->route()->parameters()["page_section"];

        $rules = [
            'template_path'         => 'required|max:255',
            "description"           => "required|string"
        ];

        if (!$page_section->type->protected) {
            $rules["editable_contents"  ]   = 'array|required';
            $rules["editable_contents.*"]   = 'boolean';
            if (!$page_section->type->unlimited) {
                $rules["components_max"] = 'integer|min:1|required'; // verificar el cambio de este valor
            }
        }

        return $rules;
    }
}
