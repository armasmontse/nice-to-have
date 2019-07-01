<?php

namespace App\Http\Requests\Client\Bag;

use App\Http\Requests\Request;
use App\Models\Address\Country;

class CheckoutRequest extends Request
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
                'first_name'            => 'required|max:255',
                'last_name'             => 'required|max:255',
                'phone'                 => 'required|max:255',
                'accept_terms'          => 'accepted',
                'order_total'           => 'required|numeric|min:0',
        ];

        $active_bag = $this->route()->parameters()['active_bag'];
        $input = $this->all();

        // direccion de envio
        if (!$active_bag->bagType->event){
            $mexico = Country::getMexico();

            $rules['address']               = 'required|array';
            $rules['address.contact_name']  = 'string|required';
            $rules['address.phone']         = 'string|required';
            $rules['address.country_id']    = 'required|exists:countries,id';
            $rules['address.state']         = 'required';
            $rules['address.city']          = 'required';
            $rules['address.street1']       = 'required|max:255';
            $rules['address.street2']       = 'present|not_in:-1|max:255';
            $rules['address.street3']       = 'present|max:255';
            $rules['address.zip']           = 'present';
            $rules['address.references']    = 'present|string';
			$rules['address.email']    		= 'present|required_with:message|email';
            // $rules['address.in_zona_metropolitana']     = 'present';

            // si el pais es mexico
            if( isset($input['address']) && is_array($input['address']) &&  isset($input['address']['country_id']) && $input['address']['country_id'] == $mexico->id ){

                $mexico_states_and_mun = Country::getMexicoStatesiWithMunicipies();
                $state = isset($input['address']["state"]) ? $input['address']["state"] : "null";

                $rules['address.state']   .= '|in:'.$mexico_states_and_mun->keys()->implode(",");
                $rules['address.street3'] .= '|required';
                $rules['address.zip']     .= '|required';

                $rules['address.street2'] .= '|required|in:'.( isset($mexico_states_and_mun[$state] )   ? $mexico_states_and_mun[$state]->pluck("NOM_MUN,C,110")->implode(",")   : "null"  );
            }
        }

        // mensaje
        $rules['message'] = 'required_if:print_message,true|string';
        $rules['print_message'] = 'in:true';

        // pago
        $rules['payment_method'] = 'required|in:tarjeta,spei,paypal';

        if ( isset($input['payment_method']) && $input['payment_method'] == 'tarjeta') { // tarjeta

			if (isset($input['other_card']) && $input['other_card']) {
				$rules['conekta_token'] = 'required';
				$rules['card'] = 'required|array';
				$rules['card.last_digits'] = 'required';
				$rules['card.provider'] = 'present';
			}else{
				$rules['card_id'] = 'required|exists:cards,id,user_id,'.$this->user->id;
			}
        }

        if (isset($input['discount_code']) && !empty($input['discount_code'])) {
            $rules['discount_code'] = 'present|alpha_num|discount_code_exists|discount_code_valid|discount_code_not_used';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'message.required_if'                   => 'No olvides el mensaje que irá en tu tarjeta de regalo.',
            'address.state.required'                => 'No has seleccionado un estado',
            'address.street2.present'               => 'No has seleccionado una delegación',
            'address.street2.max'                   => 'El campo delegación no puede ser mayor a 255 caracteres',

            'discount_code.present'                 => 'El campo código de descuento debe estar presente en el formulario',
            'discount_code.alpha_num'               => 'El código de descuento debe ser alfanumérico',
            'discount_code.discount_code_exists'    => 'El código de descuento no existe',
            'discount_code.discount_code_valid'     => 'El código de descuento ya no está vigente',
            'discount_code.discount_code_not_used'  => 'El código de descuento ya fue utilizado'
        ];
    }

}
