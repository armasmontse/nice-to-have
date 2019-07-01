<?php

namespace App\Http\Requests\Users\Events;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PublishPersonalEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$personal_event = $this->route()->parameters()['personal_event'];

        $rules = [];

		if (!$personal_event->is_draft) {
			$rules["inactive"] = 'required|in:'.str_random(24);
		}

		if (!$personal_event->getMainAddress()) {
			$rules["address"] = 'required|in:'.str_random(24);
		}

        if ($this->user->bank_accounts->isEmpty()) {
            $rules["bank_account"] = 'required|in:'.str_random(24);
        }

		return $rules;
    }

    public function messages() {
        return [
			'inactive.required'      => "El evento ya fue activado anteriormente.",
			'inactive.in'            => "El evento ya fue activado anteriormente.",
			'address.required'       => "El evento requiere dirección para ser activado.",
			'address.in'             => "El evento requiere dirección para ser activado.",
            'bank_account.required'  => "El evento requiere una cuenta registrada para retiros para ser activado.",
            'bank_account.in'        => "El evento requiere una cuenta registrada para retiros para ser activado."
        ];
    }
}
