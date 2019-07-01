<?php

namespace App\Http\Requests\Users\Bags;

use App\Http\Requests\Request;
use App\Models\Address\Country;

use App\Setting;

class CheckoutEventRequest extends Request
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
		$event = $this->route()->parameters()['personal_event'];

		$rules = [
				'first_name'			=> 'required|max:255|no_scripts',
				'last_name'			 => 'required|max:255|no_scripts',
				'phone'				 => 'required|max:255|no_scripts',
				'accept_terms'		  => 'accepted',
				'bag_total'				=> 'required|numeric|min:'.number_format($event->current_checkout_min,2,".",""),
				'cash_out_total'		=> 'required|numeric',
				'order_total'		   => 'required|numeric|min:0',
		];


		if ($event->close_empty_bag) {
			return $rules;
		}

		$active_bag = $event->getCloseBag();
		$input = $this->all();

		// direccion de envio
		$mexico = Country::getMexico();

		$rules['address']			   	= 'required|array';
		$rules['address.contact_name']  = 'string|required|no_scripts';
		$rules['address.phone']		 	= 'string|required|no_scripts';
		$rules['address.email']			= 'present|required_with:message|email';

		$rules['address.country_id']	= 'required|exists:countries,id';
		$rules['address.state']		 	= 'required|no_scripts';
		$rules['address.city']		  	= 'required|no_scripts';
		$rules['address.street1']	   	= 'required|max:255|no_scripts';
		$rules['address.street2']	   	= 'present|not_in:-1|max:255|no_scripts';
		$rules['address.street3']	   	= 'present|max:255|no_scripts';
		$rules['address.zip']		   	= 'present|no_scripts';
		$rules['address.references']	= 'present|string|no_scripts';

		// si el pais es mexico
		if( isset($input['address']) && is_array($input['address']) &&  isset($input['address']['country_id']) && $input['address']['country_id'] == $mexico->id ){

			$mexico_states_and_mun = Country::getMexicoStatesiWithMunicipies();
			$state = isset($input['address']["state"]) ? $input['address']["state"] : "null";

			$rules['address.state']   .= '|in:'.$mexico_states_and_mun->keys()->implode(",");
			$rules['address.street3'] .= '|required';
			$rules['address.zip']	 .= '|required';

			$rules['address.street2'] .= '|required|in:'.( isset($mexico_states_and_mun[$state] )   ? $mexico_states_and_mun[$state]->pluck("NOM_MUN,C,110")->implode(",")   : "null"  );
		}

		// pago
		$rules['payment_method']		= 'required_without:cash_out_required|in:tarjeta,spei,paypal';

		if ( isset($input['payment_method']) && $input['payment_method'] == 'tarjeta') { // tarjeta
			if (isset($input['other_card']) && $input['other_card']) {
				$rules['conekta_token']         = 'required|no_scripts';
				$rules['card']                  = 'required|array';
				$rules['card.last_digits']      = 'required|no_scripts';
				$rules['card.provider']         = 'present|no_scripts';
			}else{

				$rules['card_id']               = 'required|exists:cards,id,user_id,'.$this->user->id;
			}
		}

		// retiro de efectivo

		if (isset($input["cash_out_total"]) && $input["cash_out_total"] > 0) {
			$rules['cash_out_total']				.= '|min:'.Setting::getCashoutMinAmount();
			$rules['cash_out_required']			 	= 'accepted';

			if (isset($input['other_bank_account']) && $input['other_bank_account']) {
				$rules['bank_account']				  	= 'required|array';

				$rules["bank_account.name"]			  	= "required|string|no_scripts";
				$rules["bank_account.bank"]			  	= "required|string|no_scripts";
				$rules["bank_account.branch"]			= "present|string|no_scripts";
				$rules["bank_account.account_number"]	= "present|string|no_scripts";
				$rules["bank_account.CLABE"]			= "present|string|digits:18|no_scripts";

				if (isset($input["bank_account"]) && is_array($input["bank_account"]) ) {
					if (isset($input["bank_account"]["account_number"]) && empty($input["bank_account"]["account_number"]) ) {
						$rules["bank_account.CLABE"] .= "|required";
					}

					if (isset($input["bank_account"]["CLABE"]) && empty($input["bank_account"]["CLABE"]) ) {
						$rules["bank_account.account_number"] .= "|required";
						$rules["bank_account.branch"] .= "|required";
					}
				}
			}else{
				$rules['bank_account_id']			 	= 'required|exists:bank_accounts,id,user_id,'.$this->user->id;
			}
		}

		if (isset($input['discount_code']) && !empty($input['discount_code'])) {
            $rules['discount_code'] = 'present|alpha_num|discount_code_exists|discount_code_valid|discount_code_not_used';
        }

		return $rules;
	}

	public function messages() {
		return [
			'bank_account.CLABE.present'   			=> 'La CLABE es requerida',
			'bank_account.CLABE.required'  			=> 'La CLABE es requerida si no hay numero de cuenta',
			'bank_account.account_number.required' 	=> 'El número de cuenta es requerido sin CLABE',
			'bank_account.branch.required'  		=> 'La sucursal es requerida sin CLABE',
			'bank_account.CLABE.string'    			=> 'La CLABE es requerida',
			'bank_account.CLABE.digits'    			=> 'La CLABE debe tener 18 dígitos',

			'address.state.required' 				=> 'No has seleccionado un estado',
			'address.state.in' 						=> 'No has seleccionado un estado',
            'address.street2.present' 				=> 'No has seleccionado una delegación',
            'address.street2.in' 					=> 'No has seleccionado una delegación',
            'address.street2.max' 					=> 'El campo delegación no puede ser mayor a 255 caracteres',

			'discount_code.present'                 => 'El campo código de descuento debe estar presente en el formulario',
            'discount_code.alpha_num'               => 'El código de descuento debe ser alfanumérico',
            'discount_code.discount_code_exists'    => 'El código de descuento no existe',
            'discount_code.discount_code_valid'     => 'El código de descuento ya no está vigente',
            'discount_code.discount_code_not_used'  => 'El código de descuento ya fue utilizado'
		];
	}

}
