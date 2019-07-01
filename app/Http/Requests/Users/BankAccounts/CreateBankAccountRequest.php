<?php

namespace App\Http\Requests\Users\BankAccounts;

use App\Http\Requests\Request;

use App\Models\Address\Country;

class CreateBankAccountRequest extends Request
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
            "name"              => "required|string|no_scripts",
            "bank"              => "required|string|no_scripts",
            "branch"            => "present|string|no_scripts",
            "account_number"    => "present|string|no_scripts",
            "CLABE"             => "present|string|digits:18|no_scripts",
        ];

		$input = $this->all();

		if (isset($input["account_number"]) && empty($input["account_number"]) ) {
			$rules["CLABE"] .= "|required";
		}

		if (isset($input["CLABE"]) && empty($input["CLABE"]) ) {
			$rules["account_number"] .= "|required";
			$rules["branch"] .= "|required";
		}

        return $rules;
    }

    public function messages() {
        return [
            'CLABE.present'   			=>  'La CLABE es requerida',
			'CLABE.required'  			=>  'La CLABE es requerida si no hay numero de cuenta',
			'account_number.required'  	=>  'El número de cuenta es requerido sin CLABE',
			'branch.required'  			=>  'La sucursal es requerida sin CLABE',
            'CLABE.string'    			=>  'La CLABE es requerida',
            'CLABE.digits'    			=>  'La CLABE debe tener 18 dígitos',
        ];
    }
}
