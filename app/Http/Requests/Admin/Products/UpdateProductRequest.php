<?php

namespace App\Http\Requests\Admin\Products;

use App\Http\Requests\Request;

class UpdateProductRequest extends Request
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
        $rules = [
            "title"         => 'required|array',
            "description"   => 'required|array',
            "provider_id"   => 'required|exists:providers,id',
            "publish_id"    => 'required|exists:publishes,id',
            "publish_date"  => 'required|date|date_format:Y-m-d',
        ];
        foreach ($this->languages_isos as $languages_iso) {
            $rules["title.".$languages_iso] = "required|max:255";
            $rules["description.".$languages_iso] = "present";
        }
        return $rules;
    }
}
