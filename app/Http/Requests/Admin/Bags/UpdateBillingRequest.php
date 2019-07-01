<?php

namespace App\Http\Requests\Admin\Bags;

use App\Http\Requests\Request;

class UpdateBillingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('manage_bags') ) {
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
            'billing_status' => 'required|string',
        ];

        return $rules;
    }
}
