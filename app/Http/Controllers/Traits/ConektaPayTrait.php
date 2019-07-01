<?php

namespace App\Http\Controllers\Traits;

use App\Setting;
use App\Models\Shop\Bag;

use App\Models\Address\Country;
use App\Models\Users\Card;

use Conekta;
use Conekta_Charge;
use Conekta_Customer;
use Conekta_Error;

trait ConektaPayTrait
{
	protected function getConketaCharge(array $input, array $totals, Bag &$active_bag)
    {

        $charge_responce = [
			"paypal_url" => null,
            "errors"    => null,
            "charge"     => null
        ];

        Conekta::setApiKey(env('CONEKTA_PRIVATE_KEY'));
        Conekta::setLocale($this->current_language->iso6391);

        $conekta_description = trans('checkout.general.purchase_nth') . ', key: ' . $active_bag->key . '. ';

        $conekta_details = [
            "name"              => $this->user->full_name,
            "phone"             => $this->user->phone,
            "email"             => $this->user->email,
            "line_items"        => $active_bag->getItemsForConekta(),
        ];

        if ($active_bag->bagType->event && !$active_bag->bagType->special) {
            $conekta_description .= trans('checkout.general.gift_registry') . ': ' . $active_bag->event->key;

            // $force_address = Setting::getShipment();
			//
            // if (!$force_address) {
            //     $charge_responce["errors"] = trans('checkout.errors.shipping_address');
            //     return $charge_responce;
            // }
			//
            // for ($i=1; $i <= 3 ; $i++) {    // se nombran los streets
            //     $force_address['origin-address']["street".$i] = $force_address['origin-address']["street-".$i];
            //     unset($force_address['origin-address']["street-".$i]);
            // }
			//
            // $country = Country::getCountryByName($force_address['origin-address']['country']);
			//
            // if (!$country) {
            //     $charge_responce["errors"] = trans('checkout.errors.shipping_address_country');
            //     return $charge_responce;
            // }
			//
            // $force_address['origin-address']['country'] = $country->iso3166;
			//
            // $conekta_details["shipment"] = [
            //     'carrier'   => 'NICE TO HAVE',
            //     'service'   => trans('checkout.general.no_shipping'),
            //     'price'     => 0,
            //     'address'   => $force_address['origin-address']
            // ];
        } else {
            $address              = $input["address"];
            $address["country"]   = Country::find($address["country_id"])->iso3166;

            unset($address["country_id"]);
            unset($address["contact_name"]);
            unset($address["phone"]);
            unset($address["references"]);

            $conekta_details["shipment"] = [
                'carrier'   => 'NICE TO HAVE',
                'service'   => trans('checkout.general.standard'),
                'price'     => intval($totals["shipping_rate"]*100),
                'address'   => $address
            ];
        }

        $conekta_charge = [
            "amount"        =>  intval(array_sum($totals)*100)  ,
            "currency"      => 'MXN',
            "description"   => $conekta_description,
            'reference_id'  => $active_bag->key,
            "details"       => $conekta_details,
        ];

        if ($input['payment_method'] == 'tarjeta') { // con tarjet
            $responce_card_token = $this->getCardToken($input);
            if ($responce_card_token["errors"]) {
                $charge_responce["errors"] = $responce_card_token["errors"];
                return $charge_responce;
            }
            $conekta_charge["card"] = $responce_card_token["card_token"];
        }

        if ($input['payment_method'] == 'spei') { // con spei
            $conekta_charge["bank"] = [
                "type"  => "spei"
            ];
        }

        // intento de cobro
        try {
            $charge = Conekta_Charge::create($conekta_charge);
        } catch (Conekta_Error $e) { // el pago no pudo ser procesado
            $charge_responce["errors"] = $e->message_to_purchaser;
            return $charge_responce;
        }

        $charge_responce["charge"] = $charge;
        return $charge_responce;
    }

    protected function getCardToken(array $input)
    {
        if (isset($input["card_id"]) && !isset($input["other_card"]) ) {  // si la tarjeta ya estaba guardada
            $card = Card::find($input["card_id"]);
            return [
                "errors"     => null,
                "card_token" => $card->conekta_token
            ];
        }

        try {
            $customer = Conekta_Customer::create([
                "name"  => $this->user->full_name,
                "phone" => $this->user->phone,
                "email" => $this->user->email,
                "cards" => [$input["conekta_token"]]   //"tok_a4Ff0dD2xYZZq82d9"
            ]);
        } catch (Conekta_Error $e) {
            return [ // en caso de no poder crear el usuario
                "errors"     => [$e->message_to_purchaser],
                "card_token" => null
            ];
        }

        $card = Card::create([
            'number'        => $input["card"]["last_digits"],
            'type'          => $input["card"]["provider"],
            'conekta_token' => $customer->id,
            'user_id'       => $this->user->id
        ]);

        if (!$card) { // si no se pudo guardar la tarjeta
            return [
                "errors"     => [trans('checkout.errors.card_no_saved')],
                "card_token" => null
            ];
        }

        return [
            "errors"     => null,
            "card_token" => $customer->id
        ];
    }

}
