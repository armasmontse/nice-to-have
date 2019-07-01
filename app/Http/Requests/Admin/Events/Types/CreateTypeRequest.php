<?php

namespace App\Http\Requests\Admin\Events\Types;

use App\Http\Requests\Request;

class CreateTypeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_types') ) {
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
            "label"         => 'required|array',
            "title"         => 'required|array',
            "description"   => 'required|array',
            "order"         => 'required|integer|min:0|unique:types,order'
        ];
        foreach ($this->languages_isos as $languages_iso) {
            $rules["label.".$languages_iso] = "required|max:255";
            $rules["title.".$languages_iso] = "present|max:255";
            $rules["description.".$languages_iso] = "present";
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'order.unique' => trans('manage_types.error.unique')
        ];  
    }
}
 