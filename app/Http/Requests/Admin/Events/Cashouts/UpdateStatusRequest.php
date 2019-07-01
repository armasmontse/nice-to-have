<?php

namespace App\Http\Requests\Admin\Events\Cashouts;

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
        if ($this->user && $this->user->hasPermission('manage_cashouts') ) {
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
        // $parameters = $this->route()->parameters();
        //
        // $cashout = $parameters['cashout'];

        $rules = [
            'status_id' => 'required|exists:cash_out_statuses,id',
            'status_info' => 'string|nullable',
        ];

        return $rules;
    }
}
