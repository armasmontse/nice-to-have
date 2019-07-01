<?php

namespace App\Http\Requests\Admin\Products\Providers;

use App\Http\Requests\Request;

class CreateProviderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_providers') ) {
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
        return [
            "label" => "required|max:255"
        ];
    }
}
