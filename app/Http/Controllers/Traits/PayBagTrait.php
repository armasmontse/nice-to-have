<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Mail;
use App\Mail\Cltvo\FatalErrorMail;

use App\Models\Shop\Bag;
use App\Models\Shop\BagStatus;

trait PayBagTrait
{

	protected function getEventCharge(array $input, array $totals, Bag &$active_bag)
	{

		if (array_sum($totals) > 0) {
			return $this->getCharge($input, $totals, $active_bag);
		}

		return [
			"paypal_url" => null,
			"errors"    => null,
			"charge"    => (object) [
				'id'			=> $active_bag->key,
				'status' 		=> "paid",
				'payment_method'=> (object)[
					'object'	=> 'gift_table_payment',
					'type'		=> 'credit'
				]
			]
		];
	}


    protected function getCharge(array $input, array $totals, Bag &$active_bag)
    {
		if ($input["payment_method"] == "paypal") {
			return $this->getPaypalRedirect($input, $totals, $active_bag);
		}

		return $this->getConketaCharge($input, $totals, $active_bag);
    }

    protected function bagToPayment(Bag &$active_bag, $charge, $totals, $input, $in_ZMVM)
    {
        $response = [
            'errors' => null, // por si algo sale mal
        ];

		// verificamos el cobro
		if (array_sum($totals) < 0) {
			$totals["credit"] = $totals["credit"]-array_sum($totals);
		}

        // guardamos el cobro
        $save_charge_responce = $active_bag->saveCharge($charge, $totals);
        if ($save_charge_responce["error"]) {
            $response['errors'][] = $save_charge_responce["error"];
        }

		// guardamos el código relacionado con un bag.
		if (isset($input["discount_code"]) && !empty($input['discount_code'])) {
			$save_discount_responce = $active_bag->saveDiscount($input, $totals);
			if ($save_discount_responce["error"]) {
				$response['errors'][] = $save_discount_responce["error"];
			}
		}

        // guardamos el shipping
        if (!$active_bag->bagType->event || $active_bag->bagType->special ) {

			if (isset($input["address"]) && is_array($input["address"])) {
				$save_shipping_responce = $active_bag->saveShipping($input, $totals);
				if ($save_shipping_responce["error"]) {
					$response['errors'][] = $save_shipping_responce["error"];
				}
			}

        }

        // guardamos el user
        $save_bag_user_responce = $active_bag->saveBagUser($input, $this->user);
        if ($save_bag_user_responce["error"]) {
            $response['errors'][] = $save_bag_user_responce["error"];
        }

        // guardamos los skus
        $save_bag_sku_responce = $active_bag->saveBagSku($in_ZMVM);
        if ($save_bag_user_responce["error"]) {
            $response['errors'][] = $save_bag_user_responce["error"];
        }

        // Si el bag es de tipo evento guardamos los skus en la bolsa protegida del evento
        if ($active_bag->bagType->event && !$active_bag->bagType->special && $charge->status == 'paid') {
            $save__protected_bag_sku_responce = $active_bag->updateProtectedBag();
            if ($save__protected_bag_sku_responce["error"]) {
                $response['errors'][] = $save__protected_bag_sku_responce["error"];
            }
        }

        // status de venta
        if ($charge->status == "paid") {
            $new_sale_status = BagStatus::getStatusPaid();
        } else {
            $new_sale_status = BagStatus::getStatusPendingPayment();
        }

        $active_bag->message        = isset($input['message']) && !empty($input['message']) ? $input["message"] : null;
        $active_bag->print_message  = isset($input['print_message']);
        $active_bag->purshased_at   = date("Y-m-d H:i:s");
        $active_bag->bag_status_id  = $new_sale_status->id;

        if (!$active_bag->save()) {
            $response['errors'][] = trans('checkout.errors.saving_shipping_cart');
        }

        return $response;
    }

    protected function sendFatalErrorMail($error_data)
    {
        $code = trans('checkout.errors.saving');
        return Mail::to('hola@elcultivo.mx')->send(new FatalErrorMail($code, $error_data));
    }
}
