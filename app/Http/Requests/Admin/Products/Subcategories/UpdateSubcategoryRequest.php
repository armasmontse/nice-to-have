<?php

namespace App\Http\Requests\Admin\Products\Subcategories;

use App\Http\Requests\Request;

class UpdateSubcategoryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_subcategories') ) {
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
        $subcategory = $this->route()->parameters()["subcategory"];

        $rules = [
            "category_id"   => 'required|exists:categories,id',
            "label"         => 'required|array',
            "order"         => 'required|integer|min:0|unique_with:subcategories,order,category_id,'.$subcategory->id,
        ];

        foreach ($this->languages_isos as $languages_iso) {
            $rules["label.".$languages_iso] = "required|max:255";
        }
        return $rules;
    }
}
