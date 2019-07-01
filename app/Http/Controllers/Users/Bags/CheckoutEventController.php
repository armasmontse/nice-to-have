<?php

namespace App\Http\Controllers\Users\Bags;

use Illuminate\Http\Request;

use App\User;
use App\Setting;

use Redirect;

use App\Http\Controllers\Traits\PayBagTrait;
use App\Http\Controllers\Traits\ConektaPayTrait;
use App\Http\Controllers\Traits\PaypalPayTrait;

use App\Http\Controllers\ClientController;

use App\Http\Requests;
use App\Http\Requests\Users\Bags\CheckoutEventRequest;

use App\Models\Address\Country;
use App\Models\Address\Address;

use App\Models\Events\Event;

use App\Models\Shop\Bag;
use App\Models\Shop\BagStatus;

use App\Models\Shop\Discounts\DiscountCode;
use App\Models\Shop\Discounts\DiscountCodeType;

use App\Models\Products\Product;

use App\Models\Users\Card;
use App\Models\Users\BankAccount;

use App\Notifications\Users\Events\CashOutsSuccessRequestNotification;
use App\Notifications\Users\Shop\BuySuccessNotification;

use App\Notifications\Admin\Events\AdminCashOutsSuccessRequestNotification;
use App\Notifications\Admin\Shop\AdminBuyNotification;

class CheckoutEventController extends ClientController
{

