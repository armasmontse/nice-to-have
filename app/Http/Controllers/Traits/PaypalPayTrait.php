<?php

namespace App\Http\Controllers\Traits;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use Illuminate\Support\Facades\Redis;

use App\Models\Shop\Bag;

use Exception;

trait PaypalPayTrait
{

	protected function getPaypalContext()
	{
		return new ApiContext(
			new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret'))
		);
	}



	protected function getPaypalRedirect(array $input, array $totals, Bag &$active_bag)
    {

        $charge_responce = [
			"paypal_url" => null,
            "errors"    => null,
            "charge"     => null
        ];


		try {
			$payment = (new Payment)->setIntent('sale')
				->setPayer( (new Payer())->setPaymentMethod("paypal") )
				->setRedirectUrls(
						(new RedirectUrls())
							->setReturnUrl(
								is_page('client::bag.checkout:post') ? route('client::bag.paypal.return', $active_bag->key) : route('user::events.bag.paypal.return', [
									"personal_event" => $active_bag->event->slug,
									"user"		=> $this->user->name,
								])
							)
						    ->setCancelUrl(
								is_page('client::bag.checkout:post') ? route('client::bag.paypal.cancel', $active_bag->key) : route('user::events.bag.paypal.cancel', [
									"personal_event" => $active_bag->event->slug,
									"user"		=> $this->user->name,
								])
							)
					)
				->setTransactions([
					$this->getPaypalTransactionForBag($input, $totals, $active_bag),
				])
				->create($this->getPaypalContext());

		} catch (Exception $e) {
						dd($e);
			$charge_responce["errors"] = $e->getMessage();
			return $charge_responce;
		}

		$charge_responce["paypal_url"] = $payment->getApprovalLink();

		Redis::set($active_bag->redis_paypal_key,serialize([
			 "totals" 		=> $totals,
			 "input" 		=> $input,
			 "payment_id"	=> $payment->getId(),
		]));

		try {
			unserialize(Redis::get($active_bag->redis_paypal_key));
		} catch (Exception $e) {
			$charge_responce["errors"] = trans('checkout.errors.paypal.unserialize');
			return  $charge_responce;
		}

        return $charge_responce;
    }

	protected function getPaypalTransactionForBag(array $input, array $totals, Bag $active_bag){
		$items = $active_bag->getItemsForPaypal();

		// Si se ingresó un codigo de descuento lo buscamos y lo agregamos al array para el cobro
        if (isset($input['discount_code']) && !empty($input['discount_code'])) {
			$items[] = (new item)->setCurrency("MXN")
				->setName($input['discount_code'])
				->setQuantity(1)
				->setPrice(round($totals["discount"],2));
        }

		if (!empty($totals["print_message"])) {
			$items[] = (new item)->setCurrency("MXN")
				->setName("Tarjeta impresa con mensaje")
				->setQuantity(1)
				->setPrice(round($totals["print_message"],2));
		}

		// Si se ingresó un codigo de descuento lo buscamos y lo agregamos al array para el cobro
        if (isset($totals["credit"]) && !empty($totals["credit"])) {
			$items[] = (new item)->setCurrency("MXN")
				->setName("Saldo")
				->setQuantity(1)
				->setPrice(round($totals["credit"],2));
        }

		$details = new Details();
		$description = trans('checkout.general.purchase_nth') . ', key: ' . $active_bag->key . '. ';

		if ($active_bag->bagType->event && !$active_bag->bagType->special) {
            $description .= trans('checkout.general.gift_registry') . ': ' . $active_bag->event->key;
		}else {
			$details->setShipping($totals["shipping_rate"])
			    ->setSubtotal(round(array_sum($totals) - $totals["shipping_rate"] ,2) );
		}


		// dd($details,$items);
		return (new Transaction())->setAmount(
				(new Amount())->setCurrency("MXN")
				    ->setTotal(round(array_sum($totals),2))
				    ->setDetails($details)
			)
		    ->setItemList((new ItemList)->setItems($items) )
		    ->setDescription($description);
	}


	protected function getPaypalCharge(array $input, Bag &$active_bag)
	{

		$charge_responce = [
			"paypal_url" => null,
			"errors"    => null,
			"charge"     => null
		];

		try {
			$charge_responce["info"] = unserialize(Redis::get($active_bag->redis_paypal_key));
		} catch (Exception $e) {
			$charge_responce["errors"] = trans('checkout.errors.paypal.unserialize');
			return  $charge_responce;
		}

		if ($charge_responce["info"]["payment_id"] != $input["paymentId"] ) {
			$charge_responce["errors"] = trans('checkout.errors.paypal.error_payment_id');
			return  $charge_responce;
		}

		try {
			$payment = Payment::get($input["paymentId"], $this->getPaypalContext())
				->execute((new PaymentExecution())->setPayerId($input["PayerID"]), $this->getPaypalContext());
		} catch (Exception $e) {
			$charge_responce["errors"] = trans('checkout.errors.paypal.error_get_payment');
			return  $charge_responce;
		}

		try {
			$type = $payment->transactions[0]->related_resources[0]->sale->payment_mode;
		} catch (Exception $e) {
			$type = "";
		}


		$charge_responce["charge"]    = (object) [
			'id'			=> $payment->getId(),
			'status' 		=> $payment->getState() == 'approved' ? "paid" : $payment->getState(),
			'payment_method'=> (object)[
				'object'	=> 'paypal',
				'type'		=>  $type,
			]
		];

		return $charge_responce;
	}



}
