<?php

namespace App\Http\Requests\Admin\Products\Sections;

use App\Http\Requests\Request;

class UpdateSectionRequest extends Request
{
    public function __construct(\Illuminate\Http\Request $request)
    {
        $product_editable = $request->route()->parameters()["product_editable"];
        $request->request->add(['product_id' =>  $product_editable->id ]);
        parent::__construct($request);
    }

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

        $product_section = $this->route()->parameters()["product_section"];

        $rules = [
            "title"         => 'required|array',
            "content"       => 'required|array',
            "order"         => 'required|integer|min:0|unique_with:product_sections,order,product_id,'.$product_section->id
        ];

        foreach ($this->languages_isos as $languages_iso) {
            $rules["title.".$languages_iso]     = "required|max:255";
            $rules["content.".$languages_iso]   = "present";
        }
        return $rules;
    }
}
