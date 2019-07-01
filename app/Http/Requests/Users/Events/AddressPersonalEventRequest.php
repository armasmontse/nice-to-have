<?php

namespace App\Http\Requests\Users\Events;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

use App\Models\Address\Country;

class AddressPersonalEventRequest extends Request
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
        $input = $this->all();
        $mexico = Country::getMexico();
		$rules = [];
		$rules['address']  				= 'required|array';
        $rules['address.contact_name']  = 'string|required|no_scripts';
        $rules['address.phone']         = 'string|required|no_scripts';
		$rules['address.email']         = 'email|required';
        $rules['address.country_id']    = 'required|exists:countries,id';
        $rules['address.state']         = 'required|no_scripts';
        $rules['address.city']          = 'required|no_scripts';
        $rules['address.street1']       = 'required|max:255|no_scripts';
        $rules['address.street2']       = 'present|not_in:-1|max:255|no_scripts';
        $rules['address.street3']       = 'present|max:255|no_scripts';
        $rules['address.zip']           = 'present|no_scripts';
        $rules['address.references']    = 'present|string|no_scripts';

    // si el pais es mexico
        if( isset($input['address']) && is_array($input['address']) && isset($input['address']['country_id']) && $input['address']['country_id'] == $mexico->id ){
            $mexico_states_and_mun = Country::getMexicoStatesiWithMunicipies();
            $state = isset($input['address']["state"]) ? $input['address']["state"] : "null";
            $rules['address.state']   .= '|in:'.$mexico_states_and_mun->keys()->implode(",");
            $rules['address.street3'] .= '|required';
            $rules['address.zip']     .= '|required';

            $rules['address.street2'] .= '|required|in:'.( isset($mexico_states_and_mun[$state] )   ? $mexico_states_and_mun[$state]->pluck("NOM_MUN,C,110")->implode(",")   : "null"  );
        }

		return $rules;

    }

    public function messages() {
        return [

            'address.country_id.required' => 'No has seleccionado un país',
            'address.country_id.exists' => 'No has seleccionado un país',

            'address.state.required' => 'No has seleccionado un estado',
            'address.state.in' => 'ys',

            'address.street2.present' => 'No has seleccionado una delegación',
            'address.street2.max' => 'El campo delegación no puede ser mayor a 255 caracteres.'

        ];
    }
}
