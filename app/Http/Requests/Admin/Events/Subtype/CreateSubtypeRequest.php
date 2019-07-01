<?php

namespace App\Http\Requests\Admin\Events\Subtype;

use App\Http\Requests\Request;

class CreateSubtypeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_subtypes') ) {
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
            "type_id"       => 'required|exists:types,id',
            "label"         => 'required|array',
            "order"         => 'required|integer|min:0|unique_with:subtypes,order,type_id'
        ];

        foreach ($this->languages_isos as $languages_iso) {
            $rules["label.".$languages_iso] = "required|max:255";
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'order.unique_with' => trans('manage_subtypes.error.unique_with')
        ];  
    }
}
