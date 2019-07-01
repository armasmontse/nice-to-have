<?php

namespace App\Http\Requests\Users\Events;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FinishPersonalEventRequest extends Request
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

		if ($personal_event->is_publish) {
			return [];
		}

		return [
			"active"	=> 'required|in:'.str_random(24),
		];

    }

    public function messages() {
        return [
			'active.required'	=> "El evento no puede ser cerrado.",
			'active.in'		=> "El evento no puede ser cerrado.",
        ];
    }
}
