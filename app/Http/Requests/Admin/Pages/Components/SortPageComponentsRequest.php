<?php

namespace App\Http\Requests\Admin\Pages\Components;

use App\Http\Requests\Request;

class SortPageComponentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && ($this->user->hasPermission('manage_pages_contents') || $this->user->hasPermission('manage_pages')  ) ) {
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

        if (!$page_section->type->sortable) {
            return [
                "sortable"     => 'required'
            ];
        }
        return [
            'components'          => 'required|array',
            'components.*'        => 'in:'.$page_section->components->implode("id",",")
        ];
    }
}