    use PayBagTrait;
    use ConektaPayTrait;
    use PaypalPayTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, Event $personal_event)
    {
        abort_if(!$personal_event->is_finish || !$personal_event->is_close_bag_active, 404);

        $active_bag = $personal_event->getCloseBag();

		if ($this->event_close_bag->key != $active_bag->key ) {
		    return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        if ($active_bag->skus->isEmpty() ) {
            return Redirect::route("user::events.bag.index", [$this->user->name,$personal_event->slug])->withErrors([trans('checkout.errors.empty_shopping_cart')]);
        }

        $errors = $active_bag->getErrorForNotPublicPoducts();

        if ( !empty($errors) ) {
            return Redirect::route("user::events.bag.index",[$this->user->name,$personal_event->slug])->withErrors($errors);
        }

        $data = [
            "personal_event"        => $personal_event,
            "bag"                   => $active_bag,
            "products"              => $active_bag->getProducts(),
            "address"               => $personal_event->getMainAddress(),
            "countries_list"        => Country::with("languages")
                                        ->where(["iso3166" => "MX"])
                                        ->orderedBy("official_name")
                                        ->get()
                                        ->pluck("official_name","id"),
            'cashout_min_amount'    => Setting::getCashoutMinAmount(),
            'mexico_states_and_mun' => Country::getMexicoStatesiWithMunicipies(),
            "cards"                 => $this->user->cards,
            "print_message_const"   => Setting::getPrintMessageCost(),
            'discount_codes_types'  => DiscountCodeType::all(),
        ];

        return view("users.events.checkout.create", $data);
    }


    public function store(CheckoutEventRequest $request, User $user, Event $personal_event)
    {
        abort_if(!$personal_event->is_finish || !$personal_event->is_close_bag_active, 404);

        $active_bag = $personal_event->getCloseBag()->load("event");

		if ($this->event_close_bag->key != $active_bag->key ) {
				return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        if ($active_bag->skus->isEmpty() && !$personal_event->close_empty_bag) {
            return Redirect::route("client::bags.index")->withErrors([trans('checkout.errors.empty_shopping_cart')]);
        }

        $errors = $active_bag->getErrorForNotPublicPoducts();
        if ( !empty($errors) ) {
            return Redirect::route("client::bags.index")->withErrors($errors);
        }

        $input = $request->all();

        // verificamos el monto del cobro

        $totals = [
            "subtotal"          => $active_bag->bag_totals["price_with_discounts"],
            "shipping_rate"     => 0.0,
            "discount"          => -0.0,
			"credit"			=> round((-$personal_event->current_total),2)
        ];

		$input["in_ZMVM"] = false;

		if (!$personal_event->close_empty_bag) {
			$input["in_ZMVM"]                 =  Country::inZMVM($input["address"]["state"],$input["address"]["street2"]);
			$totals["shipping_rate"] += $input["in_ZMVM"] ? $active_bag->bag_totals["local_shipping_rate"] : $active_bag->bag_totals["national_shipping_rate"] ;
		}

        // Si se ingresó un codigo de descuento lo buscamos y lo agregamos al array para el cobro
        if (isset($input['discount_code']) && !empty($input['discount_code'])) {
            $discount_code = DiscountCode::where('code', $input['discount_code'])->with('discountCodeType')->first();
            if ($discount_code->discountCodeType->percent && !$discount_code->discountCodeType->shipment && !$discount_code->discountCodeType->value) {
                $totals["discount"] = round((-(($totals['shipping_rate'] + $totals['subtotal'])*($discount_code->value/100))),2);
            }elseif (!$discount_code->discountCodeType->percent && $discount_code->discountCodeType->shipment && !$discount_code->discountCodeType->value) {
                $totals["discount"] = round((-($totals['shipping_rate'])),2);
            }elseif (!$discount_code->discountCodeType->percent && !$discount_code->discountCodeType->shipment && $discount_code->discountCodeType->value) {
                $totals["discount"] = round((-($discount_code->value)),2);
            }
        }

		$total = array_sum($totals);
		$input_total = floatval($input["order_total"]) + floatval($input["cash_out_total"]);

        if ( abs(   $total + ( $total > 0 ? - $input_total : $input_total )  ) >= 0.1  ) {
            return Redirect::back()->withInput()->withErrors([trans('checkout.errors.payment')]);
        }

    // actualizamos al usuario
        $this->user->first_name = $input["first_name"];
        $this->user->last_name  = $input["last_name"];
        $this->user->phone      = $input["phone"];
		$this->user->save();

	// actualizamos la informacion del evento
		if (!$personal_event->close_empty_bag) {
			if ( !$personal_event->updateAddressToUse($input["address"], "main")  ) {
				return Redirect::back()->withInput()->withErrors([trans('checkout.errors.address')]);
			}
		}


/////////////////
        // intentamos el cobro
        $charge_responce = $this->getEventCharge($input,$totals,$active_bag);

        if ($charge_responce["errors"]) {
            return Redirect::back()->withInput()->withErrors($charge_responce["errors"]);
        }

        if ($charge_responce["paypal_url"] && !$charge_responce["charge"]) {
            return Redirect::to($charge_responce["paypal_url"]);
        }

        // Actualizamos la base de datos
        $db_update_responce = $this->bagToPayment($active_bag, $charge_responce["charge"], $totals, $input, $input["in_ZMVM"]);

		if ($db_update_responce['errors'] ) {
            $error_data = [
                "key"   => 'ID de compra: #'. strtoupper($active_bag->key),
                "error" => $db_update_responce['errors'],
            ];
            $this->sendFatalErrorMail($error_data);
        }

		// generamos el cashout_en su caso
		if (array_sum($totals) < 0) {
			$db_cash_out_responce = $this->bagToCashOut($personal_event,$totals, $input);

			if ($db_cash_out_responce['errors'] ) {
				$error_data = [
					"key"   => 'ID de compra: #'. strtoupper($active_bag->key),
					"error" => $db_cash_out_responce['errors'],
				];

				$this->sendFatalErrorMail($error_data);
			}
		}

		$refresh_bag = Bag::where('key', $active_bag->key)->get()->first();

        if ($refresh_bag->bagStatus->paid && !$refresh_bag->bagStatus->cancel) {
            $this->user->notify(new BuySuccessNotification($refresh_bag));
    		AdminBuyNotification::AdminNotify([ "active_bag" => $refresh_bag ]);
        }


        return Redirect::to( $refresh_bag->thank_you_page_url )
                ->with('status', trans('checkout.success'))
                ->with('just_buy', true);
    }


    public function paypalReturn(Request $request,User $user, Event $personal_event )
    {
        abort_if(!$personal_event->is_finish || !$personal_event->is_close_bag_active, 404);

        $input = $request->all();

        $active_bag = $personal_event->getCloseBag()->load("event");


        // intentamos el cobro
        $charge_responce = $this->getPaypalCharge($input, $active_bag);
    //
        if ($charge_responce["errors"]) {
            return Redirect::back()->withInput()->withErrors($charge_responce["errors"]);
        }
    //
    // Actualizamos la base de datos
        $db_update_responce = $this->bagToPayment($active_bag, $charge_responce["charge"], $charge_responce["info"]["totals"],  $charge_responce["info"]["input"],  $charge_responce["info"]["input"]["in_ZMVM"]);

    	if ($db_update_responce['errors'] ) {
            $error_data = [
                "key"   => 'ID de compra: #'. strtoupper($active_bag->key),
                "error" => $db_update_responce['errors'],
            ];
            $this->sendFatalErrorMail($error_data);
        }

    	// generamos el cashout_en su caso
    	if (array_sum($charge_responce["info"]["totals"]) < 0) {
    		$db_cash_out_responce = $this->bagToCashOut($personal_event,$charge_responce["info"]["totals"], $charge_responce["info"]["input"]);

    		if ($db_cash_out_responce['errors'] ) {
    			$error_data = [
    				"key"   => 'ID de compra: #'. strtoupper($active_bag->key),
    				"error" => $db_cash_out_responce['errors'],
    			];

    			$this->sendFatalErrorMail($error_data);
    		}
    	}

    	$refresh_bag = Bag::where('key', $active_bag->key)->get()->first();

        if ($refresh_bag->bagStatus->paid && !$refresh_bag->bagStatus->cancel) {
            $this->user->notify(new BuySuccessNotification($refresh_bag));
    		AdminBuyNotification::AdminNotify([ "active_bag" => $refresh_bag ]);
        }


        return Redirect::to( $refresh_bag->thank_you_page_url )
                ->with('status', trans('checkout.success'))
                ->with('just_buy', true);
    }

    public function paypalCancel(Request $request,User $user, Event $personal_event )
    {
        abort_if(!$personal_event->is_finish || !$personal_event->is_close_bag_active, 404);

        $active_bag = $personal_event->getCloseBag()->load("event");

		if ($this->event_close_bag->key != $active_bag->key ) {
				return Redirect::to($this->event_close_bag->event->bag_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
		}

        if ($active_bag->skus->isEmpty() && !$personal_event->close_empty_bag) {
            return Redirect::route("client::bags.index")->withErrors([trans('checkout.errors.empty_shopping_cart')]);
        }

        $errors = $active_bag->getErrorForNotPublicPoducts();
        if ( !empty($errors) ) {
            return Redirect::route("client::bags.index")->withErrors($errors);
        }

        return Redirect::route("user::events.bag.checkout:get",[$user->name,$personal_event->slug])->withInput()->withErrors([trans('checkout.errors.paypal.error')]);
    }


	protected function getBankAccount(array $input)
	{
        $response = [
            'errors'            => null,
            'bank_account_id'   => null
        ];

		if (isset($input["bank_account_id"]) && !isset($input["other_bank_account"])) {
            $response['bank_account_id'] = $input["bank_account_id"];
            return $response;
		}

		$other_bank_account = BankAccount::create([
            "user_id"           => $this->user->id,
            "bank"              => $input["bank_account"]["bank"],
            "branch"            => $input["bank_account"]["branch"],
            "name"              => $input["bank_account"]["name"],
            "account_number"    => $input["bank_account"]["account_number"],
            "CLABE"             => $input["bank_account"]["CLABE"],
		]);

		if (!$other_bank_account) {
            $response['errors'] = [trans('checkout.errors.bank_account_no_saved')];
            return $response;
		}

        $response['bank_account_id'] = $other_bank_account->id;

		return $response;
	}

	protected function bagToCashOut(Event $personal_event, array $totals, array $input)
	{
		$response = [
            'errors' => null, // por si algo sale mal
        ];

        // guardamos el cobro
        $responce_bank_account = $this->getBankAccount($input);

		if ($responce_bank_account["errors"]) {
			$charge_responce["errors"] = $responce_bank_account["errors"];
			return $charge_responce;
		}

		$bank_account_id = $responce_bank_account["bank_account_id"];

		$save_cash_out_responce = $personal_event->saveCashOut($bank_account_id,-array_sum($totals) );

        if ($save_cash_out_responce["error"]) {
            $response['errors'][] = $save_cash_out_responce["error"];
        }else{
			$cash_out =  $save_cash_out_responce["cash_out"];

			$this->user->notify( new CashOutsSuccessRequestNotification([ 'personal_event' => $personal_event , 'cash_out' => $cash_out->load("bank_account") ]));

			AdminCashOutsSuccessRequestNotification::AdminNotify([ 'personal_event' => $personal_event , 'cash_out' => $cash_out->load("bank_account") ]);
		}

        return $response;
	}


}
