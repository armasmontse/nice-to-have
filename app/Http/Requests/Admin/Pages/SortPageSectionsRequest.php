<?php

namespace App\Http\Requests\Admin\Pages;

use App\Http\Requests\Request;

class SortPageSectionsRequest extends Request
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
        $page_edit = $this->route()->parameters()["page_edit"];

        return [
            'sections'          => 'required|array',
            'sections.*'        => 'in:'.$page_edit->sections->implode("id",",")
        ];
    }
}
