<?php

namespace App\Http\Requests\Admin\Pages;

use App\Http\Requests\Request;

class UpdateAssociateSectionRequest extends Request
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
        $page_section = $this->route()->parameters()["page_section"];

        return [
            'section'          => 'array',
            'section.*'        => 'in:'.$page_section->id
        ];
    }
}
