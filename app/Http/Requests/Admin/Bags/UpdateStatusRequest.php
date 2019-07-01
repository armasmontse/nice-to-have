<?php

namespace App\Http\Requests\Admin\Bags;

use App\Http\Requests\Request;

class UpdateStatusRequest extends Request
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
        $parameters = $this->route()->parameters();

        $admin_payed_bag = $parameters['admin_payed_bag'];

        $rules = [
            'status_id' => 'required|exists:bag_statuses,id|is_valid_status_for_type: ' . $admin_payed_bag->bagType->id,
            'status_info' => 'string|nullable',
        ];

        return $rules;
    }
}
