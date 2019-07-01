<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\Request;

class UpdateAssociateProductRequest extends Request
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
        $product_editable = $this->route()->parameters()["product_editable"];

        return [
            'products'          => 'array',
            'products.*'        => 'not_in:'.$product_editable->id
        ];
    }
}
