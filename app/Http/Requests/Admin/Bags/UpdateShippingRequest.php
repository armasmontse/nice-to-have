<?php

namespace App\Http\Requests\Admin\Bags;

use App\Http\Requests\Request;

class UpdateShippingRequest extends Request
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
        // $active_status = BagStatus::where(['paid' => true, 'cancel' => false ])->get();

        $parameters = $this->route()->parameters();

        $admin_payed_bag = $parameters['admin_payed_bag'];

        $rules = [
            'shipping_tracking_code' => 'string|nullable',
            'shipping_method' => 'string|required',
            'shipping_info' => 'string|required',
        ];

        return $rules;
    }
}
