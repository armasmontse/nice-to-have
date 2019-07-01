<?php

namespace App\Http\Controllers\Users\Bags;

use Illuminate\Http\Request;
use App\Http\Requests\Users\Bags\CreateBillingRequest;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\User;

use App\Models\Shop\Bag;
use App\Models\Shop\bagBilling;

use App\Models\Address\Country;
use App\Models\Address\Address;

use Redirect;

use App\Setting;

use App\Notifications\Users\Shop\BillingSuccessRequestNotification;
use App\Notifications\Admin\Shop\AdminBillingSuccessRequestNotification;

class PersonalBagsController extends ClientController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBilling(CreateBillingRequest $request,User $user, Bag $personal_bag)
    {

        if ($personal_bag->bagBilling && $personal_bag->bagBilling->request) {
            return Redirect::route("user::bag.thankyou-page.billing:get",[$this->user->name,$personal_bag->key])->withErrors([trans('bag.errors.bill')]);
        }


        $input = $request->all();



        $address= Address::create($input["address"]);

        if (!$address) {
            return Redirect::back()->withInput()->withErrors([trans('bag.errors.address')]);
        }

        $bagBilling_args = [
            'bag_id'        => $personal_bag->id,
            'address_id'    => $address->id,

            'rfc'           => $input["rfc"],
            'razon_social'  => $input["razon_social"],
            'info'          => $input["info"] ,

            'status'        => "Requerida",
            'request'       => true,
        ];

        $bag_bagBilling = $personal_bag->bagBilling;

        if (!$bag_bagBilling) {
            $bag_bagBilling = bagBilling::create( $bagBilling_args );

            if (!$bag_bagBilling) {
                return Redirect::back()->withInput()->withErrors([trans('bag.errors.send_request')]);
            }
        }else{

            foreach ($bagBilling_args as $key => $bagBilling_arg) {
                $bag_bagBilling->$key = $bagBilling_arg;
            }

            if (!$bag_bagBilling->save()) {
                return Redirect::back()->withInput()->withErrors([trans('bag.errors.send_request')]);
            }
        }

        $user->notify(new BillingSuccessRequestNotification(['personal_bag' => $personal_bag]));

        AdminBillingSuccessRequestNotification::AdminNotify(['personal_bag' => $personal_bag]);

        return Redirect::route("user::bag.thankyou-page.billing:get",[$this->user->name,$personal_bag->key])->with('status', trans('bag.bill_required_ok'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showBilling(User $user, Bag $personal_bag)
    {
        $bag_totals = [
            "subtotal"      => $personal_bag->bag_totals["price_with_discounts"]*(1/(1+16/100) ),
            "iva"           => $personal_bag->bag_totals["price_with_discounts"]*(1-1/(1+16/100) ),
            "envio"         => $personal_bag->bagShipping ? $personal_bag->bagShipping->rate : 0.0,
            "print_message" => is_array($personal_bag->bagPayment->extra_info)  && isset($personal_bag->bagPayment->extra_info["print_message_cost"]) ?  $personal_bag->bagPayment->extra_info["print_message_cost"] : 0.0 ,
        ];

        $data = [
            "bag"               => $personal_bag,
            "bag_billing"       => $personal_bag->bagBilling,
            "countries_list"        => Country::with("languages")
                                        ->OrderedBy("official_name")
                                        ->where(["iso3166" => "MX"])
                                        ->get()
                                        ->pluck("official_name","id"),
            'mexico_states_and_mun' => Country::getMexicoStatesiWithMunicipies(),
        ];

        return view("client.checkout.invoice",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Bag $personal_admin_bag)
    {
        $bag_totals = [
            "subtotal"      => $personal_admin_bag->bag_totals["price_with_discounts"]*(1/(1+16/100) ),
            "iva"           => $personal_admin_bag->bag_totals["price_with_discounts"]*(1-1/(1+16/100) ),
            "envio"         => $personal_admin_bag->bagShipping ? $personal_admin_bag->bagShipping->rate : 0.0,
            "print_message" => $personal_admin_bag->bagPayment && is_array($personal_admin_bag->bagPayment->extra_info)  && isset($personal_admin_bag->bagPayment->extra_info["print_message_cost"]) ?  $personal_admin_bag->bagPayment->extra_info["print_message_cost"] : 0.0 ,
            "discount"      => $personal_admin_bag->bagDiscount ? -$personal_admin_bag->bagDiscount->amount : -0,
			"total_credit"	=> -($personal_admin_bag->bagPayment->total_credit),
        ];

        $data = [
            "bag"                   => $personal_admin_bag,
            "bag_totals"            => $bag_totals,
            "products_to_buy"       => $this->content_bags->filter(function($bag){
                return $bag["total"] > 0;
            })->isEmpty()
        ];

        return view("client.checkout.thank-you",$data);
    }


}
