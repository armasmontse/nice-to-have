<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\Admin\Settings\UpdateSettingRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Setting;

use Response;
use Redirect;

class ManageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'setting_description'               => Setting::getDescription(),
            'setting_blog'                      => Setting::getBlog(),
            'setting_social'                    => Setting::getSocialNetworks(),
            'setting_copys'                     => Setting::getPagesCopys(),
            'setting_mail'                      => Setting::getMail(),
            'setting_card_cost'                 => Setting::getPrintMessageCost(),
			'setting_cashout_min_amount'		=> Setting::getCashoutMinAmount(),
			'setting_checkout_min'              => Setting::getCheckoutMinPercentage(),
            'setting_event_expiration'          => Setting::getEventExpiration(),
            'setting_shipment'                  => Setting::getShipment(),
            'setting_exchange_rate'             => Setting::getExchange(),
            'setting_register_image'            => Setting::getRegisterImage(),
            'setting_login_image'               => Setting::getLoginImage(),
            'setting_event_register_image'      => Setting::getEventRegisterImage(),
            'setting_checkout_register_image'   => Setting::getCheckoutRegisterImage(),
            'setting_authentication'            => Setting::getAuthentication(),
            'setting_create_event_images'       => Setting::getCreateEventImages(),
            'setting_event_image_search'        => Setting::getEventImageSearch(),
			'setting_cash_out_fees'       		=> Setting::getCashOutFeesPercentages(),
			'site_copys_by_page'				=> Setting::SITE_COPYS_ARRAY,
        ];
        return view('admin.settings.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, $setting_key)
    {
        $update_setting = Setting::where('key', $setting_key)->get()->first();

        if (!$update_setting) {
            return Redirect::back()->withErrors([trans('manage_settings.error.notexist')]);
        }

        $input = $request->except(["_token", "_method"]);

        if (array_has($input, 'files')) {
            unset($input['files']);
        }

        $update_setting->value = $input;

        if (!$update_setting->save()) {
            return Redirect::back()->withErrors([trans('manage_settings.error.cantsave')]);
        }

        return Redirect::back()->with('status', trans('manage_settings.'.$setting_key.'.title').': '.trans('manage_settings.success.update'));

    }

}
