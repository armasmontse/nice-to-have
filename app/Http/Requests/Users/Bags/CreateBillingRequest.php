<?php

namespace App\Http\Requests\Users\Bags;

use App\Http\Requests\Request;

use App\Models\Address\Country;

class CreateBillingRequest extends Request
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



        $rules = [
            "rfc"               => "required|max:255",
            "razon_social"      => "required|max:255",
            'info'              => "present",
        ];

        $rules['address']               = 'required|array';
        $rules['address.email']         = 'required|email';
        $rules['address.contact_name']  = 'string|required|no_scripts';
        $rules['address.phone']         = 'string|required|no_scripts';
        $rules['address.country_id']    = 'required|exists:countries,id';
        $rules['address.state']         = 'required|no_scripts';
        $rules['address.city']          = 'required|no_scripts';
        $rules['address.street1']       = 'required|max:255|no_scripts';
        $rules['address.street2']       = 'present|not_in:-1|max:255|no_scripts';
        $rules['address.street3']       = 'present|max:255|no_scripts';
        $rules['address.zip']           = 'present|no_scripts';
        $rules['address.references']    = 'present|string|no_scripts';

    // si el pais es mexico
        $input = $this->all();
        $mexico = Country::getMexico();
        if( isset($input['address']) && is_array($input['address']) &&  isset($input['address']['country_id']) && $input['address']['country_id'] == $mexico->id ){

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

            'rfc.required'                      =>  'Por favor, ingresa tu RFC.',
            'rfc.max'                           =>  'El campo RFC no puede ser mayor a 255 caracteres.',

            'razon_social.required'             =>  'Por favor, ingresa tu Razón Social.',
            'razon_social.max'                  =>  'El campo Razón Social no puede ser mayor a 255 caracteres.',

            'info.present'                      =>  'Encontramos un error al solicitar tu factura.',

            'address.contact_name.string'       =>  'Lo sentimos, el campo Nombre sólo acepta letras.',
            'address.contact_name.required'     =>  'Por favor, ingresa tu nombre.',

            'address.email.required'            =>  'Por favor, ingresa tu correo electrónico.',
            'address.email.email'               =>  'Por favor, ingresa un correo electrónico válido.',

            'address.phone.string'              =>  'Lo sentimos, el campo teléfono solo acepta números.',
            'address.phone.required'            =>  'Por favor, ingresa tu teléfono.',

            'address.country_id.required'       =>  'Por favor, selecciona un País.',
            'address.country_id.exists'         =>  'No pudimos encontrar el País seleccionado.',

            'address.state.required'            =>  'Por favor, ingresa un Estado.',
            'address.state.in'                  =>  'No pudimos encontrar el Estado que ingresaste.',

            'address.city.required'             =>  'Pr favor, ingresa tu Ciudad.',

            'address.street1.required'          =>  'Por favor, ingresa la calle y el número de destino.',
            'address.street1.max'               =>  'El campo calle y número no puede ser mayor a 255 caracteres.',

            'address.street2.required'          =>  'Por favor, ingresa una Delegación.',
            'address.street2.max'               =>  'El campo Delegación no puede ser mayor a 255 caracteres.',
            'address.street2.max'               =>  'No pudimos encontrar la Delegación que ingresaste.',

            'address.street3.required'          =>  'Por favor, ingresa la colonia.',
            'address.street3.max'               =>  'El campo colonia no puede ser mayor a 255 caracteres.',

            'address.zip.present'               =>  'El Código Postal no es válido.',
            'address.zip.required'              =>  'Por favor, ingresa el Código Postal.',

            'address.references.present'        =>  'Encontramos un problema con el campo referencia.',
            'address.references.string'         =>  'Lo sentimos, el campo referencia sólo acepta letras.',

        ];
    }
}
