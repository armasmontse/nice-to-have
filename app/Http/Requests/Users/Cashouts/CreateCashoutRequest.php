<?php

namespace App\Http\Requests\Users\Cashouts;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

use App\Setting;

class CreateCashoutRequest extends Request
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
		$personal_event = $this->route()->parameters()["personal_event"];
		$user_id =	$this->route()->parameters()["user"]->id;
		if (!$personal_event->is_publish) {
			return [
				"not_publish"			=> 'required|in:'.str_random(24),
			];
		}

		if ($personal_event->is_publish && !$personal_event->not_canceled_cash_outs->isEmpty()) {
			return [
				"only_one"			=> 'required|in:'.str_random(24),
			];
		}

		$cashout_min_amount = Setting::getCashoutMinAmount();

		if ($cashout_min_amount > $personal_event->current_cashouts_max ) {
			return [
				'not_min_amount'	=> 'required|in:'.str_random(24),
			];
		}


        $rules = [
			"bank_account_id" => [
				"required",
				Rule::exists('bank_accounts','id')
					->where(function ($query) use ($user_id) {
						return $query->where("user_id","=",$user_id);
					})

			],
			"amount"		=> 'numeric|between:'.$cashout_min_amount.','.number_format($personal_event->current_cashouts_max,2,'.','')
        ];

        return $rules;
    }

	public function messages() {
		$cashout_min_amount = Setting::getCashoutMinAmount();
        return [
			'not_publish.required'		=> "No se pueden solicitar retiros de efectivo si el evento esta inactivo.",
			'not_publish.in'				=> "No se pueden solicitar retiros de efectivo si el evento esta inactivo.",
			'only_one.required'			=> "Sólo pueden solicitar un retiro de efectivo.",
			'only_one.in'				=> "Sólo pueden solicitar un retiro de efectivo.",

			'not_min_amount.required'	=> "El efectivo disponible debe ser mayor a $".number_format($cashout_min_amount,2,".",",")." MXN para solicitar un retiro.",
			'not_min_amount.in'			=> "El disponible en efectivo debe ser mayor a $".number_format($cashout_min_amount,2,".",",")." MXN para solicitar un retiro.",
        ];
    }
}
