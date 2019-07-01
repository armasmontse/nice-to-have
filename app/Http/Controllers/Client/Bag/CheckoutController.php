<?php

namespace App\Http\Controllers\Client\Bag;

use Illuminate\Http\Request;

use App\Notifications\Users\Events\EventPresentNotification;
use App\Notifications\Users\Shop\BuySuccessNotification;
use App\Notifications\Admin\Shop\AdminBuyNotification;
use App\Notifications\Users\Shop\PresentNotification;

use App\Http\Requests\Client\Bag\CheckoutRequest;

use App\Http\Controllers\Traits\PayBagTrait;
use App\Http\Controllers\Traits\ConektaPayTrait;
use App\Http\Controllers\Traits\PaypalPayTrait;


use App\Http\Controllers\ClientController;
use App\Http\Requests;

use App\Models\Shop\Discounts\DiscountCode;
use App\Models\Shop\Discounts\DiscountCodeType;
use App\Models\Address\Country;
use App\Models\Shop\Bag;

use App\Setting;
use App\User;

use Redirect;

class CheckoutController extends ClientController
{
    use PayBagTrait;
    use ConektaPayTrait;
    use PaypalPayTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login( Bag $active_bag)
    {
        return view("auth.register");
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bag $active_bag)
    {
		if ($this->event_close_bag) {
			return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        if ($active_bag->skus->isEmpty()) {
            return Redirect::route("client::bags.index")->withErrors([trans('checkout.errors.empty_shopping_cart')]);
        }

        $errors = $active_bag->getErrorForNotPublicPoducts();

        if (!empty($errors)) {
            return Redirect::route("client::bags.index")->withErrors($errors);
        }

        $data = [
            "bag"                   => $active_bag,
            "cards"                 => $this->user->cards,
            "address"               => $this->user->getMainAddress(),
            "products"              => $active_bag->getProducts(),
            "countries_list"        => Country::orderedBy("official_name")->byIso('MX')->get()->pluck('official_name', 'id'),
            "print_message_const"   => Setting::getPrintMessageCost(),
            'mexico_states_and_mun' => Country::getMexicoStatesiWithMunicipies(),
            'discount_codes_types'  => DiscountCodeType::all(),
        ];

        return view("client.checkout.create",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request, Bag $active_bag)
    {
        // Si hay bolsa de evento sin cerrar no te deja terminar la compra.
		if ($this->event_close_bag) {
			return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        // Si la bolsa está vacía
        if ($active_bag->skus->isEmpty()) {
            return Redirect::route("client::bags.index")->withErrors([trans('checkout.errors.empty_shopping_cart')]);
        }

        // Errores por si tienes productos en tu bolsa que no están publicados.
        $errors = $active_bag->getErrorForNotPublicPoducts();
        if (!empty($errors)) {
            return Redirect::route("client::bags.index")->withErrors($errors);
        }

        // Obtener los inputs
        $input = $request->all();
        // Inicializa la variables gift para saber si es un regalo
        $input["gift"] = isset($input['message']) && !empty($input['message']) && !isset($input['print_message']) ? true : false;

        // Monto del cobro
        $totals = [
            "subtotal"          => $active_bag->bag_totals["price_with_discounts"],
            "shipping_rate"     => 0.0,
            "print_message"     => round(isset($input["print_message"]) ? Setting::getPrintMessageCost() : 0.0, 2),
            "discount"          => -0.0,
        ];

        // Inicializa la variable inZMVM para saber si la venta es dentro se la zona metropolitana
        $input["in_ZMVM"] = false;

        // Si la venta no es tipo de evento se cobra el envío
        if (!$active_bag->bagType->event) {
            $input["in_ZMVM"] = Country::inZMVM($input["address"]["state"],$input["address"]["street2"]);
            $totals["shipping_rate"] = $input["in_ZMVM"] ? $active_bag->bag_totals["local_shipping_rate"] : $active_bag->bag_totals["national_shipping_rate"] ;
        }

        // Si se ingresó un codigo de descuento lo buscamos y lo agregamos al array para el cobro
        if (isset($input['discount_code']) && !empty($input['discount_code'])) {
            $discount_code = DiscountCode::where('code', $input['discount_code'])->with('discountCodeType')->first();

            if ($discount_code->discountCodeType->percent && !$discount_code->discountCodeType->shipment && !$discount_code->discountCodeType->value) {
                $totals["discount"] = round((-(($totals['shipping_rate'] + $totals['subtotal']+$totals['print_message'])*($discount_code->value/100))),2);
            }elseif (!$discount_code->discountCodeType->percent && $discount_code->discountCodeType->shipment && !$discount_code->discountCodeType->value) {
                $totals["discount"] = round((-($totals['shipping_rate'])),2);
            }elseif (!$discount_code->discountCodeType->percent && !$discount_code->discountCodeType->shipment && $discount_code->discountCodeType->value) {
                $totals["discount"] = round((-($discount_code->value)),2);
            }
        }

        if ( abs(array_sum($totals) - floatval($input["order_total"])) >= 0.1  ) {
            return Redirect::back()->withInput()->withErrors([trans('checkout.errors.payment')]);
        }

        // actualizamos al usuario
        $this->user->first_name = $input["first_name"];
        $this->user->last_name  = $input["last_name"];
        $this->user->phone      = $input["phone"];

        $this->user->save();

        if(!$active_bag->bagType->event && !$input["gift"]){
            if ( !$this->user->updateAddressToUse($input["address"], "main")  ) {
                return Redirect::back()->withInput()->withErrors([trans('checkout.errors.address')]);
            }
        }

////////
        // intentamos el cobro
        $charge_responce = $this->getCharge($input, $totals, $active_bag);

        if ($charge_responce["errors"]) {
            return Redirect::back()->withInput()->withErrors($charge_responce["errors"]);
        }

        if ($charge_responce["paypal_url"] && !$charge_responce["charge"]) {
            return Redirect::to($charge_responce["paypal_url"]);
        }

        $charge = $charge_responce["charge"];

        // Actualizamos la base de datos
        $db_update_responce = $this->bagToPayment($active_bag, $charge, $totals, $input, $input["in_ZMVM"]);

        if ($db_update_responce['errors'] ) {

            $error_data = [
                "key"   => 'ID de compra: #'. strtoupper($active_bag->key),
                "error" => $db_update_responce['errors'],
            ];

            $this->sendFatalErrorMail($error_data);

        }

        $refresh_bag = Bag::where('key', $active_bag->key)->get()->first();

        if ($refresh_bag->bagStatus->paid && !$refresh_bag->bagStatus->cancel) {

            $this->user->notify(new BuySuccessNotification($refresh_bag));

    		AdminBuyNotification::AdminNotify([ "active_bag" => $refresh_bag ]);

            if ($active_bag->bagType->event) {

                $refresh_bag->event->user->notify(new EventPresentNotification($refresh_bag));

            }elseif(!$active_bag->bagType->event && $input["gift"]) {

                $friend = new User();
                $friend->email = $input["address"]['email'];
                $friend->name = $input["address"]['contact_name'];
                $friend->notify(new PresentNotification($refresh_bag));
            }

        }

        return Redirect::to( $active_bag->thank_you_page_url )
                ->with('status', trans('checkout.success'))
                ->with('just_buy', true);
    }


    public function paypalReturn(Request $request, Bag $active_bag )
    {
        $input = $request->all();

        // intentamos el cobro
        $charge_responce = $this->getPaypalCharge($input, $active_bag);

        if ($charge_responce["errors"]) {
            return Redirect::back()->withInput()->withErrors($charge_responce["errors"]);
        }

        $charge = $charge_responce["charge"];

        // Actualizamos la base de datos
        $db_update_responce = $this->bagToPayment($active_bag, $charge_responce["charge"], $charge_responce["info"]["totals"],  $charge_responce["info"]["input"],  $charge_responce["info"]["input"]["in_ZMVM"]);

        if ($db_update_responce['errors'] ) {

            $error_data = [
                "key"   => 'ID de compra: #'. strtoupper($active_bag->key),
                "error" => $db_update_responce['errors'],
            ];

            $this->sendFatalErrorMail($error_data);

        }

        $refresh_bag = Bag::where('key', $active_bag->key)->get()->first();

        if ($refresh_bag->bagStatus->paid && !$refresh_bag->bagStatus->cancel) {

            $this->user->notify(new BuySuccessNotification($refresh_bag));

    		AdminBuyNotification::AdminNotify([ "active_bag" => $refresh_bag ]);

            if ($active_bag->bagType->event) {

                $refresh_bag->event->user->notify(new EventPresentNotification($refresh_bag));

            }elseif(!$active_bag->bagType->event && $charge_responce["info"]["input"]["gift"]) {

                $friend = new User();
                $friend->email = $charge_responce["info"]["input"]["address"]['email'];
                $friend->name = $charge_responce["info"]["input"]["address"]['contact_name'];
                $friend->notify(new PresentNotification($refresh_bag));
            }

        }

        return Redirect::to( $active_bag->thank_you_page_url )
                ->with('status', trans('checkout.success'))
                ->with('just_buy', true);
    }

    public function paypalCancel(Request $request, Bag $active_bag )
    {
        // Si hay bolsa de evento sin cerrar no te deja terminar la compra.
		if ($this->event_close_bag) {
			return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        // Si la bolsa está vacía
        if ($active_bag->skus->isEmpty()) {
            return Redirect::route("client::bags.index")->withErrors([trans('checkout.errors.empty_shopping_cart')]);
        }

        // Errores por si tienes productos en tu bolsa que no están publicados.
        $errors = $active_bag->getErrorForNotPublicPoducts();
        if (!empty($errors)) {
            return Redirect::route("client::bags.index")->withErrors($errors);
        }

        return Redirect::route("client::bag.checkout:get",$active_bag->key)->withInput()->withErrors([trans('checkout.errors.paypal.error')]);

    }
}
