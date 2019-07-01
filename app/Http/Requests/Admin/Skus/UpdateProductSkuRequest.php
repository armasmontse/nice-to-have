<?php

namespace App\Http\Requests\Admin\Skus;

use App\Http\Requests\Request;

class UpdateProductSkuRequest extends Request
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
        $product_sku = $this->route()->parameters()["product_sku"];

		$input = $this->all();
        $rules = [
            "price"                     => "required|numeric|min:0",
            "local_shipping_rate"       => "required|numeric|min:0",
            "national_shipping_rate"    => "required|numeric|min:0",
            "discount"                  => "required|integer|min:0|max:100",
            "description"               => 'required|array',
        ];

        if (isset($input["default"]) && !$product_sku->default) {
            $rules[ "default"] = "not_default_sku:".$product_editable->id;
        }

        foreach ($this->languages_isos as $languages_iso) {
            $rules["description.".$languages_iso]     = "required";
        }
        return $rules;
    }
}
