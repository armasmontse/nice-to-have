<?php

namespace App\Http\Requests\Users\Events;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateEventRequest extends Request
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
		$input= $this->all();
		$type_id = isset($input['type_id'])  ? $input['type_id'] : null;
        $rules = [

			'type_id'			=> 'required|exists:types,id',
			'subtype_id'		=> [
				'present',
				Rule::exists('subtypes','id')
					->where(function ($query) use ($type_id) {
						return $query->where("type_id","=",$type_id);
					})
			],
	        'name'				=> "required|string|max:255|no_scripts",
			'feted_names'		=> "required|string|no_scripts",
			"date"				=> "required|date|date_format:Y-m-d|after:yesterday",

			'accept'			=> "accepted",
			'exclusive'			=> "required|boolean",
        ];

        return $rules;

    }

    public function messages() {
        return [
            'date.date_format:Y-m-d'    => 'El formato de fecha deber ser aaaa-mm-dd',
            'date.after'                => 'La fecha debe ser a partir de hoy.',
        ];
    }
}
