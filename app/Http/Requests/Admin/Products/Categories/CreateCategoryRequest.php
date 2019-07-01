<?php

namespace App\Http\Requests\Admin\Products\Categories;

use App\Http\Requests\Request;

class CreateCategoryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_categories') ) {
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
        $rules = [
            "label" => 'required|array',
            "order" => 'required|integer|min:0|unique:categories,order'
        ];
        foreach ($this->languages_isos as $languages_iso) {
            $rules["label.".$languages_iso] = "required|max:255";
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'order.unique' => trans('manage_categories.error.unique')
        ];  
    }
}
