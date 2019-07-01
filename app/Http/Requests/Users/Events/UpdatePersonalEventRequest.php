<?php

namespace App\Http\Requests\Users\Events;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class UpdatePersonalEventRequest extends Request
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

		if ($personal_event->is_finish) {
			return [
				"not_finish"	=> 'required|in:'.str_random(24),
			];
		}

		$input= $this->all();
		// dd($input);
		$type_id = isset($input['type_id'])  ? $input['type_id'] : null;
		$time_zones = implode(",", timezone_identifiers_list());
        $day_before = $personal_event->date->copy()->subDay();

		$rules = [
			"date"				=> "required|date|date_format:Y-m-d|after:".$day_before->format("Y-m-d"),
			"hour"				=> "required|date_format:H:i",
			"timezone"			=> 'required|timezone|in:'."$time_zones"
		];

		if ($personal_event->is_draft) {
			$rules ['type_id']			= 'required|exists:types,id';
			$rules ['subtype_id']		= [
				'present',
				Rule::exists('subtypes','id')
					->where(function ($query) use ($type_id) {
						return $query->where("type_id","=",$type_id);
					})
			];
			$rules ['slug']				= [
				"required",
				"string",
				"max:255",
				'alpha_dash',
				Rule::unique('events')->ignore($personal_event->id,"id"),
			];
	        $rules ['name']				= "required|string|max:255";
			$rules ['feted_names']		= "required|string";
		}

		return  $rules;
    }

    public function messages() {
        return [
			'not_finish.required'	=> "El evento ya se encuentra cerrado.",
			'not_finish.in'		    => "El evento ya se encuentra cerrado.",
        ];
    }
}
