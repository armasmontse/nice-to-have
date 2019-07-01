<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\Request;

class UpdateAssociateSubtypeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_products') ) {
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
        $subtype = $this->route()->parameters()["subtype"];

        return [
            'subtypes'          => 'array',
            'subtypes.*'        => 'in:'.$subtype->id
        ];
    }
}
